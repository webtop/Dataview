<?php

    declare(strict_types=1);

    namespace Entities;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * Offices
     *
     * @ORM\Table(name="offices")
     * @ORM\Entity
     */
    class Offices
    {
        /**
         * @var string
         *
         * @ORM\Column(name="officeCode", type="string", length=10, nullable=false)
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="IDENTITY")
         */
        private $officecode;

        /**
         * @var string
         *
         * @ORM\Column(name="city", type="string", length=50, nullable=false)
         */
        private $city;

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
         * @var string|null
         *
         * @ORM\Column(name="state", type="string", length=50, nullable=true)
         */
        private $state;

        /**
         * @var string
         *
         * @ORM\Column(name="country", type="string", length=50, nullable=false)
         */
        private $country;

        /**
         * @var string
         *
         * @ORM\Column(name="postalCode", type="string", length=15, nullable=false)
         */
        private $postalcode;

        /**
         * @var string
         *
         * @ORM\Column(name="territory", type="string", length=10, nullable=false)
         */
        private $territory;


        /**
         * Get officecode.
         *
         * @return string
         */
        public function getOfficecode()
        {
            return $this->officecode;
        }

        /**
         * Set city.
         *
         * @param string $city
         *
         * @return Offices
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
         * Set phone.
         *
         * @param string $phone
         *
         * @return Offices
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
         * @return Offices
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
         * @return Offices
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
         * Set state.
         *
         * @param string|null $state
         *
         * @return Offices
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
         * Set country.
         *
         * @param string $country
         *
         * @return Offices
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
         * Set postalcode.
         *
         * @param string $postalcode
         *
         * @return Offices
         */
        public function setPostalcode($postalcode): self
        {
            $this->postalcode = $postalcode;

            return $this;
        }

        /**
         * Get postalcode.
         *
         * @return string
         */
        public function getPostalcode()
        {
            return $this->postalcode;
        }

        /**
         * Set territory.
         *
         * @param string $territory
         *
         * @return Offices
         */
        public function setTerritory($territory): self
        {
            $this->territory = $territory;

            return $this;
        }

        /**
         * Get territory.
         *
         * @return string
         */
        public function getTerritory()
        {
            return $this->territory;
        }
    }
