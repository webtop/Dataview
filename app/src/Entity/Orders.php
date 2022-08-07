<?php

    declare(strict_types=1);

    namespace App\Entity;

    use Doctrine;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\ORM\Mapping as ORM;
    use App\Entity;

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
        private int $orderNumber;

        /**
         * @var \DateTime
         *
         * @ORM\Column(name="orderDate", type="date", nullable=false)
         */
        private \DateTime $orderDate;

        /**
         * @var \DateTime
         *
         * @ORM\Column(name="requiredDate", type="date", nullable=false)
         */
        private \DateTime $requiredDate;

        /**
         * @var \DateTime|null
         *
         * @ORM\Column(name="shippedDate", type="date", nullable=true)
         */
        private ?\DateTime $shippedDate;

        /**
         * @var string
         *
         * @ORM\Column(name="status", type="string", length=15, nullable=false)
         */
        private string $status;

        /**
         * @var string|null
         *
         * @ORM\Column(name="comments", type="text", length=65535, nullable=true)
         */
        private ?string $comments;

        /**
         * @var Customers
         *
         * @ORM\ManyToOne(targetEntity="\App\Entity\Customers")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="customerNumber", referencedColumnName="customerNumber")
         * })
         */
        private Customers $customerNumber;

        /**
         * @var Doctrine\Common\Collections\Collection
         *
         * @ORM\ManyToMany(targetEntity="\App\Entity\Products", inversedBy="orderNumber")
         * @ORM\JoinTable(name="orderdetails",
         *   joinColumns={
         *	 @ORM\JoinColumn(name="orderNumber", referencedColumnName="orderNumber")
         *   },
         *   inverseJoinColumns={
         *	 @ORM\JoinColumn(name="productCode", referencedColumnName="productCode")
         *   }
         * )
         */
        private $productCode = array();

        /**
         * Constructor
         */
        public function __construct()
        {
            $this->productCode = new ArrayCollection();
        }

        /**
         * Get orderNumber.
         *
         * @return int
         */
        public function getOrderNumber(): int
        {
            return $this->orderNumber;
        }

        /**
         * Set orderDate.
         *
         * @param \DateTime $orderDate
         *
         * @return Orders
         */
        public function setOrderDate(\DateTime $orderDate): self
        {
            $this->orderDate = $orderDate;

            return $this;
        }

        /**
         * Get orderDate.
         *
         * @return \DateTime
         */
        public function getOrderDate(): \DateTime
        {
            return $this->orderDate;
        }

        /**
         * Set requiredDate.
         *
         * @param \DateTime $requiredDate
         *
         * @return Orders
         */
        public function setRequiredDate(\DateTime $requiredDate): self
        {
            $this->requiredDate = $requiredDate;

            return $this;
        }

        /**
         * Get requiredDate.
         *
         * @return \DateTime
         */
        public function getRequiredDate(): \DateTime
        {
            return $this->requiredDate;
        }

        /**
         * Set shippedDate.
         *
         * @param \DateTime|null $shippedDate
         *
         * @return Orders
         */
        public function setShippedDate(\DateTime $shippedDate = null): self
        {
            $this->shippedDate = $shippedDate;

            return $this;
        }

        /**
         * Get shippedDate.
         *
         * @return \DateTime|null
         */
        public function getShippedDate(): ?\DateTime
        {
            return $this->shippedDate;
        }

        /**
         * Set status.
         *
         * @param string $status
         *
         * @return Orders
         */
        public function setStatus(string $status): self
        {
            $this->status = $status;

            return $this;
        }

        /**
         * Get status.
         *
         * @return string
         */
        public function getStatus(): string
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
        public function setComments(string $comments = null): self
        {
            $this->comments = $comments;

            return $this;
        }

        /**
         * Get comments.
         *
         * @return string|null
         */
        public function getComments(): ?string
        {
            return $this->comments;
        }

        /**
         * Set customerNumber.
         *
         * @param Customers|null $customerNumber
         *
         * @return Orders
         */
        public function setCustomerNumber(Customers $customerNumber = null): self
        {
            $this->customerNumber = $customerNumber;

            return $this;
        }

        /**
         * Get customerNumber.
         *
         * @return Customers|null
         */
        public function getCustomerNumber(): ?Customers
        {
            return $this->customerNumber;
        }

        /**
         * Add productCode.
         *
         * @param Products $productCode
         *
         * @return Orders
         */
        public function addProductCode(Entity\Products $productCode): self
        {
            $this->productCode[] = $productCode;

            return $this;
        }

        /**
         * Remove productCode.
         *
         * @param Products $productCode
         *
         * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
         */
        public function removeProductCode(Entity\Products $productCode): bool
        {
            return $this->productCode->removeElement($productCode);
        }

        /**
         * Get productCode.
         *
         * @return ArrayCollection|Collection
         */
        public function getProductCode(): ArrayCollection|Collection
        {
            return $this->productCode;
        }
    }
