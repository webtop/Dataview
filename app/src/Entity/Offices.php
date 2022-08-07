<?php

    declare(strict_types=1);

    namespace App\Entity;

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
        private string $officeCode;

        /**
         * @var string
         *
         * @ORM\Column(name="city", type="string", length=50, nullable=false)
         */
        private string $city;

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
         * @var string|null
         *
         * @ORM\Column(name="state", type="string", length=50, nullable=true)
         */
        private ?string $state;

        /**
         * @var string
         *
         * @ORM\Column(name="country", type="string", length=50, nullable=false)
         */
        private string $country;

        /**
         * @var string
         *
         * @ORM\Column(name="postalCode", type="string", length=15, nullable=false)
         */
        private string $postalCode;

        /**
         * @var string
         *
         * @ORM\Column(name="territory", type="string", length=10, nullable=false)
         */
        private string $territory;


        /**
         * Get officeCode.
         *
         * @return string
         */
        public function getOfficeCode(): string
        {
            return $this->officeCode;
        }

        /**
         * Set city.
         *
         * @param string $city
         *
         * @return Offices
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
         * Set phone.
         *
         * @param string $phone
         *
         * @return Offices
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
         * @return Offices
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
         * @return Offices
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
         * Set state.
         *
         * @param string|null $state
         *
         * @return Offices
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
         * Set country.
         *
         * @param string $country
         *
         * @return Offices
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
         * Set postalCode.
         *
         * @param string $postalCode
         *
         * @return Offices
         */
        public function setPostalCode(string $postalCode): self
        {
            $this->postalCode = $postalCode;

            return $this;
        }

        /**
         * Get postalCode.
         *
         * @return string
         */
        public function getPostalCode(): string
        {
            return $this->postalCode;
        }

        /**
         * Set territory.
         *
         * @param string $territory
         *
         * @return Offices
         */
        public function setTerritory(string $territory): self
        {
            $this->territory = $territory;

            return $this;
        }

        /**
         * Get territory.
         *
         * @return string
         */
        public function getTerritory(): string
        {
            return $this->territory;
        }
    }
