<?php

    declare(strict_types=1);

    namespace Entities;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * Employees
     *
     * @ORM\Table(name="employees", indexes={@ORM\Index(name="officeCode", columns={"officeCode"}), @ORM\Index(name="reportsTo", columns={"reportsTo"})})
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
        private $employeenumber;

        /**
         * @var string
         *
         * @ORM\Column(name="lastName", type="string", length=50, nullable=false)
         */
        private $lastname;

        /**
         * @var string
         *
         * @ORM\Column(name="firstName", type="string", length=50, nullable=false)
         */
        private $firstname;

        /**
         * @var string
         *
         * @ORM\Column(name="extension", type="string", length=10, nullable=false)
         */
        private $extension;

        /**
         * @var string
         *
         * @ORM\Column(name="email", type="string", length=100, nullable=false)
         */
        private $email;

        /**
         * @var string
         *
         * @ORM\Column(name="jobTitle", type="string", length=50, nullable=false)
         */
        private $jobtitle;

        /**
         * @var Offices
         *
         * @ORM\ManyToOne(targetEntity="\\Offices")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="officeCode", referencedColumnName="officeCode")
         * })
         */
        private $officecode;

        /**
         * @var Employees
         *
         * @ORM\ManyToOne(targetEntity="\\Employees")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="reportsTo", referencedColumnName="employeeNumber")
         * })
         */
        private $reportsto;


        /**
         * Get employeenumber.
         *
         * @return int
         */
        public function getEmployeenumber()
        {
            return $this->employeenumber;
        }

        /**
         * Set lastname.
         *
         * @param string $lastname
         *
         * @return Employees
         */
        public function setLastname($lastname): self
        {
            $this->lastname = $lastname;

            return $this;
        }

        /**
         * Get lastname.
         *
         * @return string
         */
        public function getLastname()
        {
            return $this->lastname;
        }

        /**
         * Set firstname.
         *
         * @param string $firstname
         *
         * @return Employees
         */
        public function setFirstname($firstname): self
        {
            $this->firstname = $firstname;

            return $this;
        }

        /**
         * Get firstname.
         *
         * @return string
         */
        public function getFirstname()
        {
            return $this->firstname;
        }

        /**
         * Set extension.
         *
         * @param string $extension
         *
         * @return Employees
         */
        public function setExtension($extension): self
        {
            $this->extension = $extension;

            return $this;
        }

        /**
         * Get extension.
         *
         * @return string
         */
        public function getExtension()
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
        public function setEmail($email): self
        {
            $this->email = $email;

            return $this;
        }

        /**
         * Get email.
         *
         * @return string
         */
        public function getEmail()
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
        public function setJobtitle($jobtitle): self
        {
            $this->jobtitle = $jobtitle;

            return $this;
        }

        /**
         * Get jobtitle.
         *
         * @return string
         */
        public function getJobtitle()
        {
            return $this->jobtitle;
        }

        /**
         * Set officecode.
         *
         * @param Offices|null $officecode
         *
         * @return Employees
         */
        public function setOfficecode(Offices $officecode = null): self
        {
            $this->officecode = $officecode;

            return $this;
        }

        /**
         * Get officecode.
         *
         * @return Offices|null
         */
        public function getOfficecode()
        {
            return $this->officecode;
        }

        /**
         * Set reportsto.
         *
         * @param Employees|null $reportsto
         *
         * @return Employees
         */
        public function setReportsto(Employees $reportsto = null): self
        {
            $this->reportsto = $reportsto;

            return $this;
        }

        /**
         * Get reportsto.
         *
         * @return Employees|null
         */
        public function getReportsto()
        {
            return $this->reportsto;
        }
    }
