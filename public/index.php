<?php
    declare(strict_types=1);

    use Psr\Http\Message\ResponseInterface as ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface as RequestInterface;
    use DI\Container;
    use Slim\Factory\AppFactory;
    use Slim\Views\Twig;
    use Slim\Views\TwigMiddleware;
    
    use Twig\TwigFilter;
    use Twig\TwigFunction;



    require "../vendor/autoload.php";
    require "../config/settings.php";
    

    $container = new Container();
    AppFactory::setContainer($container);

    $container->set('view', function() {
        $dir = dirname(__DIR__);

        $view =  Twig::create($dir . '/app/views', [
            'cache' => false 
            //'cache' => $dir . '/tmp/cache'
        ]);

        $view->addExtension(new \Twig\Extension\DebugExtension());

        
        return $view;
    });
    
    try {
        $filter = new TwigFilter('base64', 'base64_encode');
        $container->get('view')->getEnvironment()->addFilter($filter);
        
        $filter = new TwigFilter('repeat', 'str_repeat');
        $container->get('view')->getEnvironment()->addFilter($filter);

    } catch (\Throwable $th) {
        print("merde");
    }


    $app = AppFactory::create();
    $app->setBasePath($GLOBALS['settings']['app']['basepath']);


    // Register middleware
    $middleware = require __DIR__ . '/../app/middleware.php';
    $middleware($app);
    
    // Register routes
    $routes = require __DIR__ . '/../app/routes.php';
    $routes($app);

    // Register app in controller
        

    // Run app
    $app->run();
?>