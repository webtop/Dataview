<?php

    declare(strict_types=1);

    namespace Entities;

    use Doctrine;
    use Doctrine\ORM\Mapping as ORM;
    use Entities;

    /**
     * Orders
     *
     * @ORM\Table(name="orders", indexes={@ORM\Index(name="customerNumber", columns={"customerNumber"})})
     * @ORM\Entity
     */
    class Orders
    {
        /**
         * @var int
         *
         * @ORM\Column(name="orderNumber", type="integer", nullable=false)
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="IDENTITY")
         */
        private $ordernumber;

        /**
         * @var \DateTime
         *
         * @ORM\Column(name="orderDate", type="date", nullable=false)
         */
        private $orderdate;

        /**
         * @var \DateTime
         *
         * @ORM\Column(name="requiredDate", type="date", nullable=false)
         */
        private $requireddate;

        /**
         * @var \DateTime|null
         *
         * @ORM\Column(name="shippedDate", type="date", nullable=true)
         */
        private $shippeddate;

        /**
         * @var string
         *
         * @ORM\Column(name="status", type="string", length=15, nullable=false)
         */
        private $status;

        /**
         * @var string|null
         *
         * @ORM\Column(name="comments", type="text", length=65535, nullable=true)
         */
        private $comments;

        /**
         * @var Customers
         *
         * @ORM\ManyToOne(targetEntity="\\Customers")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="customerNumber", referencedColumnName="customerNumber")
         * })
         */
        private $customernumber;

        /**
         * @var Doctrine\Common\Collections\Collection
         *
         * @ORM\ManyToMany(targetEntity="\\Products", inversedBy="ordernumber")
         * @ORM\JoinTable(name="orderdetails",
         *   joinColumns={
         *	 @ORM\JoinColumn(name="orderNumber", referencedColumnName="orderNumber")
         *   },
         *   inverseJoinColumns={
         *	 @ORM\JoinColumn(name="productCode", referencedColumnName="productCode")
         *   }
         * )
         */
        private $productcode = array();

        /**
         * Constructor
         */
        public function __construct()
        {
            $this->productcode = new \Doctrine\Common\Collections\ArrayCollection();
        }

        /**
         * Get ordernumber.
         *
         * @return int
         */
        public function getOrdernumber()
        {
            return $this->ordernumber;
        }

        /**
         * Set orderdate.
         *
         * @param \DateTime $orderdate
         *
         * @return Orders
         */
        public function setOrderdate($orderdate): self
        {
            $this->orderdate = $orderdate;

            return $this;
        }

        /**
         * Get orderdate.
         *
         * @return \DateTime
         */
        public function getOrderdate()
        {
            return $this->orderdate;
        }

        /**
         * Set requireddate.
         *
         * @param \DateTime $requireddate
         *
         * @return Orders
         */
        public function setRequireddate($requireddate): self
        {
            $this->requireddate = $requireddate;

            return $this;
        }

        /**
         * Get requireddate.
         *
         * @return \DateTime
         */
        public function getRequireddate()
        {
            return $this->requireddate;
        }

        /**
         * Set shippeddate.
         *
         * @param \DateTime|null $shippeddate
         *
         * @return Orders
         */
        public function setShippeddate($shippeddate = null): self
        {
            $this->shippeddate = $shippeddate;

            return $this;
        }

        /**
         * Get shippeddate.
         *
         * @return \DateTime|null
         */
        public function getShippeddate()
        {
            return $this->shippeddate;
        }

        /**
         * Set status.
         *
         * @param string $status
         *
         * @return Orders
         */
        public function setStatus($status): self
        {
            $this->status = $status;

            return $this;
        }

        /**
         * Get status.
         *
         * @return string
         */
        public function getStatus()
        {
            return $this->status;
        }

        /**
         * Set comments.
         *
         * @param string|null $comments
         *
         * @return Orders
         */
        public function setComments($comments = null): self
        {
            $this->comments = $comments;

            return $this;
        }

        /**
         * Get comments.
         *
         * @return string|null
         */
        public function getComments()
        {
            return $this->comments;
        }

        /**
         * Set customernumber.
         *
         * @param Customers|null $customernumber
         *
         * @return Orders
         */
        public function setCustomernumber(Customers $customernumber = null): self
        {
            $this->customernumber = $customernumber;

            return $this;
        }

        /**
         * Get customernumber.
         *
         * @return Customers|null
         */
        public function getCustomernumber()
        {
            return $this->customernumber;
        }

        /**
         * Add productcode.
         *
         * @param Products $productcode
         *
         * @return Orders
         */
        public function addProductcode(Entities\Products $productcode): self
        {
            $this->productcode[] = $productcode;

            return $this;
        }

        /**
         * Remove productcode.
         *
         * @param Products $productcode
         *
         * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
         */
        public function removeProductcode(Entities\Products $productcode)
        {
            return $this->productcode->removeElement($productcode);
        }

        /**
         * Get productcode.
         *
         * @return Doctrine\Common\Collections\Collection
         */
        public function getProductcode()
        {
            return $this->productcode;
        }
    }
