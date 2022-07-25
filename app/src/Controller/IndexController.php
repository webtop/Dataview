<?php

    declare(strict_types=1);

    namespace App\Controller;

    use App\Controller\BaseController;
    use mysqli;
    use Sunrise\Http\Router\Annotation as Mapping;
    use Sunrise\Http\ServerRequest\ServerRequest as Request;
    use Sunrise\Http\Message\Response as Response;
    use Twig\Error\LoaderError;
    use Twig\Error\RuntimeError;
    use Twig\Error\SyntaxError;


    class IndexController extends BaseController
    {
        /**
         * @throws SyntaxError
         * @throws RuntimeError
         * @throws LoaderError
         */
        #[Mapping\Route('home', path: '/home')]
        public function home(Request $request): Response
        {
            return $this->render('index.html.twig');
        }

        /**
         * Requests a connection test to the database.
         * @throws RuntimeError
         * @throws SyntaxError
         * @throws LoaderError
         */
        #[Mapping\Route('test_database', path: '/test_database', method: 'POST')]
        public function testDatabase(Request $request): Response
        {
            $this->logger->info('Testing database connection');
            // Check for valid request parameters
            $original_string = $request->getParsedBody()['connection'];
            $query_string = strip_tags(addslashes($original_string ?? ''));
            if (empty($query_string)) {
                $this->logger->error('Query string provided was unsafe or empty');
                return $this->render('Partials/db_conn_test.html.twig', [
                    'db_loaded' => false,
                    'message' => 'No query string provided'
                ], false, 400);
            }
            // Params should now be clean, so we can perform a connection test
            parse_str($query_string, $db_params);
            $db_params = array_map('trim', $db_params);
            $result = [0, ''];
            try {
                $result = $this->performConnectionTest(
                    $db_params['server'], $db_params['username'],
                    $db_params['password'], $db_params['database']
                );
                $message = $result[1];
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $message = $e->getMessage();
            }

            return $this->render('Partials/db_conn_test.html.twig', [
                'db_loaded' => (int)$result[0],
                'message' => $message
            ]);
        }

        /**
         * Tests the connection to the server, and then to the database.
         * @param string $server
         * @param string $user
         * @param string $pass
         * @param string $db_name
         * @return array [bool, string]
         */
        private function performConnectionTest(string $server, string $user, string $pass, string $db_name): array
        {
            try {
                $conn = new \PDO(
                    "mysql:host={$server};dbname={$db_name}",
                    $user,
                    $pass,
                    ['charset' => 'utf8']
                );
            } catch (\PDOException $e) {
                return [false, $e->getMessage()];
            }
            return [true, 'Connection test successful'];
        }
    }