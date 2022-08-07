<?php

    declare(strict_types=1);

    namespace App\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * Payments
     *
     * @ORM\Table(name="payments", indexes={@ORM\Index(name="IDX_65D29B32D53183C5", columns={"customerNumber"})})
     * @ORM\Entity
     */
    class Payments
    {
        /**
         * @var string
         *
         * @ORM\Column(name="checkNumber", type="string", length=50, nullable=false)
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="NONE")
         */
        private string $checkNumber;

        /**
         * @var \DateTime
         *
         * @ORM\Column(name="paymentDate", type="date", nullable=false)
         */
        private \DateTime $paymentDate;

        /**
         * @var string
         *
         * @ORM\Column(name="amount", type="decimal", precision=10, scale=2, nullable=false)
         */
        private string $amount;

        /**
         * @var Customers
         *
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="NONE")
         * @ORM\OneToOne(targetEntity="\App\Entity\Customers")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="customerNumber", referencedColumnName="customerNumber")
         * })
         */
        private Customers $customerNumber;


        /**
         * Set checkNumber.
         *
         * @param string $checkNumber
         *
         * @return Payments
         */
        public function setCheckNumber(string $checkNumber): self
        {
            $this->checkNumber = $checkNumber;

            return $this;
        }

        /**
         * Get checkNumber.
         *
         * @return string
         */
        public function getCheckNumber(): string
        {
            return $this->checkNumber;
        }

        /**
         * Set paymentDate.
         *
         * @param \DateTime $paymentDate
         *
         * @return Payments
         */
        public function setPaymentDate(\DateTime $paymentDate): self
        {
            $this->paymentDate = $paymentDate;

            return $this;
        }

        /**
         * Get paymentDate.
         *
         * @return \DateTime
         */
        public function getPaymentDate(): \DateTime
        {
            return $this->paymentDate;
        }

        /**
         * Set amount.
         *
         * @param string $amount
         *
         * @return Payments
         */
        public function setAmount(string $amount): self
        {
            $this->amount = $amount;

            return $this;
        }

        /**
         * Get amount.
         *
         * @return string
         */
        public function getAmount(): string
        {
            return $this->amount;
        }

        /**
         * Set customerNumber.
         *
         * @param Customers $customerNumber
         *
         * @return Payments
         */
        public function setCustomerNumber(Customers $customerNumber): self
        {
            $this->customerNumber = $customerNumber;

            return $this;
        }

        /**
         * Get customerNumber.
         *
         * @return Customers
         */
        public function getCustomerNumber(): Customers
        {
            return $this->customerNumber;
        }
    }
