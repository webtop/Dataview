<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../src/bootstrap.php';

    use App\Controller\BaseController;
    use DI\Container;
    use Sunrise\Http\Router\RequestHandler\QueueableRequestHandler;
    use Sunrise\Http\Router\Router;
    use Sunrise\Http\ServerRequest\ServerRequestFactory;
    use function Sunrise\Http\Router\emit;

    /** @var Container $container */
    try {
        $router = $container->get('router');
        $handler = new QueueableRequestHandler($router);
        $request = ServerRequestFactory::fromGlobals();
        //BaseController::PrettyPrint($container->get('twig'), true);
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
