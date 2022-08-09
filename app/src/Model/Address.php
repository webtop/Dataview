<?php

    namespace App\Model;

    use Doctrine\ORM\EntityManager;
    use Psr\Container\ContainerExceptionInterface;
    use Psr\Container\ContainerInterface;
    use Psr\Container\NotFoundExceptionInterface;

    class Address extends BaseModel
    {
        private string $adminDistrict;

        private string $locality;

        private string $postalCode;

        private string $addressLine1;

        private string $addressLine2;

        private string $countryRegion;

        private int $strictMatch = -1;

        private bool $hasOptions = false;

        private array $options = [];

        public function __construct(EntityManager $entityManager, array $config)
        {
            parent::__construct($entityManager, $config);
        }


        public function setAdminDistrict(string $adminDistrict): void
        {
            $this->adminDistrict = $adminDistrict;
        }


        public function setLocality(string $locality): void
        {
            $this->locality = $locality;
        }


        public function setPostalCode(string $postalCode): void
        {
            $this->postalCode = $postalCode;
        }


        public function setAddressLine1(string $addressLine): void
        {
            $this->addressLine1 = $addressLine;
        }


        public function setAddressLine2(string $addressLine): void
        {
            $this->addressLine2 = $addressLine;
        }


        public function setCountryRegion(string $countryRegion): void
        {
            $this->countryRegion = $countryRegion;
        }

        public function __get($property)
        {
            if (property_exists($this, $property)) {
                return $this->$property;
            }
            return null;
        }

        /**
         * @return bool
         * @throws \Exception
         */
        public function validate(): bool
        {
            $maps_api_key = $this->config['maps_api_key'];
            if (empty($maps_api_key)) {
                throw new \Exception('Maps API key does not exist. Cannot validate address.');
            }

            $seer = new \ReflectionClass(self::class);
            foreach ($seer->getProperties() as $property) {
                if ($property->class !== self::class) {
                    continue;
                }

                if (empty($this->__get($property->name)) && $property->name !== 'addressLine2') {
                    throw new \Exception('Address is missing ' . $property->name . '.');
                }
            }

            $address = $this->__get('addressLine1') . (!empty($this->__get('addressLine2')) ? ' ' . $this->__get('addressLine2') : '');
            $url = 'https://dev.virtualearth.net/REST/v1/Locations/' .
                urlencode(
                    $address . ',' .
                    $this->__get('locality') . ',' .
                    $this->__get('adminDistrict') . ',' .
                    $this->__get('postalCode') . ',' .
                    $this->__get('countryRegion')
                ) .
                '?key=' . $maps_api_key . '&o=json';
            $response = file_get_contents($url);
            $response = json_decode($response, true);
            if (empty($response['resourceSets'][0]['resources'])) {
                throw new \Exception('Address is invalid.');
            }

            if ($response['resourceSets'][0]['estimatedTotal'] > 1) {
                $this->sortByConfidence($response['resourceSets'][0]['resources']);
            }

            if ($response['resourceSets'][0]['resources'][0]['confidence'] === 'High') {
                return true;
            } else {
                $this->options = $response['resourceSets'][0]['resources'];
                $this->hasOptions = true;
            }
            return false;
        }

        public function hasOptions(): bool
        {
            return $this->hasOptions;
        }

        public function getOptions(): array
        {
            return $this->options;
        }

        private function sortByConfidence(mixed $resources)
        {
            usort($resources, function ($a, $b) {
                if ($a['confidence'] == $b['confidence']) {
                    return 0;
                }
                return ($a['confidence'] > $b['confidence']) ? -1 : 1;
            });
        }
    }