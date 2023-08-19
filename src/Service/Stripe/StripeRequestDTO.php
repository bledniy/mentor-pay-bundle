<?php

namespace AppPaymentClient\Service\Stripe;

class StripeRequestDTO
{
    /**
     * @var string
     */
    private $serviceName;

    /**
     * @var string
     */
    private $orderId;

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
    private $plan;

    /**
     * @var bool
     */
    private $test;
    /**
     * @var string|null
     */
    private $coupon;
    /**
     * @var string|null
     */
    private $currency;
    /**
     * @var \DateTimeInterface|null
     */
    private $delayDate;
    /**
     * @var int|null
     */
    private $amountDiscount;
    /**
     * @var string|null
     */
    private $customerId;

    public function __construct(
        string $serviceName,
        string $orderId,
        string $successUrl,
        string $cancelUrl,
        string $webhookUrl,
        int $plan,
        bool $test,
        ?string $coupon = null,
        ?string $currency = null,
        ?\DateTimeInterface $delayDate = null,
        ?int $amountDiscount = null,
        ?string $customerId = null
    )
    {
        $this->serviceName = $serviceName;
        $this->orderId = $orderId;
        $this->successUrl = $successUrl;
        $this->cancelUrl = $cancelUrl;
        $this->webhookUrl = $webhookUrl;
        $this->plan = $plan;
        $this->test = $test;
        $this->coupon = $coupon;
        $this->currency = $currency;
        $this->delayDate = $delayDate;
        $this->amountDiscount = $amountDiscount;
        $this->customerId = $customerId;
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
    public function getOrderId(): string
    {
        return $this->orderId;
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
    public function getPlan(): int
    {
        return $this->plan;
    }

    public function getTest(): bool
    {
        return $this->test;
    }

    public function getCoupon(): ?string
    {
        return $this->coupon;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDelayDate(): ?\DateTimeInterface
    {
        return $this->delayDate;
    }

    /**
     * @return int|null
     */
    public function getAmountDiscount(): ?int
    {
        return $this->amountDiscount;
    }

    /**
     * @return string|null
     */
    public function getCustomerId(): ?string
    {
        return $this->customerId;
    }
}
