<?php

    declare(strict_types=1);

    namespace Entities;

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
        private $checknumber;

        /**
         * @var \DateTime
         *
         * @ORM\Column(name="paymentDate", type="date", nullable=false)
         */
        private $paymentdate;

        /**
         * @var string
         *
         * @ORM\Column(name="amount", type="decimal", precision=10, scale=2, nullable=false)
         */
        private $amount;

        /**
         * @var Customers
         *
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="NONE")
         * @ORM\OneToOne(targetEntity="\\Customers")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="customerNumber", referencedColumnName="customerNumber")
         * })
         */
        private $customernumber;


        /**
         * Set checknumber.
         *
         * @param string $checknumber
         *
         * @return Payments
         */
        public function setChecknumber($checknumber): self
        {
            $this->checknumber = $checknumber;

            return $this;
        }

        /**
         * Get checknumber.
         *
         * @return string
         */
        public function getChecknumber()
        {
            return $this->checknumber;
        }

        /**
         * Set paymentdate.
         *
         * @param \DateTime $paymentdate
         *
         * @return Payments
         */
        public function setPaymentdate($paymentdate): self
        {
            $this->paymentdate = $paymentdate;

            return $this;
        }

        /**
         * Get paymentdate.
         *
         * @return \DateTime
         */
        public function getPaymentdate()
        {
            return $this->paymentdate;
        }

        /**
         * Set amount.
         *
         * @param string $amount
         *
         * @return Payments
         */
        public function setAmount($amount): self
        {
            $this->amount = $amount;

            return $this;
        }

        /**
         * Get amount.
         *
         * @return string
         */
        public function getAmount()
        {
            return $this->amount;
        }

        /**
         * Set customernumber.
         *
         * @param Customers $customernumber
         *
         * @return Payments
         */
        public function setCustomernumber(Customers $customernumber): self
        {
            $this->customernumber = $customernumber;

            return $this;
        }

        /**
         * Get customernumber.
         *
         * @return Customers
         */
        public function getCustomernumber()
        {
            return $this->customernumber;
        }
    }
