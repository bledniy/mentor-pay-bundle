<?php

namespace AppPaymentClient\Service\Stripe\Connect\BankAccount\DTO;

class CountryDTO
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $code;

    public function __construct(string $name, string $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}