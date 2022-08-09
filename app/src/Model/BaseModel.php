<?php

    namespace App\Model;

    use App\Entity\Customers;
    use Doctrine\Inflector\InflectorFactory;
    use Doctrine\ORM\EntityManager;

    abstract class BaseModel
    {
        protected EntityManager $entityManager;
        protected \Doctrine\Inflector\Inflector $inflector;
        protected array $config;

        /**
         * During model initialization we get a count of the max number of records in the model table.
         * @param EntityManager $entityManager
         * @param array $config
         */
        public function __construct(EntityManager $entityManager, array $config)
        {
            $this->entityManager = $entityManager;
            $this->config = $config;
            $this->inflector = InflectorFactory::create()->build();
            if (empty($_SESSION['db']['cursor_max_position'])) {
                $max = $entityManager->getRepository(Customers::class)->count([]);
                $_SESSION['db']['cursor_max_position'] = $max;
            }
        }

    }
