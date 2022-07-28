<?php

    namespace App\Controller;

    use Doctrine\ORM\EntityManager;
    use Psr\Container\ContainerInterface;

    class TableController
    {

        public function getTables(EntityManager $entityManager): array
        {
            // Save a connection and just get the entities from the directory
            $dir = opendir(ENTITY_PATH);
            $tables = [];
            while (false !== ($file = readdir($dir))) {
                if (str_ends_with($file, '.php')) {
                    $tables[] = substr($file, 0, -4);
                }
            }
            closedir($dir);
            return $tables;
        }
    }