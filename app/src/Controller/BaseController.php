<?php
    declare(strict_types=1);

    namespace App\Controller;

    use Doctrine\ORM\EntityManager;
    use Psr\Container\ContainerExceptionInterface;
    use Psr\Container\NotFoundExceptionInterface;
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
        protected function render(string $content, array $properties = [], bool $isJson = false, $status_code = 200): Response
        {
            $base_properties = array_merge($properties, [
                'db_loaded' => $this->getIsDbLoaded()
            ]);

            if (!$isJson) {
                $html = $this->twig->render($content, $properties);
                $response = (new ResponseFactory)->createHtmlResponse($status_code, $html);
            } else {
                $json = json_encode($content);
                $response = (new ResponseFactory)->createJsonResponse($status_code, $json);
            }

            return $response;
        }

        protected function getIsDbLoaded(): bool {
            return $this->config['db']['is_loaded'] ?? false;
        }
    }