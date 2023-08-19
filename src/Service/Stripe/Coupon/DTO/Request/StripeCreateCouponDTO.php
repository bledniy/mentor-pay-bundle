<?php

namespace AppPaymentClient\Service\Stripe\Coupon\DTO\Request;

class StripeCreateCouponDTO
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var float
     */
    private $value;
    /**
     * @var bool
     */
    private $test;
    /**
     * @var int|null
     */
    private $maxRedemptions;

    public function __construct(string $id, string $name, float $value, bool $test = false, ?int $maxRedemptions = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->test = $test;
        $this->maxRedemptions = $maxRedemptions;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function getTest(): bool
    {
        return $this->test;
    }

    /**
     * @return int|null
     */
    public function getMaxRedemptions(): ?int
    {
        return $this->maxRedemptions;
    }

    /**
     * @param string $id
     * @param string $name
     * @param float $value
     * @param bool $test
     * @param int|null $maxRedemptions
     * @return static
     */
    public static function make(
        string $id,
        string $name,
        float $value,
        bool $test = false,
        ?int $maxRedemptions = null
    ): self
    {
        return new self($id, $name, $value, $test, $maxRedemptions);
    }
}