<?php
    declare(strict_types=1);

    namespace App\Controller;

    use Doctrine\ORM\EntityManager;
    use Psr\Container\ContainerExceptionInterface;
    use Psr\Container\NotFoundExceptionInterface;
    use Sunrise\Http\ServerRequest\ServerRequest as Request;
    use Twig\Environment;
    use Monolog\Logger;
    use Psr\Container\ContainerInterface;
    use Sunrise\Http\Message\Response as Response;
    use Sunrise\Http\Message\ResponseFactory;
    use Twig\Error\LoaderError;
    use Twig\Error\RuntimeError;
    use Twig\Error\SyntaxError;

    /**
     * This class is used to hold simple functionality which we may want to use in multiple places.
     */
    class BaseController
    {
        /**
         * @var array|mixed
         */
        protected array $config;
        protected EntityManager $entityManager;
        protected Environment $twig;
        protected Logger $logger;

        /**
         * @throws NotFoundExceptionInterface
         * @throws ContainerExceptionInterface
         */
        public function __construct(ContainerInterface $container)
        {
            $this->config = $_SESSION ?? $container->get('Config');
            $this->entityManager = $container->get(EntityManager::class);
            $this->twig = $container->get(Environment::class);
            $this->logger = $container->get(Logger::class);
        }

        public static function prettyPrint($data, bool $exit = false): void
        {
            print '<pre>' . print_r($data, true) . '</pre>';
            if ($exit) {
                exit;
            }
        }

        /**
         * @throws SyntaxError
         * @throws RuntimeError
         * @throws LoaderError
         */
        protected function render($content, array $properties = [], bool $isJson = false, $status_code = 200): Response
        {
            $db_loaded = $this->getIsDbLoaded();
            $base_properties = array_merge($properties, [
                'db_loaded' => $db_loaded
            ]);

            if (!$isJson) {
                $response = (new ResponseFactory)->createHtmlResponse($status_code, $this->twig->render($content, $properties));
            } else {
                $content = array_merge($base_properties, $content);
                $response = (new ResponseFactory)->createJsonResponse($status_code, $content);
            }

            return $response;
        }

        protected function getIsDbLoaded(): bool {
            return $this->config['db']['is_loaded'] ?? false;
        }

        protected function setIsDbLoaded(bool $is_loaded): void {
            $_SESSION['db']['is_loaded'] = $is_loaded;
            $this->config['db']['is_loaded'] = $is_loaded;
        }

        protected function validateDatabaseParams(Request $request): array
        {
            $this->logger->info('Testing database connection');
            // Check for valid request parameters
            $original_string = $request->getParsedBody()['connection'];
            $query_string = strip_tags(addslashes($original_string ?? ''));
            if (empty($query_string)) {
                $this->logger->error('Query string provided was unsafe or empty');
                return [];
            }
            // Params should now be clean, so we can perform a connection test
            parse_str($query_string, $db_params);
            return array_map('trim', $db_params);
        }

        /**
         * Tests the connection to the server, and then to the database.
         * @param array $db_params
         * @return array [bool, string]
         */
        protected function performConnectionTest(array $db_params): array
        {
            try {
                $this->getPDO($db_params);
            } catch (\PDOException|\Exception $e) {
                return [false, $e->getMessage() . "\nWith DSN: mysql:host={$db_params['server']};dbname={$db_params['database']}"];
            }
            return [true, 'Connection test successful'];
        }

        protected function saveConfig(string $key, array $values): void
        {
            foreach ($values as $_key => $value) {
                $_SESSION[$key][$_key] = $value;
            }
        }

        /**
         * Note: this method is really just for ensuring connectivity to the database.
         * @param array $db_params
         * @return \PDO
         */
        protected function getPDO(array $db_params): \PDO
        {
            try {
                $conn = new \PDO(
                    "mysql:host={$db_params['server']};dbname={$db_params['database']}",
                    $db_params['username'],
                    $db_params['password'],
                    [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                        \PDO::ATTR_EMULATE_PREPARES => false,
                        \PDO::ATTR_TIMEOUT => 5,
                        'charset' => 'utf8'
                    ]
                );
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
            return $conn;
        }
    }