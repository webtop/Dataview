<?php
    declare(strict_types=1);

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
            'config' => [
                'db_host' => DB_HOST,
                'db_name' => DB_NAME,
                'db_user' => DB_USER,
                'db_pass' => DB_PASS,
                'db_pref' => DB_PREF,
                'is_dev_mode' => IS_DEV_MODE,
                'cache' => CACHE,
                'annotation_reader' => ANNOTATION_READER,
                'entity_path' => ENTITY_PATH,
                'proxy_path' => PROXY_PATH,
                'cache_path' => CACHE_PATH,
                'root' => ROOT,
                'log_root' => LOG_ROOT,
            ],
            'logger' => function() {
                $logger = new Logger('dataview');
                $logger->pushHandler(new StreamHandler(LOG_ROOT . 'dataview.log', Logger::DEBUG));
                return $logger;
            },
            'entity_manager' => function($container) {
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
            'router' => function($container) {
                AnnotationRegistry::registerLoader('class_exists');

                $loader = new DescriptorLoader();
                //$loader->setContainer($container);
                $loader->attach('../src/Controller');
                $router = new Router();
                $router->load($loader);
                return $router;
            },
            'twig' => function($container) {
                $twig = new Environment(
                    new FilesystemLoader(ROOT . '/src/View'),
                    [
                        'cache' => CACHE_PATH,
                        'debug' => IS_DEV_MODE,
                    ]
                );
                return $twig;
            },
        ]);

        return $builder->build();
    })();
