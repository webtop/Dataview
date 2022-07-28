<?php

    declare(strict_types=1);

    namespace App\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * Productlines
     *
     * @ORM\Table(name="productlines")
     * @ORM\Entity
     */
    class Productlines
    {
        /**
         * @var string
         *
         * @ORM\Column(name="productLine", type="string", length=50, nullable=false)
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="IDENTITY")
         */
        private $productline;

        /**
         * @var string|null
         *
         * @ORM\Column(name="textDescription", type="string", length=4000, nullable=true)
         */
        private $textdescription;

        /**
         * @var string|null
         *
         * @ORM\Column(name="htmlDescription", type="text", length=16777215, nullable=true)
         */
        private $htmldescription;

        /**
         * @var string|null
         *
         * @ORM\Column(name="image", type="blob", length=16777215, nullable=true)
         */
        private $image;


        /**
         * Get productline.
         *
         * @return string
         */
        public function getProductline()
        {
            return $this->productline;
        }

        /**
         * Set textdescription.
         *
         * @param string|null $textdescription
         *
         * @return Productlines
         */
        public function setTextdescription($textdescription = null): self
        {
            $this->textdescription = $textdescription;

            return $this;
        }

        /**
         * Get textdescription.
         *
         * @return string|null
         */
        public function getTextdescription()
        {
            return $this->textdescription;
        }

        /**
         * Set htmldescription.
         *
         * @param string|null $htmldescription
         *
         * @return Productlines
         */
        public function setHtmldescription($htmldescription = null): self
        {
            $this->htmldescription = $htmldescription;

            return $this;
        }

        /**
         * Get htmldescription.
         *
         * @return string|null
         */
        public function getHtmldescription()
        {
            return $this->htmldescription;
        }

        /**
         * Set image.
         *
         * @param string|null $image
         *
         * @return Productlines
         */
        public function setImage($image = null): self
        {
            $this->image = $image;

            return $this;
        }

        /**
         * Get image.
         *
         * @return string|null
         */
        public function getImage()
        {
            return $this->image;
        }
    }
