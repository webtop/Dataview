<?php
    declare(strict_types=1);

    namespace App\Controller;

    use Twig\Environment;
    
    /**
     * This class is used to hold simple functionality which we may want to use in multiple places.
     * It is not intended to be used as a base class, more like an old-time global_functions file.
     */
    class BaseController
    {
        protected Environment $twig;

        public function __construct(Environment $twig)
        {
            $this->twig = $twig;
        }

        public static function PrettyPrint($data, bool $exit = false): void
        {
            print '<pre>' . print_r($data, true) . '</pre>';
            if ($exit) {
                exit;
            }
        }
    }