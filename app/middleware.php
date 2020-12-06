<?php
declare(strict_types=1);

use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

use Zeuxisoo\Whoops\Slim\WhoopsMiddleware;

return function (App $app) {
    // Add Twig-View Middleware
    $app->add(TwigMiddleware::createFromContainer($app));


    // $app->addErrorMiddleWare(true, false, false);
    $app->add(new WhoopsMiddleware());
};