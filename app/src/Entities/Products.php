<?php

    declare(strict_types=1);

    namespace Entities;

    use Doctrine;
    use Doctrine\ORM\Mapping as ORM;
    use Entities;

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
        private $productcode;

        /**
         * @var string
         *
         * @ORM\Column(name="productName", type="string", length=70, nullable=false)
         */
        private $productname;

        /**
         * @var string
         *
         * @ORM\Column(name="productScale", type="string", length=10, nullable=false)
         */
        private $productscale;

        /**
         * @var string
         *
         * @ORM\Column(name="productVendor", type="string", length=50, nullable=false)
         */
        private $productvendor;

        /**
         * @var string
         *
         * @ORM\Column(name="productDescription", type="text", length=65535, nullable=false)
         */
        private $productdescription;

        /**
         * @var int
         *
         * @ORM\Column(name="quantityInStock", type="smallint", nullable=false)
         */
        private $quantityinstock;

        /**
         * @var string
         *
         * @ORM\Column(name="buyPrice", type="decimal", precision=10, scale=2, nullable=false)
         */
        private $buyprice;

        /**
         * @var string
         *
         * @ORM\Column(name="MSRP", type="decimal", precision=10, scale=2, nullable=false)
         */
        private $msrp;

        /**
         * @var Productlines
         *
         * @ORM\ManyToOne(targetEntity="\\Productlines")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="productLine", referencedColumnName="productLine")
         * })
         */
        private $productline;

        /**
         * @var Doctrine\Common\Collections\Collection
         *
         * @ORM\ManyToMany(targetEntity="\\Orders", mappedBy="productcode")
         */
        private $ordernumber = array();

        /**
         * Constructor
         */
        public function __construct()
        {
            $this->ordernumber = new \Doctrine\Common\Collections\ArrayCollection();
        }

        /**
         * Get productcode.
         *
         * @return string
         */
        public function getProductcode()
        {
            return $this->productcode;
        }

        /**
         * Set productname.
         *
         * @param string $productname
         *
         * @return Products
         */
        public function setProductname($productname): self
        {
            $this->productname = $productname;

            return $this;
        }

        /**
         * Get productname.
         *
         * @return string
         */
        public function getProductname()
        {
            return $this->productname;
        }

        /**
         * Set productscale.
         *
         * @param string $productscale
         *
         * @return Products
         */
        public function setProductscale($productscale): self
        {
            $this->productscale = $productscale;

            return $this;
        }

        /**
         * Get productscale.
         *
         * @return string
         */
        public function getProductscale()
        {
            return $this->productscale;
        }

        /**
         * Set productvendor.
         *
         * @param string $productvendor
         *
         * @return Products
         */
        public function setProductvendor($productvendor): self
        {
            $this->productvendor = $productvendor;

            return $this;
        }

        /**
         * Get productvendor.
         *
         * @return string
         */
        public function getProductvendor()
        {
            return $this->productvendor;
        }

        /**
         * Set productdescription.
         *
         * @param string $productdescription
         *
         * @return Products
         */
        public function setProductdescription($productdescription): self
        {
            $this->productdescription = $productdescription;

            return $this;
        }

        /**
         * Get productdescription.
         *
         * @return string
         */
        public function getProductdescription()
        {
            return $this->productdescription;
        }

        /**
         * Set quantityinstock.
         *
         * @param int $quantityinstock
         *
         * @return Products
         */
        public function setQuantityinstock($quantityinstock): self
        {
            $this->quantityinstock = $quantityinstock;

            return $this;
        }

        /**
         * Get quantityinstock.
         *
         * @return int
         */
        public function getQuantityinstock()
        {
            return $this->quantityinstock;
        }

        /**
         * Set buyprice.
         *
         * @param string $buyprice
         *
         * @return Products
         */
        public function setBuyprice($buyprice): self
        {
            $this->buyprice = $buyprice;

            return $this;
        }

        /**
         * Get buyprice.
         *
         * @return string
         */
        public function getBuyprice()
        {
            return $this->buyprice;
        }

        /**
         * Set msrp.
         *
         * @param string $msrp
         *
         * @return Products
         */
        public function setMsrp($msrp): self
        {
            $this->msrp = $msrp;

            return $this;
        }

        /**
         * Get msrp.
         *
         * @return string
         */
        public function getMsrp()
        {
            return $this->msrp;
        }

        /**
         * Set productline.
         *
         * @param Productlines|null $productline
         *
         * @return Products
         */
        public function setProductline(Productlines $productline = null): self
        {
            $this->productline = $productline;

            return $this;
        }

        /**
         * Get productline.
         *
         * @return Productlines|null
         */
        public function getProductline()
        {
            return $this->productline;
        }

        /**
         * Add ordernumber.
         *
         * @param Orders $ordernumber
         *
         * @return Products
         */
        public function addOrdernumber(Entities\Orders $ordernumber): self
        {
            $this->ordernumber[] = $ordernumber;

            return $this;
        }

        /**
         * Remove ordernumber.
         *
         * @param Orders $ordernumber
         *
         * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
         */
        public function removeOrdernumber(Entities\Orders $ordernumber)
        {
            return $this->ordernumber->removeElement($ordernumber);
        }

        /**
         * Get ordernumber.
         *
         * @return Doctrine\Common\Collections\Collection
         */
        public function getOrdernumber()
        {
            return $this->ordernumber;
        }
    }
