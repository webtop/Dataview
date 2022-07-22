<?php

    use Sunrise\Http\Router\Annotation as Mapping;

    class IndexController
    {
        #[Mapping\Route('home', path: '/')]
        public function index(): string
        {
            return 'Hello, world!';
        }
    }