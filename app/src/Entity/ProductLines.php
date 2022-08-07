<?php

    declare(strict_types=1);

    namespace App\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * ProductLines
     *
     * @ORM\Table(name="productLines")
     * @ORM\Entity
     */
    class ProductLines
    {
        /**
         * @var string
         *
         * @ORM\Column(name="productLine", type="string", length=50, nullable=false)
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="IDENTITY")
         */
        private string $productLine;

        /**
         * @var string|null
         *
         * @ORM\Column(name="textDescription", type="string", length=4000, nullable=true)
         */
        private ?string $textDescription;

        /**
         * @var string|null
         *
         * @ORM\Column(name="htmlDescription", type="text", length=16777215, nullable=true)
         */
        private ?string $htmlDescription;

        /**
         * @var string|null
         *
         * @ORM\Column(name="image", type="blob", length=16777215, nullable=true)
         */
        private ?string $image;


        /**
         * Get productLine.
         *
         * @return string
         */
        public function getProductLine(): string
        {
            return $this->productLine;
        }

        /**
         * Set textDescription.
         *
         * @param string|null $textDescription
         *
         * @return ProductLines
         */
        public function setTextDescription(string $textDescription = null): self
        {
            $this->textDescription = $textDescription;

            return $this;
        }

        /**
         * Get textDescription.
         *
         * @return string|null
         */
        public function getTextDescription(): ?string
        {
            return $this->textDescription;
        }

        /**
         * Set htmlDescription.
         *
         * @param string|null $htmlDescription
         *
         * @return ProductLines
         */
        public function setHtmlDescription(string $htmlDescription = null): self
        {
            $this->htmlDescription = $htmlDescription;

            return $this;
        }

        /**
         * Get htmlDescription.
         *
         * @return string|null
         */
        public function getHtmlDescription(): ?string
        {
            return $this->htmlDescription;
        }

        /**
         * Set image.
         *
         * @param string|null $image
         *
         * @return ProductLines
         */
        public function setImage(string $image = null): self
        {
            $this->image = $image;

            return $this;
        }

        /**
         * Get image.
         *
         * @return string|null
         */
        public function getImage(): ?string
        {
            return $this->image;
        }
    }
