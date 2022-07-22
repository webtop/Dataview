<?php

    declare(strict_types=1);

    namespace Entities;

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
        private $customernumber;

        /**
         * @var string
         *
         * @ORM\Column(name="customerName", type="string", length=50, nullable=false)
         */
        private $customername;

        /**
         * @var string
         *
         * @ORM\Column(name="contactLastName", type="string", length=50, nullable=false)
         */
        private $contactlastname;

        /**
         * @var string
         *
         * @ORM\Column(name="contactFirstName", type="string", length=50, nullable=false)
         */
        private $contactfirstname;

        /**
         * @var string
         *
         * @ORM\Column(name="phone", type="string", length=50, nullable=false)
         */
        private $phone;

        /**
         * @var string
         *
         * @ORM\Column(name="addressLine1", type="string", length=50, nullable=false)
         */
        private $addressline1;

        /**
         * @var string|null
         *
         * @ORM\Column(name="addressLine2", type="string", length=50, nullable=true)
         */
        private $addressline2;

        /**
         * @var string
         *
         * @ORM\Column(name="city", type="string", length=50, nullable=false)
         */
        private $city;

        /**
         * @var string|null
         *
         * @ORM\Column(name="state", type="string", length=50, nullable=true)
         */
        private $state;

        /**
         * @var string|null
         *
         * @ORM\Column(name="postalCode", type="string", length=15, nullable=true)
         */
        private $postalcode;

        /**
         * @var string
         *
         * @ORM\Column(name="country", type="string", length=50, nullable=false)
         */
        private $country;

        /**
         * @var string|null
         *
         * @ORM\Column(name="creditLimit", type="decimal", precision=10, scale=2, nullable=true)
         */
        private $creditlimit;

        /**
         * @var Employees
         *
         * @ORM\ManyToOne(targetEntity="\\Employees")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="salesRepEmployeeNumber", referencedColumnName="employeeNumber")
         * })
         */
        private $salesrepemployeenumber;


        /**
         * Get customernumber.
         *
         * @return int
         */
        public function getCustomernumber()
        {
            return $this->customernumber;
        }

        /**
         * Set customername.
         *
         * @param string $customername
         *
         * @return Customers
         */
        public function setCustomername($customername): self
        {
            $this->customername = $customername;

            return $this;
        }

        /**
         * Get customername.
         *
         * @return string
         */
        public function getCustomername()
        {
            return $this->customername;
        }

        /**
         * Set contactlastname.
         *
         * @param string $contactlastname
         *
         * @return Customers
         */
        public function setContactlastname($contactlastname): self
        {
            $this->contactlastname = $contactlastname;

            return $this;
        }

        /**
         * Get contactlastname.
         *
         * @return string
         */
        public function getContactlastname()
        {
            return $this->contactlastname;
        }

        /**
         * Set contactfirstname.
         *
         * @param string $contactfirstname
         *
         * @return Customers
         */
        public function setContactfirstname($contactfirstname): self
        {
            $this->contactfirstname = $contactfirstname;

            return $this;
        }

        /**
         * Get contactfirstname.
         *
         * @return string
         */
        public function getContactfirstname()
        {
            return $this->contactfirstname;
        }

        /**
         * Set phone.
         *
         * @param string $phone
         *
         * @return Customers
         */
        public function setPhone($phone): self
        {
            $this->phone = $phone;

            return $this;
        }

        /**
         * Get phone.
         *
         * @return string
         */
        public function getPhone()
        {
            return $this->phone;
        }

        /**
         * Set addressline1.
         *
         * @param string $addressline1
         *
         * @return Customers
         */
        public function setAddressline1($addressline1): self
        {
            $this->addressline1 = $addressline1;

            return $this;
        }

        /**
         * Get addressline1.
         *
         * @return string
         */
        public function getAddressline1()
        {
            return $this->addressline1;
        }

        /**
         * Set addressline2.
         *
         * @param string|null $addressline2
         *
         * @return Customers
         */
        public function setAddressline2($addressline2 = null): self
        {
            $this->addressline2 = $addressline2;

            return $this;
        }

        /**
         * Get addressline2.
         *
         * @return string|null
         */
        public function getAddressline2()
        {
            return $this->addressline2;
        }

        /**
         * Set city.
         *
         * @param string $city
         *
         * @return Customers
         */
        public function setCity($city): self
        {
            $this->city = $city;

            return $this;
        }

        /**
         * Get city.
         *
         * @return string
         */
        public function getCity()
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
        public function setState($state = null): self
        {
            $this->state = $state;

            return $this;
        }

        /**
         * Get state.
         *
         * @return string|null
         */
        public function getState()
        {
            return $this->state;
        }

        /**
         * Set postalcode.
         *
         * @param string|null $postalcode
         *
         * @return Customers
         */
        public function setPostalcode($postalcode = null): self
        {
            $this->postalcode = $postalcode;

            return $this;
        }

        /**
         * Get postalcode.
         *
         * @return string|null
         */
        public function getPostalcode()
        {
            return $this->postalcode;
        }

        /**
         * Set country.
         *
         * @param string $country
         *
         * @return Customers
         */
        public function setCountry($country): self
        {
            $this->country = $country;

            return $this;
        }

        /**
         * Get country.
         *
         * @return string
         */
        public function getCountry()
        {
            return $this->country;
        }

        /**
         * Set creditlimit.
         *
         * @param string|null $creditlimit
         *
         * @return Customers
         */
        public function setCreditlimit($creditlimit = null): self
        {
            $this->creditlimit = $creditlimit;

            return $this;
        }

        /**
         * Get creditlimit.
         *
         * @return string|null
         */
        public function getCreditlimit()
        {
            return $this->creditlimit;
        }

        /**
         * Set salesrepemployeenumber.
         *
         * @param Employees|null $salesrepemployeenumber
         *
         * @return Customers
         */
        public function setSalesrepemployeenumber(Employees $salesrepemployeenumber = null): self
        {
            $this->salesrepemployeenumber = $salesrepemployeenumber;

            return $this;
        }

        /**
         * Get salesrepemployeenumber.
         *
         * @return Employees|null
         */
        public function getSalesrepemployeenumber()
        {
            return $this->salesrepemployeenumber;
        }
    }
