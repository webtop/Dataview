<?php
    declare(strict_types=1);

    namespace App\Model;

    use App\Entity\Customers;
    use Doctrine\ORM\EntityManager;
    use Monolog\Logger;
    use Psr\Container\ContainerExceptionInterface;
    use Psr\Container\NotFoundExceptionInterface;
    use Psr\Container\ContainerInterface;


    class Customer {

        private EntityManager $entityManager;

        public function __construct(EntityManager $entityManager)
        {
            $this->entityManager = $entityManager;
        }

        public function getAll(int $per_page, int $from): array {
            $customers = [];
            $table = $this->entityManager->getRepository(Customers::class);
            $entities = $table->findAll();
            foreach ($entities as $entity) {
                $customers[] = [
                    'id' => $entity->getId(),
                    'name' => $entity->getName(),
                    'email' => $entity->getEmail(),
                    'phone' => $entity->getPhone(),
                    'address' => $entity->getAddress(),
                    'created_at' => $entity->getCreatedAt(),
                    'updated_at' => $entity->getUpdatedAt(),
                ];
            }
            return $customers;
        }

        public function getById(int $id): Customer {
            $customer = $this->entityManager->getRepository(Customers::class)->find($id);
            return $customer;
        }

        public function create(Customer $customer): Customer {
            $this->entityManager->persist($customer);
            $this->entityManager->flush();
            return $customer;
        }

        public function update(Customer $customer): Customer {
            $this->entityManager->persist($customer);
            $this->entityManager->flush();
            return $customer;
        }

        public function delete(Customer $customer): void {
            $this->entityManager->remove($customer);
            $this->entityManager->flush();
        }
    }