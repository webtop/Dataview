<?php

    declare(strict_types=1);

    namespace App\Controller;

    use App\Controller\BaseController;
    use Doctrine\Common\Collections\Criteria;
    use Doctrine\Inflector\Inflector;
    use Doctrine\Inflector\InflectorFactory;
    use JetBrains\PhpStorm\NoReturn;
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
            if (!$this->getIsDbLoaded()) {
                return $this->render('index.html.twig', [
                    'title' => 'Home',
                    'db_loaded' => $this->getIsDbLoaded(),
                ]);
            }
            $this->redirect('/data');
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
            $model_name = '\App\Model\\' . $this->inflector->singularize($request->getAttribute('table'));
            $model = new $model_name($this->entityManager, $this->config);
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

        /**
         * @throws SyntaxError
         * @throws RuntimeError
         * @throws LoaderError
         */
        #[Mapping\Route('update_table', path: '/data/{table}/update', method: 'POST')]
        public function updateTable(Request $request): Response
        {
            $model_name = '\App\Model\\' . $this->inflector->singularize($request->getAttribute('table'));
            $model = new $model_name($this->entityManager, $this->config);
            $model->update($request->getParsedBody()['update']);
            return $this->render([
                'success' => true,
                'message' => 'Table updated!'
            ], [], true);
        }

        /**
         * @throws SyntaxError
         * @throws RuntimeError
         * @throws LoaderError
         */
        #[Mapping\Route('add_new', path: '/new/{table}', method: 'GET')]
        public function newRecord(Request $request): Response
        {
            $inflector = InflectorFactory::create()->build();
            $singular = $this->inflector->singularize($request->getAttribute('table'));
            $model_name = '\App\Model\\' . $singular;
            $model = new $model_name($this->entityManager, $this->config);
            $fields = $model->getAllFields();
            $template_name = 'Forms/new_' . strtolower($singular) . '.html.twig';
            return $this->render($template_name, [
                'title' => 'New ' . $inflector->singularize($request->getAttribute('table')),
                'fields' => $fields,
                'submission_url' => '/new/' . $request->getAttribute('table') . '/submit',
                'db_loaded' => $this->getIsDbLoaded()
            ]);
        }

        /**
         * @throws SyntaxError
         * @throws RuntimeError
         * @throws LoaderError
         */
        #[Mapping\Route('submit_new', path: '/new/{table}/submit', method: 'POST')]
        public function submitRecord(Request $request): Response
        {
            $singular = $this->inflector->singularize($request->getAttribute('table'));
            $model_name = '\App\Model\\' . $singular;
            $model = new $model_name($this->entityManager, $this->config);
            try {
                $model->create($request->getParsedBody());
            } catch (\Exception $ex) {
                return $this->render([
                    'success' => false,
                    'message' => $ex->getMessage()
                ], [], true);
            }
            $tables = (new TableController)->getTables($this->entityManager);
            $items = $model->getAll();
            return $this->render('Layouts/main.html.twig', [
                'title' => 'Data',
                'tables' => $tables,
                'db_loaded' => $this->getIsDbLoaded(),
                'items' => $items,
                'position' => $_SESSION['db']['cursor_position'],
                'max' => $_SESSION['db']['cursor_max_position'],
            ]);
        }

        /**
         * @throws SyntaxError
         * @throws RuntimeError
         * @throws LoaderError
         */
        #[Mapping\Route('delete_record', path: '/data/{table}/delete', method: 'POST')]
        public function deleteRecord(Request $request): Response
        {
            $singular = $this->inflector->singularize($request->getAttribute('table'));
            $model_name = '\App\Model\\' . $singular;
            $model = new $model_name($this->entityManager, $this->config);
            $success = $model->delete((int)$request->getParsedBody()['id']);
            return $this->render([
                'success' => $success,
                'message' => ($success) ? 'Record deleted!' : 'Record not found!'
            ], [], true);
        }
    }
