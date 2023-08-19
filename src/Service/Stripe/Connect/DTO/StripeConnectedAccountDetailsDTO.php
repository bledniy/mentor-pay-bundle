<?php

namespace AppPaymentClient\Service\Stripe\Connect\DTO;

class StripeConnectedAccountDetailsDTO
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string|null
     */
    private $businessType;
    /**
     * @var array
     */
    private $capabilities;
    /**
     * @var string
     */
    private $country;
    /**
     * @var string|null
     */
    private $email;
    /**
     * @var bool
     */
    private $detailsSubmitted;

    public function __construct(string $id, ?string $businessType, array $capabilities, string $country, ?string $email, bool $detailsSubmitted)
    {
        $this->id = $id;
        $this->businessType = $businessType;
        $this->capabilities = $capabilities;
        $this->country = $country;
        $this->email = $email;
        $this->detailsSubmitted = $detailsSubmitted;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getBusinessType(): ?string
    {
        return $this->businessType;
    }

    /**
     * @return array
     */
    public function getCapabilities(): array
    {
        return $this->capabilities;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return bool
     */
    public function getDetailsSubmitted(): bool
    {
        return $this->detailsSubmitted;
    }
}