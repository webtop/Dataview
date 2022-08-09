<?php

    namespace App\Model;

    use App\Controller\IndexController;
    use App\Entity\Employees;
    use App\Entity\Offices;
    use App\Model\BaseModel;

    class Employee extends BaseModel {

        protected string $entity = 'Employees';

        public function getAll(): array {
            $employees = [];
            $table = $this->entityManager->getRepository(Employees::class);
            $entities = $table->findBy([], ['lastName' => 'ASC'], IndexController::PER_PAGE_RESULTS, $_SESSION['db']['cursor_position']);
            foreach ($entities as $entity) {
                $employees[] = [
                    ['key' => 'employeeNumber', 'text' => '#', 'value' => $entity->getEmployeeNumber()],
                    ['key' => 'firstName', 'text' => 'First Name', 'value'  => $entity->getFirstName()],
                    ['key' => 'lastName', 'text' => 'Last Name', 'value'  => $entity->getLastName()],
                    ['key' => 'jobTitle', 'text' => 'Job Title', 'value'  => $entity->getJobTitle()],
                    ['key' => 'extension', 'text' => 'Extension', 'value'  => $entity->getExtension()],
                    ['key' => 'email', 'text' => 'Email', 'value'  => $entity->getEmail()]
                ];
            }
            return $employees;
        }

        public function getById(int $id): Employee {
            return $this->entityManager->getRepository(Employees::class)->find($id);
        }

        public function getAllFields(): array
        {
            return [
                ['name' => 'firstName', 'label' => 'First Name', 'type' => 'text', 'required' => true],
                ['name' => 'lastName', 'label' => 'Last Name', 'type' => 'text', 'required' => true],
                ['name' => 'jobTitle', 'label' => 'Job Title', 'type' => 'text', 'required' => true],
                ['name' => 'extension', 'label' => 'Extension', 'type' => 'text'],
                ['name' => 'email', 'label' => 'Email', 'type' => 'text', 'required' => true],
                ['name' => 'officeCode', 'label' => 'Office', 'type' => 'select', 'options' => $this->getOffices()],
                ['name' => 'reportsTo', 'label' => 'Reports To', 'type' => 'select', 'options' => $this->getReportsTo()]
            ];
        }

        private function getOffices(): array
        {
            $offices = [];
            $table = $this->entityManager->getRepository(Offices::class);
            $entities = $table->findBy([], ['officeCode' => 'ASC']);
            foreach ($entities as $entity) {
                $offices[] = [
                    'key' => $entity->getOfficeCode(),
                    'text' => $entity->getCity() . ' - ' . $entity->getCountry()
                ];
            }
            return $offices;
        }

        private function getReportsTo(): array
        {
            $reportsTo = [];
            $table = $this->entityManager->getRepository(Employees::class);
            $entities = $table->findBy([], ['lastName' => 'ASC']);
            foreach ($entities as $entity) {
                $reportsTo[] = [
                    'key' => $entity->getEmployeeNumber(),
                    'text' => $entity->getFirstName() . ' ' . $entity->getLastName()
                ];
            }
            return $reportsTo;
        }
    }