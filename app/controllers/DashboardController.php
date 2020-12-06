<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;


use App\Helpers\ConfigHelper;
use App\Helpers\JSONHelper;

class DashboardController extends Controller {


    public function home(RequestInterface $request, ResponseInterface $response) {
        return $this->render($response, 'dashboard/home.twig', [
            "flash" => $this->getFlash()
        ]);
    }



}