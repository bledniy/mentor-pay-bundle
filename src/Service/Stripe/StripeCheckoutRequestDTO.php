<?php

namespace AppPaymentClient\Service\Stripe;

class StripeCheckoutRequestDTO
{
    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $serviceName;

    /**
     * @var string
     */
    private $successUrl;

    /**
     * @var string
     */
    private $cancelUrl;

    /**
     * @var string
     */
    private $webhookUrl;

    /**
     * @var int
     */
    private $orderId;

    /**
     * @var bool
     */
    private $test;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string|null
     */
    private $transferData;

    public function __construct(
        int $amount,
        string $serviceName,
        string $successUrl,
        string $cancelUrl,
        string $webhookUrl,
        int $orderId,
        bool $test,
        ?string $title,
        string $currency,
        ?string $description = null,
        ?string $transferData = null
    )
    {
        $this->amount = $amount;
        $this->serviceName = $serviceName;
        $this->successUrl = $successUrl;
        $this->cancelUrl = $cancelUrl;
        $this->webhookUrl = $webhookUrl;
        $this->orderId = $orderId;
        $this->test = $test;
        $this->title = $title;
        $this->currency = $currency;
        $this->description = $description;
        $this->transferData = $transferData;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    /**
     * @return string
     */
    public function getSuccessUrl(): string
    {
        return $this->successUrl;
    }

    /**
     * @return string
     */
    public function getCancelUrl(): string
    {
        return $this->cancelUrl;
    }

    /**
     * @return string
     */
    public function getWebhookUrl(): string
    {
        return $this->webhookUrl;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getTest(): bool
    {
        return $this->test;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getTransferData(): ?string
    {
        return $this->transferData;
    }
}