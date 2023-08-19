<?php

namespace AppPaymentClient\Service\Stripe\Price\DTO;

class CurrencyAmountDTO
{
    /**
     * @var string
     */
    private $currency;
    /**
     * @var float
     */
    private $amount;

    public function __construct(string $currency, float $amount)
    {
        $this->currency = $currency;
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param string $currency
     * @param float $amount
     * @return static
     */
    public static function make(string $currency, float $amount): self
    {
        return new self($currency, $amount);
    }
}