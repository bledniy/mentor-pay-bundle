<?php

namespace AppPaymentClient\Service\Stripe\Connect\DTO;

class StripeConnectedAccountDetailsRequestDTO
{
    /**
     * @var string
     */
    private $accountId;
    /**
     * @var bool
     */
    private $test;

    public function __construct(string $accountId, bool $test = false)
    {
        $this->accountId = $accountId;
        $this->test = $test;
    }

    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->accountId;
    }

    /**
     * @return bool
     */
    public function isTest(): bool
    {
        return $this->test;
    }
}