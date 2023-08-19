<?php

namespace AppPaymentClient\Service\Stripe;

use AppPaymentClient\Service\ServiceNameProvider;

class StripeCancelSubscriptionRequestDTOBuilder
{
    /**
     * @var ServiceNameProvider
     */
    private $serviceNameProvider;

    public function __construct(ServiceNameProvider $serviceNameProvider)
    {
        $this->serviceNameProvider = $serviceNameProvider;
    }

    public function build(
        string $orderId,
        ?int $planId = null,
        bool $disableLogs = false
    ): StripeCancelSubscriptionRequestDTO {
        return new StripeCancelSubscriptionRequestDTO(
            $this->serviceNameProvider->getServiceName(),
            $orderId,
            $planId,
            $disableLogs
        );
    }
}