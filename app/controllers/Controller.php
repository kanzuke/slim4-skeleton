<?php

    namespace App\Controllers;

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use \Psr\Container\ContainerInterface as ContainerInterface;

    class Controller {

        protected $container;

        protected $flash =[];



        function __construct(ContainerInterface $container) {
            $this->container = $container;
        }


        public function render(ResponseInterface $response, $file, $attrs = []) {
            $this->container->get('view')->render($response, $file, $attrs);
            return $response;
        }


        public function __get($name) {
            return $this->container->get($name);
        }


        public function setFlashError($error) {
            if(!$this->flash['error']) { $this->flash['error'] = []; }
            array_push($this->flash['error'], $error);
        }
        
        public function setFlashSuccess($success) {
            if(!$this->flash['success']) { $this->flash['success'] = []; }
            array_push($this->flash['success'], $success);
        }
        
        
        public function setFlashInfo($info) {
            if(!$this->flash['info']) { $this->flash['info'] = []; }
            array_push($this->flash['info'], $info);
        }
        
        public function setFlashInfoNoTitle($info) {
            if(!$this->flash['info_no_title']) { $this->flash['info_no_title'] = []; }
            array_push($this->flash['info_no_title'], $info);
        }



        public function getFlash () { return $this->flash; }

        public function clearFlash() { $this->flash = []; }


     



        protected function callAPI($method, $url, $data){
            $curl = curl_init();
            switch ($method){
               case "POST":
                  curl_setopt($curl, CURLOPT_POST, 1);
                  if ($data)
                     curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                  break;
               case "PUT":
                  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                  if ($data)
                     curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
                  break;
               default:
                  if ($data)
                     $url = sprintf("%s?%s", $url, http_build_query($data));
            }
            // OPTIONS:
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
               //'APIKEY: 111111111111111111111',
               'Content-Type: application/json'
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            // EXECUTE:
            $result = curl_exec($curl);
            if(!$result){die("Connection Failure");}
            curl_close($curl);
            return $result;
         }

    }