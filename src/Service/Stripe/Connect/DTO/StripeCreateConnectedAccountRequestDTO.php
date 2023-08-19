<?php

namespace AppPaymentClient\Service\Stripe\Connect\DTO;

class StripeCreateConnectedAccountRequestDTO
{
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $country;
    /**
     * @var bool
     */
    private $test;

    public function __construct(string $email, string $country, bool $test)
    {
        $this->email = $email;
        $this->country = $country;
        $this->test = $test;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return bool
     */
    public function isTest(): bool
    {
        return $this->test;
    }
}