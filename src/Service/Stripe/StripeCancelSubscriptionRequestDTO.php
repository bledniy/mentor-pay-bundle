<?php

namespace AppPaymentClient\Service\Stripe;

class StripeCancelSubscriptionRequestDTO
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
     * @var int|null
     */
    private $planId;

    /**
     * @var bool
     */
    private $disableLogs;

    public function __construct(string $serviceName, string $orderId, ?int $planId, bool $disableLogs = false)
    {
        $this->serviceName = $serviceName;
        $this->orderId = $orderId;
        $this->planId = $planId;
        $this->disableLogs = $disableLogs;
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
     * @return int|null
     */
    public function getPlanId(): ?int
    {
        return $this->planId;
    }

    /**
     * @return bool
     */
    public function isDisableLogs(): bool
    {
        return $this->disableLogs;
    }
}
