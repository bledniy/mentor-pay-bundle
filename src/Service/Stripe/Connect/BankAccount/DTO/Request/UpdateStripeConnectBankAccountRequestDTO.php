<?php

namespace AppPaymentClient\Service\Stripe\Connect\BankAccount\DTO\Request;

class UpdateStripeConnectBankAccountRequestDTO
{
    /**
     * @var string
     */
    private $accountId;
    /**
     * @var string
     */
    private $bankAccountId;
    /**
     * @var string
     */
    private $holderName;
    /**
     * @var bool
     */
    private $test;

    public function __construct(string $accountId, string $bankAccountId, string $holderName, bool $test = false)
    {
        $this->accountId = $accountId;
        $this->bankAccountId = $bankAccountId;
        $this->holderName = $holderName;
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
     * @return string
     */
    public function getBankAccountId(): string
    {
        return $this->bankAccountId;
    }

    /**
     * @return string
     */
    public function getHolderName(): string
    {
        return $this->holderName;
    }

    /**
     * @return bool
     */
    public function isTest(): bool
    {
        return $this->test;
    }
}