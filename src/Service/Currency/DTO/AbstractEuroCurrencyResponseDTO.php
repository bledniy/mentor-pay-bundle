<?php

namespace AppPaymentClient\Service\Currency\DTO;

abstract class AbstractEuroCurrencyResponseDTO
{
    /**
     * @var string
     */
    private $currency;
    /**
     * @var float
     */
    private $rate;
    /**
     * @var float
     */
    private $amount;

    public function __construct(string $currency, float $rate, float $amount)
    {
        $this->currency = $currency;
        $this->rate = $rate;
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
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}