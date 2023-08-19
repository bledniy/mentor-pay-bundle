<?php

namespace AppPaymentClient\Service\Stripe;


class StripeCustomerPortalRequestDTO
{
    /**
     * @var int
     */
    private $orderId;
    /**
     * @var string
     */
    private $serviceName;
    /**
     * @var bool
     */
    private $test;
    /**
     * @var string
     */
    private $returnUrl;
    /**
     * @var int|null
     */
    private $planId;

    public function __construct(
        int $orderId,
        string $serviceName,
        bool $test,
        string $returnUrl,
        ?int $planId
    )
    {
        $this->orderId = $orderId;
        $this->serviceName = $serviceName;
        $this->test = $test;
        $this->returnUrl = $returnUrl;
        $this->planId = $planId;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @return string
     */
    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    /**
     * @return bool
     */
    public function isTest(): bool
    {
        return $this->test;
    }

    /**
     * @return string
     */
    public function getReturnUrl(): string
    {
        return $this->returnUrl;
    }

    /**
     * @return int|null
     */
    public function getPlanId(): ?int
    {
        return $this->planId;
    }
}