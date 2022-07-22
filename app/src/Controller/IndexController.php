<?php

    use App\Controller\BaseController;
    use Sunrise\Http\Router\Annotation as Mapping;
    use Sunrise\Http\ServerRequest\ServerRequest as Request;
    use Sunrise\Http\Message\Response as Response;

    class IndexController extends BaseController
    {
        #[Mapping\Route('home', path: '/home')]
        public function index(Request $request): Response
        {
            return $this->twig->render('index.html.twig');
        }
    }