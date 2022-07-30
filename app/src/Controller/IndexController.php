<?php

    declare(strict_types=1);

    namespace App\Controller;

    use App\Controller\BaseController;
    use Doctrine\Common\Collections\Criteria;
    use Doctrine\Inflector\Inflector;
    use Doctrine\Inflector\InflectorFactory;
    use Psr\Container\ContainerExceptionInterface;
    use Psr\Container\ContainerInterface;
    use Psr\Container\NotFoundExceptionInterface;
    use Sunrise\Http\Router\Annotation as Mapping;
    use Sunrise\Http\ServerRequest\ServerRequest as Request;
    use Sunrise\Http\Message\Response as Response;
    use Twig\Error\LoaderError;
    use Twig\Error\RuntimeError;
    use Twig\Error\SyntaxError;


    class IndexController extends BaseController
    {
        const PER_PAGE_RESULTS = 20;

        /**
         * @throws SyntaxError
         * @throws RuntimeError
         * @throws LoaderError
         */
        #[Mapping\Route('home', path: '/home')]
        public function home(Request $request): Response
        {
            return $this->render('index.html.twig', [
                'title' => 'Home',
                'db_loaded' => $this->getIsDbLoaded(),
            ]);
        }

        /**
         * @throws RuntimeError
         * @throws SyntaxError
         * @throws LoaderError
         */
        #[Mapping\Route('connect_database', path: '/connect', method: 'POST')]
        public function connectDatabase(Request $request): Response
        {
            $db_params = $this->validateDatabaseParams($request);
            if (!empty($db_params)) {
                $result = $this->performConnectionTest($db_params);
                if ($result[0] === true) {
                    $this->saveConfig('db', $db_params);
                    $success = true;
                    $message = 'Database connection successful!';
                } else {
                    $success = false;
                    $message = $result[1];
                }
            } else {
                $success = false;
                $message = 'Please fill in all fields!';
            }
            $this->setIsDbLoaded($success);

            return $this->render([
                'success' => $success,
                'message' => $message
            ], [], true);
        }

        /**
         * @throws SyntaxError
         * @throws RuntimeError
         * @throws LoaderError
         */
        #[Mapping\Route('disconnect_database', path: '/disconnect', method: 'GET')]
        public function disconnectDatabase(Request $request): Response
        {
            $this->setIsDbLoaded(false);
            $this->saveConfig('db', []);
            return $this->render([
                'success' => true,
                'message' => 'Database connection closed!'
            ], [], true);
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
            $db_params = $this->validateDatabaseParams($request);
            if (empty($db_params)) {
                return $this->render([
                    'success' => false,
                    'message' => 'No query string provided'
                ], [], true, 400);
            }
            $result = [0, ''];
            try {
                $result = $this->performConnectionTest($db_params);
                $message = $result[1];
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $message = $e->getMessage();
            }

            return $this->render([
                'success' => $result[0],
                'message' => $message
            ], [], true);
        }

        /**
         * @throws SyntaxError
         * @throws RuntimeError
         * @throws LoaderError
         * @throws \Throwable
         */
        #[Mapping\Route('show_tables', path: '/data', method: 'GET')]
        public function getTables(Request $request): Response
        {
            $tables = (new TableController)->getTables($this->entityManager);
            return $this->render('Layouts/main.html.twig', [
                'title' => 'Data',
                'tables' => $tables,
                'db_loaded' => $this->getIsDbLoaded(),
            ]);
        }

        /**
         * @throws SyntaxError
         * @throws RuntimeError
         * @throws LoaderError
         */
        #[Mapping\Route('show_table', path: '/data/{table}', method: 'GET')]
        public function showTable(Request $request): Response
        {
            $inflector = InflectorFactory::create()->build();
            $model_name = '\App\Model\\' . $inflector->singularize($request->getAttribute('table'));
            $model = new $model_name($this->entityManager);
            $items = $model->getAll();
            return $this->render([
                'items' => $items,
                'position' => $_SESSION['db']['cursor_position'],
                'max' => $_SESSION['db']['cursor_max_position'],
            ], [],true);
        }

        /**
         * @throws SyntaxError
         * @throws RuntimeError
         * @throws LoaderError
         */
        #[Mapping\Route('first_page', path: '/data/{table}/first', method: 'GET')]
        public function getFirstResults(Request $request): Response
        {
            $_SESSION['db']['cursor_position'] = 0;
            return $this->showTable($request);
        }

        /**
         * @throws SyntaxError
         * @throws RuntimeError
         * @throws LoaderError
         */
        #[Mapping\Route('next_page', path: '/data/{table}/next', method: 'GET')]
        public function getNextResults(Request $request): Response
        {
            $_SESSION['db']['cursor_position'] += self::PER_PAGE_RESULTS;
            return $this->showTable($request);
        }

        /**
         * @throws SyntaxError
         * @throws RuntimeError
         * @throws LoaderError
         */
        #[Mapping\Route('previous_page', path: '/data/{table}/previous', method: 'GET')]
        public function getPreviousResults(Request $request): Response
        {
            if ($_SESSION['db']['cursor_position'] > self::PER_PAGE_RESULTS) {
                $_SESSION['db']['cursor_position'] -= self::PER_PAGE_RESULTS;
            } else {
                $_SESSION['db']['cursor_position'] = 0;
            }
            return $this->showTable($request);
        }

        /**
         * @throws SyntaxError
         * @throws RuntimeError
         * @throws LoaderError
         */
        #[Mapping\Route('last_page', path: '/data/{table}/last', method: 'GET')]
        public function getLastResults(Request $request): Response
        {
            $_SESSION['db']['cursor_position'] = $_SESSION['db']['cursor_max_position'] - self::PER_PAGE_RESULTS;
            return $this->showTable($request);
        }
    }