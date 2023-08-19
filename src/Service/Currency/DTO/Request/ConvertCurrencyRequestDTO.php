<?php

namespace AppPaymentClient\Service\Currency\DTO\Request;

class ConvertCurrencyRequestDTO
{
    /**
     * @var string
     */
    private $from;
    /**
     * @var string
     */
    private $to;
    /**
     * @var float
     */
    private $amount;

    public function __construct(string $from, string $to, float $amount = 1.0)
    {
        $this->from = $from;
        $this->to = $to;
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return static
     */
    public static function create(string $from, string $to, float $amount = 1.0): self
    {
        return new self($from, $to, $amount);
    }
}