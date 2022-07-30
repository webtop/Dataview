<?php

    namespace App\Model;

    use App\Entity\Customers;
    use Doctrine\ORM\EntityManager;

    abstract class BaseModel
    {
        protected EntityManager $entityManager;

        /**
         * During model initialization we get a count of the max number of records in the models table.
         * @param EntityManager $entityManager
         */
        public function __construct(EntityManager $entityManager)
        {
            $this->entityManager = $entityManager;
            if (empty($_SESSION['db']['cursor_max_position'])) {
                $max = $entityManager->getRepository(Customers::class)->count([]);
                $_SESSION['db']['cursor_max_position'] = $max;
            }
        }
    }
