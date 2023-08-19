<?php

namespace AppPaymentClient\Service\Stripe\Connect\DTO;

class StripeConnectedAccountDTO
{
    /**
     * @var string
     */
    private $accountId;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $country;

    public function __construct(string $accountId, string  $email, string $country)
    {
        $this->accountId = $accountId;
        $this->email = $email;
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->accountId;
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
}