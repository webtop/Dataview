<?php
    declare(strict_types=1);

    use DI\Container;
    use Sunrise\Http\Router\RequestHandler\QueueableRequestHandler;
    use Sunrise\Http\Router\Router;
    use Sunrise\Http\ServerRequest\ServerRequestFactory;
    use function Sunrise\Http\Router\emit;

    require_once "../src/bootstrap.php";

    /** @var Container $container */
    try {
        $router = $container->get(Router::class);
        $handler = new QueueableRequestHandler($router);
        $request = ServerRequestFactory::fromGlobals();
        $response = $handler->handle($request);

        emit($response);

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }

        exit(0);

    } catch (\DI\DependencyException|\DI\NotFoundException $e) {
        try {
            $container->get('logger')->error($e->getMessage());
        } catch (Exception $e) {
            trigger_error($e->getMessage());
        }
    }
