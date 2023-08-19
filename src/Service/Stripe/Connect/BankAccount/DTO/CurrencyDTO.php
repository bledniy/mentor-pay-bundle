<?php

namespace AppPaymentClient\Service\Stripe\Connect\BankAccount\DTO;

class CurrencyDTO
{
    /**
     * @var string
     */
    private $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}