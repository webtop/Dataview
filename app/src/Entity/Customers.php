<?php

    declare(strict_types=1);

    namespace App\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * Customers
     *
     * @ORM\Table(name="customers", indexes={@ORM\Index(name="salesRepEmployeeNumber", columns={"salesRepEmployeeNumber"})})
     * @ORM\Entity
     */
    class Customers
    {
        /**
         * @var int
         *
         * @ORM\Column(name="customerNumber", type="integer", nullable=false)
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="IDENTITY")
         */
        private int $customerNumber;

        /**
         * @var string
         *
         * @ORM\Column(name="customerName", type="string", length=50, nullable=false)
         */
        private string $customerName;

        /**
         * @var string
         *
         * @ORM\Column(name="contactLastName", type="string", length=50, nullable=false)
         */
        private string $contactLastname;

        /**
         * @var string
         *
         * @ORM\Column(name="contactFirstName", type="string", length=50, nullable=false)
         */
        private string $contactFirstname;

        /**
         * @var string
         *
         * @ORM\Column(name="phone", type="string", length=50, nullable=false)
         */
        private string $phone;

        /**
         * @var string
         *
         * @ORM\Column(name="addressLine1", type="string", length=50, nullable=false)
         */
        private string $addressLine1;

        /**
         * @var string|null
         *
         * @ORM\Column(name="addressLine2", type="string", length=50, nullable=true)
         */
        private ?string $addressLine2;

        /**
         * @var string
         *
         * @ORM\Column(name="city", type="string", length=50, nullable=false)
         */
        private string $city;

        /**
         * @var string|null
         *
         * @ORM\Column(name="state", type="string", length=50, nullable=true)
         */
        private ?string $state;

        /**
         * @var string|null
         *
         * @ORM\Column(name="postalCode", type="string", length=15, nullable=true)
         */
        private ?string $postalCode;

        /**
         * @var string
         *
         * @ORM\Column(name="country", type="string", length=50, nullable=false)
         */
        private string $country;

        /**
         * @var float|null
         *
         * @ORM\Column(name="creditLimit", type="decimal", precision=10, scale=2, nullable=true)
         */
        private ?float $creditLimit;

        /**
         * @var Employees
         *
         * @ORM\ManyToOne(targetEntity="\App\Entity\Employees")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="salesRepEmployeeNumber", referencedColumnName="employeeNumber")
         * })
         */
        private Employees $salesRepEmployeeNumber;


        /**
         * Get customerNumber.
         *
         * @return int
         */
        public function getCustomerNumber(): int
        {
            return $this->customerNumber;
        }

        /**
         * Set customerName.
         *
         * @param string $customerName
         *
         * @return Customers
         */
        public function setCustomerName(string $customerName): self
        {
            $this->customerName = $customerName;

            return $this;
        }

        /**
         * Get customerName.
         *
         * @return string
         */
        public function getCustomerName(): string
        {
            return $this->customerName;
        }

        /**
         * Set contactLastname.
         *
         * @param string $contactLastname
         *
         * @return Customers
         */
        public function setContactLastname(string $contactLastname): self
        {
            $this->contactLastname = $contactLastname;

            return $this;
        }

        /**
         * Get contactLastname.
         *
         * @return string
         */
        public function getContactLastname(): string
        {
            return $this->contactLastname;
        }

        /**
         * Set contactFirstname.
         *
         * @param string $contactFirstname
         *
         * @return Customers
         */
        public function setContactFirstname(string $contactFirstname): self
        {
            $this->contactFirstname = $contactFirstname;

            return $this;
        }

        /**
         * Get contactFirstname.
         *
         * @return string
         */
        public function getContactFirstname(): string
        {
            return $this->contactFirstname;
        }

        /**
         * Set phone.
         *
         * @param string $phone
         *
         * @return Customers
         */
        public function setPhone(string $phone): self
        {
            $this->phone = $phone;

            return $this;
        }

        /**
         * Get phone.
         *
         * @return string
         */
        public function getPhone(): string
        {
            return $this->phone;
        }

        /**
         * Set addressLine1.
         *
         * @param string $addressLine1
         *
         * @return Customers
         */
        public function setAddressLine1(string $addressLine1): self
        {
            $this->addressLine1 = $addressLine1;

            return $this;
        }

        /**
         * Get addressLine1.
         *
         * @return string
         */
        public function getAddressLine1(): string
        {
            return $this->addressLine1;
        }

        /**
         * Set addressLine2.
         *
         * @param string|null $addressLine2
         *
         * @return Customers
         */
        public function setAddressLine2(string $addressLine2 = null): self
        {
            $this->addressLine2 = $addressLine2;

            return $this;
        }

        /**
         * Get addressLine2.
         *
         * @return string|null
         */
        public function getAddressLine2(): ?string
        {
            return $this->addressLine2;
        }

        /**
         * Set city.
         *
         * @param string $city
         *
         * @return Customers
         */
        public function setCity(string $city): self
        {
            $this->city = $city;

            return $this;
        }

        /**
         * Get city.
         *
         * @return string
         */
        public function getCity(): string
        {
            return $this->city;
        }

        /**
         * Set state.
         *
         * @param string|null $state
         *
         * @return Customers
         */
        public function setState(string $state = null): self
        {
            $this->state = $state;

            return $this;
        }

        /**
         * Get state.
         *
         * @return string|null
         */
        public function getState(): ?string
        {
            return $this->state;
        }

        /**
         * Set postalCode.
         *
         * @param string|null $postalCode
         *
         * @return Customers
         */
        public function setPostalCode(string $postalCode = null): self
        {
            $this->postalCode = $postalCode;

            return $this;
        }

        /**
         * Get postalCode.
         *
         * @return string|null
         */
        public function getPostalCode(): ?string
        {
            return $this->postalCode;
        }

        /**
         * Set country.
         *
         * @param string $country
         *
         * @return Customers
         */
        public function setCountry(string $country): self
        {
            $this->country = $country;

            return $this;
        }

        /**
         * Get country.
         *
         * @return string
         */
        public function getCountry(): string
        {
            return $this->country;
        }

        /**
         * Set creditLimit.
         *
         * @param string|null $creditLimit
         *
         * @return Customers
         */
        public function setCreditLimit(string $creditLimit = null): self
        {
            $this->creditLimit = $creditLimit;

            return $this;
        }

        /**
         * Get creditLimit.
         *
         * @return float|null
         */
        public function getCreditLimit(): ?float
        {
            return $this->creditLimit;
        }

        /**
         * Set salesRepEmployeeNumber.
         *
         * @param Employees|null $salesRepEmployeeNumber
         *
         * @return Customers
         */
        public function setSalesRepEmployeeNumber(Employees $salesRepEmployeeNumber = null): self
        {
            $this->salesRepEmployeeNumber = $salesRepEmployeeNumber;

            return $this;
        }

        /**
         * Get salesRepEmployeeNumber.
         *
         * @return Employees|null
         */
        public function getSalesRepEmployeeNumber(): ?Employees
        {
            return $this->salesRepEmployeeNumber;
        }
    }
