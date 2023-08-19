<?php

namespace AppPaymentClient\Service\Stripe\Coupon\DTO;

class CouponDTO
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
     * @var int
     */
    private $timesRedeemed;
    /**
     * @var int|null
     */
    private $maxRedemptions;
    /**
     * @var bool
     */
    private $test;

    public function __construct(
        string $id,
        string $name,
        float $value,
        int $timesRedeemed,
        ?int $maxRedemptions,
        bool $test
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->timesRedeemed = $timesRedeemed;
        $this->maxRedemptions = $maxRedemptions;
        $this->test = $test;
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
     * @return int
     */
    public function getTimesRedeemed(): int
    {
        return $this->timesRedeemed;
    }

    /**
     * @return int|null
     */
    public function getMaxRedemptions(): ?int
    {
        return $this->maxRedemptions;
    }

    public function isTest(): bool
    {
        return $this->test;
    }

    /**
     * @param string $id
     * @param string $name
     * @param float $value
     * @param int $timesRedeemed
     * @param int|null $maxRedemptions
     * @param bool $test
     * @return static
     */
    public static function make(
        string $id,
        string $name,
        float $value,
        int $timesRedeemed,
        ?int $maxRedemptions,
        bool $test
    ): self
    {
        return new self($id, $name, $value, $timesRedeemed, $maxRedemptions, $test);
    }
}