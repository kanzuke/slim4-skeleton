<?php
    namespace App\Controllers\Api;

    
    use Psr\Http\Message\ResponseInterface as ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface as RequestInterface;


    use App\Controllers\Controller;

    use App\Helpers\ArrayHelper;
    use App\Helpers\ConfigHelper;
    use App\Helpers\JSONHelper;

    
    use OpenApi\Annotations as OA;

    /**
     * undocumented class
     */
    class APIController extends Controller {
        

        /**
         * undocumented function summary
         *
         * Undocumented function long description
         *
         * @param Type $var Description
         * @return type
         * @throws conditon
         **/
        public function output($response, $data, $httpcode = "200") {
            $format = ((isset($_GET['format'])) && ($_GET['format']!="") ? $_GET['format'] : "json");

            switch ($format) {
                case 'csv':
                    return $this->httpCSV($response, $data, $httpcode);
                default:
                    # code...
                    return $this->httpJSON($response, $data, $httpcode);
            }
        }



           
        /**
         * 
         */
        public function httpJSON($response, $data, $httpcode = "200") {
            $payload = json_encode($data);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus($httpcode);
        }






        public function httpCSV($response, $data, $httpcode) {
            // create csv file
            $stream = fopen('php://memory', 'w+');

            if(sizeof($data)>0) {
                // in case if it is  omniti-labs/jsend format
                $payload = $null;

                if($data['status'] == "success") {
                    $payload = $data['data'];
                }
                else {
                    $payload = $data[0];
                }


                $csv_header = array_keys($payload[0]);

                if($csv_header != $null) {
                    // write csv header
                    fputcsv($stream, $csv_header, ';');
    
                    for ($i=0; $i < sizeof($payload); $i++) { 
                        $attrs = array();
    
                        foreach ($csv_header as $key) {
                            array_push($attrs, $payload[$i][$key]);
                        }
    
                        fputcsv($stream, $attrs, ';');
                    }
                }
                else {
                    //fputcsv($stream, array("header"), ';');
                    for ($i=0; $i < sizeof($payload); $i++) { 
                        fputcsv($stream, array($payload[$i]), ';');
                    }
                }
                
            }
            else {
                fputcsv($stream, array("No result"), ';');
            }


            rewind($stream);
            
            // set filename
            $filename = date("Ymd-Hm")."_result.csv";
            
            $response = $response->withBody(new \Slim\Psr7\Stream($stream));
            $response = $response->withHeader("Content-Type", "text/csv")->withStatus($httpcode);
            $response = $response->withHeader("Content-Disposition", "attachment; filename=\"$filename\"");
            
            return $response;
        }

    }