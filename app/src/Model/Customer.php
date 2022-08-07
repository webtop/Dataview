<?php
    declare(strict_types=1);

    namespace App\Model;

    use App\Controller\BaseController;
    use App\Controller\IndexController;
    use App\Entity\Customers;
    use App\Entity\Employees;
    use Doctrine\Inflector\Inflector;
    use Doctrine\Inflector\InflectorFactory;
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
                    ['key' => 'contactName', 'text' => 'Contact', 'value'  => $entity->getContactFirstname() . ' ' . $entity->getContactLastname()],
                    ['key' => 'customerPhone', 'text' => 'Phone', 'value'  => $entity->getPhone()],
                    ['key' => 'customerAddress', 'text' => 'Address', 'value'  => $this->getAddress($entity)]
                ];
            }
            return $customers;
        }

        public function getById(int $id): Customer {
            return $this->entityManager->getRepository(Customers::class)->find($id);
        }

        public function getAllFields(): array
        {
            return [
                ['name' => 'customerName', 'label' => 'Name', 'type' => 'text', 'required' => true],
                ['name' => 'phone', 'label' => 'Phone', 'type' => 'text', 'required' => true],
                ['name' => 'addressLine1', 'label' => 'Address', 'type' => 'text', 'required' => true],
                ['name' => 'addressLine2', 'label' => 'Address 2', 'type' => 'text'],
                ['name' => 'city', 'label' => 'City', 'type' => 'text', 'required' => true],
                ['name' => 'state', 'label' => 'State', 'type' => 'text', 'required' => true],
                ['name' => 'postalCode', 'label' => 'Postal Code', 'type' => 'text', 'required' => true],
                ['name' => 'country', 'label' => 'Country', 'type' => 'text', 'required' => true],
                ['name' => 'contactFirstname', 'label' => 'Contact First Name', 'type' => 'text', 'required' => true],
                ['name' => 'contactLastname', 'label' => 'Contact Last Name', 'type' => 'text'],
                ['name' => 'salesRepEmployeeNumber', 'label' => 'Sales Rep', 'type' => 'select', 'options' => $this->getSalesReps()],
                ['name' => 'creditLimit', 'label' => 'Credit Limit ($)', 'type' => 'number']
            ];
        }

        /**
         * @throws OptimisticLockException
         * @throws ORMException
         * @throws \Exception
         */
        public function create(array $request_data): Customer {
            foreach ($request_data as $key => &$value) {
                $value = strip_tags(addslashes(trim($value)));
            }

            $address_to_validate = new Address($this->entityManager, $this->config);
            $address_to_validate->setAddressLine1($request_data['addressLine1']);
            $address_to_validate->setAddressLine2($request_data['addressLine2']);
            $address_to_validate->setLocality($request_data['city']);
            $address_to_validate->setAdminDistrict($request_data['state']);
            $address_to_validate->setPostalCode($request_data['postalCode']);
            $address_to_validate->setCountryRegion($request_data['country']);
            if (!$address_to_validate->validate()) {
                throw new \Exception('Invalid address!');
            }

            $customer = new Customers();
            unset($value);
            foreach ($request_data as $key => $value) {
                if ($key == 'salesRepEmployeeNumber') {
                    if (!empty($value)) {
                        $salesRep = $this->entityManager->getRepository(Employees::class)->find($value);
                        $customer->setSalesRepEmployeeNumber($salesRep);
                    }
                } else if ($key == 'creditLimit') {
                    $customer->setCreditLimit((int)$value);
                } else {
                    $customer->{'set' . $this->inflector->classify($key)}($value);
                }
            }
            $this->entityManager->persist($customer);
            $this->entityManager->flush();
            return $this;
        }

        /**
         * @throws OptimisticLockException
         * @throws ORMException
         */
        public function update(array $updated_data): Customer {
            $customer = $this->entityManager->getRepository(Customers::class)->find($updated_data['customerNumber']);
            $inflector = InflectorFactory::create()->build();
            foreach ($updated_data as $key => &$value) {
                if ($key === 'customerNumber') {
                    continue;
                }

                $value = strip_tags(addslashes(trim($value)));
                if ($key === 'contactName') {
                    $value = explode(' ', $value);
                    $customer->setContactFirstname($value[0]);
                    $customer->setContactLastname($value[1]);
                } else {
                    $customer->{'set' . $inflector->classify($key)}($value);
                }
            }
            $this->entityManager->persist($customer);
            $this->entityManager->flush();
            return $this;
        }

        /**
         * @throws OptimisticLockException
         * @throws ORMException
         */
        public function delete(int $customer_id): bool {
            $customer = $this->entityManager->getRepository(Customers::class)->find($customer_id);
            if (!empty($customer)) {
                $this->entityManager->remove($customer);
                $this->entityManager->flush();
                return true;
            }
            return false;
        }

        /**
         * Return the combined address.
         * @param Customers $customer
         * @return string
         */
        private function getAddress(Customers $customer): string
        {
            $addr2 = empty($customer->getAddressLine2()) ? '' : ', ' . $customer->getAddressLine2();
            $state = empty($customer->getState()) ? '' : ', ' . $customer->getState();
            return $customer->getAddressLine1() . $addr2 .
                ', ' . $customer->getCity() .
                ', ' . $customer->getPostalCode() .
                $state .
                ', ' . $customer->getCountry();
        }

        private function getSalesReps(): array
        {
            $reps = [];
            $table = $this->entityManager->getRepository(Employees::class);
            $entities = $table->findBy(['jobTitle' => 'Sales Rep'], ['lastName' => 'ASC']);
            foreach ($entities as $entity) {
                $rep = $entity->getEmployeeNumber();
                if (!array_key_exists($rep, $reps)) {
                    $reps[] = [
                        'value' => $rep,
                        'label' => $entity->getFirstName() . ' ' . $entity->getLastName()
                    ];
                }
            }
            return $reps;
        }
    }