<?php
    declare(strict_types=1);

    session_start();

    use App\Controller\BaseController;
    use DI\Container;
    use DI\ContainerBuilder;
    use Doctrine\Common\Annotations\AnnotationRegistry;
    use Doctrine\DBAL\DriverManager;
    use Doctrine\ORM\EntityManager;
    use Doctrine\ORM\Tools\Setup;
    use Monolog\Handler\StreamHandler;
    use Monolog\Logger;
    use Sunrise\Http\Router\Loader\DescriptorLoader;
    use Sunrise\Http\Router\Router;
    use Twig\Environment;
    use Twig\Loader\FilesystemLoader;

    return (function(): Container {
        $builder = new ContainerBuilder();
        $builder->useAutowiring(true);
        $builder->useAnnotations(true);
        $builder->addDefinitions([
            'Config' => [
                'is_dev_mode' => IS_DEV_MODE,
                'cache' => CACHE,
                'annotation_reader' => ANNOTATION_READER,
                'entity_path' => ENTITY_PATH,
                'proxy_path' => PROXY_PATH,
                'cache_path' => CACHE_PATH,
                'root' => ROOT,
                'log_root' => LOG_ROOT,
                'maps_api_key' => MAPS_API_KEY,
                'db' => [
                    'is_loaded' => $_SESSION['db']['is_loaded'] ?? false
                ],
            ],
            Logger::class => function(): Logger {
                $logger = new Logger('dataview');
                $logger->pushHandler(new StreamHandler(LOG_ROOT . 'dataview.log', Logger::DEBUG));
                return $logger;
            },
            EntityManager::class => function(): EntityManager {
                $db_params = [
                    'dbname' => DB_NAME,
                    'user' => DB_USER,
                    'password' => DB_PASS,
                    'host' => DB_HOST,
                    'driver' => 'pdo_mysql'
                ];

                $config = Setup::createAnnotationMetadataConfiguration(
                    [ENTITY_PATH],
                    IS_DEV_MODE,
                    PROXY_PATH,
                    CACHE,
                    ANNOTATION_READER
                );
                $conn_obj = DriverManager::getConnection($db_params);
                return EntityManager::create($conn_obj, $config);
            },
            Router::class => function($container): Router {
                AnnotationRegistry::registerLoader('class_exists');

                $loader = new DescriptorLoader();
                $loader->setContainer($container);
                $loader->attach('../src/Controller');
                $router = new Router();
                $router->load($loader);
                return $router;
            },
            Environment::class => function($container): Environment {
                $twig = new Environment(
                    new FilesystemLoader(ROOT . '/src/View'),
                    [
                        'cache' => CACHE_PATH,
                        'debug' => IS_DEV_MODE,
                    ]
                );
                return $twig;
            },
            BaseController::class => function($container): BaseController {
                return new \App\Controller\BaseController($container);
            },
        ]);

        return $builder->build();
    })();
