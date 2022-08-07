<?php

    declare(strict_types=1);

    namespace App\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * Employees
     *
     * @ORM\Table(name="employees", indexes={
     *     @ORM\Index(name="officeCode", columns={"officeCode"}),
     *     @ORM\Index(name="reportsTo", columns={"reportsTo"})})
     * @ORM\Entity
     */
    class Employees
    {
        /**
         * @var int
         *
         * @ORM\Column(name="employeeNumber", type="integer", nullable=false)
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="IDENTITY")
         */
        private int $employeeNumber;

        /**
         * @var string
         *
         * @ORM\Column(name="lastName", type="string", length=50, nullable=false)
         */
        private string $lastName;

        /**
         * @var string
         *
         * @ORM\Column(name="firstName", type="string", length=50, nullable=false)
         */
        private string $firstName;

        /**
         * @var string
         *
         * @ORM\Column(name="extension", type="string", length=10, nullable=false)
         */
        private string $extension;

        /**
         * @var string
         *
         * @ORM\Column(name="email", type="string", length=100, nullable=false)
         */
        private string $email;

        /**
         * @var string
         *
         * @ORM\Column(name="jobTitle", type="string", length=50, nullable=false)
         */
        private string $jobTitle;

        /**
         * @var Offices
         *
         * @ORM\ManyToOne(targetEntity="\App\Entity\Offices")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="officeCode", referencedColumnName="officeCode")
         * })
         */
        private Offices $officeCode;

        /**
         * @var Employees
         *
         * @ORM\ManyToOne(targetEntity="\App\Entity\Employees")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="reportsTo", referencedColumnName="employeeNumber")
         * })
         */
        private Employees $reportsTo;


        /**
         * Get employeenumber.
         *
         * @return int
         */
        public function getEmployeeNumber(): int
        {
            return $this->employeeNumber;
        }

        /**
         * Set lastname.
         *
         * @param string $lastname
         *
         * @return Employees
         */
        public function setLastName(string $lastname): self
        {
            $this->lastName = $lastname;
            return $this;
        }

        /**
         * Get lastname.
         *
         * @return string
         */
        public function getLastName(): string
        {
            return $this->lastName;
        }

        /**
         * Set firstname.
         *
         * @param string $firstname
         *
         * @return Employees
         */
        public function setFirstName(string $firstname): self
        {
            $this->firstName = $firstname;
            return $this;
        }

        /**
         * Get firstname.
         *
         * @return string
         */
        public function getFirstname(): string
        {
            return $this->firstName;
        }

        /**
         * Set extension.
         *
         * @param string $extension
         *
         * @return Employees
         */
        public function setExtension(string $extension): self
        {
            $this->extension = $extension;
            return $this;
        }

        /**
         * Get extension.
         *
         * @return string
         */
        public function getExtension(): string
        {
            return $this->extension;
        }

        /**
         * Set email.
         *
         * @param string $email
         *
         * @return Employees
         */
        public function setEmail(string $email): self
        {
            $this->email = $email;
            return $this;
        }

        /**
         * Get email.
         *
         * @return string
         */
        public function getEmail(): string
        {
            return $this->email;
        }

        /**
         * Set jobtitle.
         *
         * @param string $jobtitle
         *
         * @return Employees
         */
        public function setJobTitle(string $jobtitle): self
        {
            $this->jobTitle = $jobtitle;
            return $this;
        }

        /**
         * Get jobtitle.
         *
         * @return string
         */
        public function getJobTitle(): string
        {
            return $this->jobTitle;
        }

        /**
         * Set officecode.
         *
         * @param Offices|null $officecode
         *
         * @return Employees
         */
        public function setOfficeCode(Offices $officecode = null): self
        {
            $this->officeCode = $officecode;
            return $this;
        }

        /**
         * Get officecode.
         *
         * @return Offices|null
         */
        public function getOfficeCode(): ?Offices
        {
            return $this->officeCode;
        }

        /**
         * Set reportsto.
         *
         * @param Employees|null $reportsto
         *
         * @return Employees
         */
        public function setReportsTo(Employees $reportsto = null): self
        {
            $this->reportsTo = $reportsto;
            return $this;
        }

        /**
         * Get reportsto.
         *
         * @return Employees|null
         */
        public function getReportsto(): ?Employees
        {
            return $this->reportsTo;
        }
    }
