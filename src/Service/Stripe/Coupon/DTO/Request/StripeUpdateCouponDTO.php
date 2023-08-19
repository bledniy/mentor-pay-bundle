<?php

namespace AppPaymentClient\Service\Stripe\Coupon\DTO\Request;

class StripeUpdateCouponDTO
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var bool
     */
    private $test;

    public function __construct(string $name, bool $test = false)
    {
        $this->name = $name;
        $this->test = $test;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function getTest(): bool
    {
        return $this->test;
    }

    /**
     * @param string $name
     * @param bool $test
     * @return static
     */
    public static function make(string $name, bool $test = false): self
    {
        return new self($name, $test);
    }
}