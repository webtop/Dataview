<?php

    declare(strict_types=1);

    namespace App\Entity;

    use Doctrine;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\ORM\Mapping as ORM;
    use App\Entity;

    /**
     * Products
     *
     * @ORM\Table(name="products", indexes={@ORM\Index(name="productLine", columns={"productLine"})})
     * @ORM\Entity
     */
    class Products
    {
        /**
         * @var string
         *
         * @ORM\Column(name="productCode", type="string", length=15, nullable=false)
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="IDENTITY")
         */
        private string $productCode;

        /**
         * @var string
         *
         * @ORM\Column(name="productName", type="string", length=70, nullable=false)
         */
        private string $productName;

        /**
         * @var string
         *
         * @ORM\Column(name="productScale", type="string", length=10, nullable=false)
         */
        private string $productScale;

        /**
         * @var string
         *
         * @ORM\Column(name="productVendor", type="string", length=50, nullable=false)
         */
        private string $productVendor;

        /**
         * @var string
         *
         * @ORM\Column(name="productDescription", type="text", length=65535, nullable=false)
         */
        private string $productDescription;

        /**
         * @var int
         *
         * @ORM\Column(name="quantityInStock", type="smallint", nullable=false)
         */
        private int $quantityInStock;

        /**
         * @var float
         *
         * @ORM\Column(name="buyPrice", type="decimal", precision=10, scale=2, nullable=false)
         */
        private float $buyPrice;

        /**
         * @var float
         *
         * @ORM\Column(name="MSRP", type="decimal", precision=10, scale=2, nullable=false)
         */
        private float $msrp;

        /**
         * @var ProductLines
         *
         * @ORM\ManyToOne(targetEntity="\App\Entity\ProductLines")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="productLine", referencedColumnName="productLine")
         * })
         */
        private ProductLines $productLine;

        /**
         * @var Doctrine\Common\Collections\Collection
         *
         * @ORM\ManyToMany(targetEntity="\App\Entity\Orders", mappedBy="productCode")
         */
        private $orderNumber = array();

        /**
         * Constructor
         */
        public function __construct()
        {
            $this->orderNumber = new ArrayCollection();
        }

        /**
         * Get productCode.
         *
         * @return string
         */
        public function getProductCode(): string
        {
            return $this->productCode;
        }

        /**
         * Set productName.
         *
         * @param string $productName
         *
         * @return Products
         */
        public function setProductName(string $productName): self
        {
            $this->productName = $productName;

            return $this;
        }

        /**
         * Get productName.
         *
         * @return string
         */
        public function getProductName(): string
        {
            return $this->productName;
        }

        /**
         * Set productScale.
         *
         * @param string $productScale
         *
         * @return Products
         */
        public function setProductScale(string $productScale): self
        {
            $this->productScale = $productScale;

            return $this;
        }

        /**
         * Get productScale.
         *
         * @return string
         */
        public function getProductScale(): string
        {
            return $this->productScale;
        }

        /**
         * Set productVendor.
         *
         * @param string $productVendor
         *
         * @return Products
         */
        public function setProductVendor(string $productVendor): self
        {
            $this->productVendor = $productVendor;

            return $this;
        }

        /**
         * Get productVendor.
         *
         * @return string
         */
        public function getProductVendor(): string
        {
            return $this->productVendor;
        }

        /**
         * Set productDescription.
         *
         * @param string $productDescription
         *
         * @return Products
         */
        public function setProductDescription(string $productDescription): self
        {
            $this->productDescription = $productDescription;

            return $this;
        }

        /**
         * Get productDescription.
         *
         * @return string
         */
        public function getProductDescription(): string
        {
            return $this->productDescription;
        }

        /**
         * Set quantityInStock.
         *
         * @param int $quantityInStock
         *
         * @return Products
         */
        public function setQuantityInStock(int $quantityInStock): self
        {
            $this->quantityInStock = $quantityInStock;

            return $this;
        }

        /**
         * Get quantityInStock.
         *
         * @return int
         */
        public function getQuantityInStock(): int
        {
            return $this->quantityInStock;
        }

        /**
         * Set buyPrice.
         *
         * @param float $buyPrice
         *
         * @return Products
         */
        public function setBuyPrice(float $buyPrice): self
        {
            $this->buyPrice = $buyPrice;

            return $this;
        }

        /**
         * Get buyPrice.
         *
         * @return float
         */
        public function getBuyPrice(): float
        {
            return $this->buyPrice;
        }

        /**
         * Set msrp.
         *
         * @param float $msrp
         *
         * @return Products
         */
        public function setMsrp(float $msrp): self
        {
            $this->msrp = $msrp;

            return $this;
        }

        /**
         * Get msrp.
         *
         * @return float
         */
        public function getMsrp(): float
        {
            return $this->msrp;
        }

        /**
         * Set productLine.
         *
         * @param ProductLines|null $productLine
         *
         * @return Products
         */
        public function setProductLine(ProductLines $productLine = null): self
        {
            $this->productLine = $productLine;

            return $this;
        }

        /**
         * Get productLine.
         *
         * @return ProductLines|null
         */
        public function getProductLine(): ?ProductLines
        {
            return $this->productLine;
        }

        /**
         * Add orderNumber.
         *
         * @param Orders $orderNumber
         *
         * @return Products
         */
        public function addOrderNumber(Entity\Orders $orderNumber): self
        {
            $this->orderNumber[] = $orderNumber;

            return $this;
        }

        /**
         * Remove orderNumber.
         *
         * @param Orders $orderNumber
         *
         * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
         */
        public function removeOrderNumber(Entity\Orders $orderNumber): bool
        {
            return $this->orderNumber->removeElement($orderNumber);
        }

        /**
         * Get orderNumber.
         *
         * @return ArrayCollection|Collection
         */
        public function getOrderNumber(): ArrayCollection|Collection
        {
            return $this->orderNumber;
        }
    }
