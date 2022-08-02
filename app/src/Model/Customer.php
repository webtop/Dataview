<?php
    declare(strict_types=1);

    namespace App\Model;

    use App\Controller\IndexController;
    use App\Entity\Customers;
    use Doctrine\ORM\EntityManager;
    use Doctrine\ORM\Exception\ORMException;
    use Doctrine\ORM\OptimisticLockException;
    use Monolog\Logger;
    use Psr\Container\ContainerExceptionInterface;
    use Psr\Container\NotFoundExceptionInterface;
    use Psr\Container\ContainerInterface;


    class Customer extends BaseModel {

        public function getAll(): array {
            $customers = [];
            $table = $this->entityManager->getRepository(Customers::class);
            $entities = $table->findBy([], ['customerName' => 'ASC'], IndexController::PER_PAGE_RESULTS, $_SESSION['db']['cursor_position']);
            foreach ($entities as $entity) {
                $customers[] = [
                    ['key' => 'customerNumber', 'text' => '#', 'value' => $entity->getCustomerNumber()],
                    ['key' => 'customerName', 'text' => 'Name', 'value'  => $entity->getCustomerName()],
                    ['key' => 'contactFirstname', 'text' => 'Contact', 'value'  => $entity->getContactFirstname() . ' ' . $entity->getContactLastname()],
                    ['key' => 'customerPhone', 'text' => 'Phone', 'value'  => $entity->getPhone()],
                    ['key' => 'customerAddress', 'text' => 'Address', 'value'  => $entity->getAddress()]
                ];
            }
            return $customers;
        }

        public function getById(int $id): Customer {
            return $this->entityManager->getRepository(Customers::class)->find($id);
        }

        /**
         * @throws OptimisticLockException
         * @throws ORMException
         */
        public function create(Customer $customer): Customer {
            $this->entityManager->persist($customer);
            $this->entityManager->flush();
            return $customer;
        }

        /**
         * @throws OptimisticLockException
         * @throws ORMException
         */
        public function update(Customer $customer): Customer {
            $this->entityManager->persist($customer);
            $this->entityManager->flush();
            return $customer;
        }

        /**
         * @throws OptimisticLockException
         * @throws ORMException
         */
        public function delete(Customer $customer): void {
            $this->entityManager->remove($customer);
            $this->entityManager->flush();
        }
    }