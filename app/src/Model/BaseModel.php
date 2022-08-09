<?php

    namespace App\Model;

    use App\Entity\Customers;
    use Doctrine\Inflector\InflectorFactory;
    use Doctrine\ORM\EntityManager;

    abstract class BaseModel
    {
        protected EntityManager $entityManager;
        protected InflectorFactory $inflector;
        protected array $config;
        private string $currentEntity;

        /**
         * During model initialization we get a count of the max number of records in the model table.
         * @param EntityManager $entityManager
         * @param array $config
         */
        public function __construct(EntityManager $entityManager, array $config)
        {
            $this->entityManager = $entityManager;
            $this->config = $config;
            $this->inflector = new InflectorFactory();
            $this->inflector->create()->build();

            $max = $entityManager->getRepository($this->entity)->count([]);
            $_SESSION['db']['cursor_max_position'] = $max;
            $_SESSION['db']['cursor_position'] = 0;

        }

    }
