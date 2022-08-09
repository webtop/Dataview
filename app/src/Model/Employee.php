<?php

    namespace App\Model;

    use App\Controller\IndexController;
    use App\Entity\Employees;
    use App\Model\BaseModel;

    class Employee extends BaseModel {

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
    }