<?php

namespace AppPaymentClient\Service\Stripe\Connect\BankAccount\DTO\Request;

use AppPaymentClient\Service\Stripe\Connect\BankAccount\BankAccountTypes;

class CreateStripeConnectBankAccountRequestDTO
{
    /**
     * @var string
     */
    private $accountId;
    /**
     * @var string
     */
    private $country;
    /**
     * @var string
     */
    private $currency;
    /**
     * @var string
     */
    private $holderName;
    /**
     * @var string
     */
    private $accountNumber;
    /**
     * @var string
     */
    private $type;
    /**
     * @var bool
     */
    private $test;

    public function __construct(
        string $accountId,
        string $country,
        string $currency,
        string $holderName,
        string $accountNumber,
        string $type = BankAccountTypes::BANK_ACCOUNT,
        bool $test = false
    )
    {
        $this->accountId = $accountId;
        $this->country = $country;
        $this->currency = $currency;
        $this->holderName = $holderName;
        $this->accountNumber = $accountNumber;
        $this->type = $type;
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
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getHolderName(): string
    {
        return $this->holderName;
    }

    /**
     * @return string
     */
    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isTest(): bool
    {
        return $this->test;
    }
}