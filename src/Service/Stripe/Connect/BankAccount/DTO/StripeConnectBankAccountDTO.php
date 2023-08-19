<?php

namespace AppPaymentClient\Service\Stripe\Connect\BankAccount\DTO;

class StripeConnectBankAccountDTO
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $type;
    /**
     * @var string|null
     */
    private $holderName;
    /**
     * @var string|null
     */
    private $holderType;
    /**
     * @var string|null
     */
    private $bankName;
    /**
     * @var string
     */
    private $country;
    /**
     * @var string
     */
    private $currency;

    public function __construct(
        string $id,
        string $type,
        ?string $holderName,
        ?string $holderType,
        ?string $bankName,
        string $country,
        string $currency
    )
    {
        $this->id = $id;
        $this->type = $type;
        $this->holderName = $holderName;
        $this->holderType = $holderType;
        $this->bankName = $bankName;
        $this->country = $country;
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getHolderName(): ?string
    {
        return $this->holderName;
    }

    /**
     * @return string|null
     */
    public function getHolderType(): ?string
    {
        return $this->holderType;
    }

    /**
     * @return string|null
     */
    public function getBankName(): ?string
    {
        return $this->bankName;
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
}