<?php

namespace AppPaymentClient\Service\Stripe;

use AppPaymentClient\Service\ServiceNameProvider;
use Symfony\Component\HttpFoundation\Request;

class StripeCustomerPortalRequestDTOBuilder
{
    /**
     * @var ServiceNameProvider
     */
    private $serviceNameProvider;

    public function __construct(ServiceNameProvider $serviceNameProvider)
    {
        $this->serviceNameProvider = $serviceNameProvider;
    }

    /**
     * @param Request $request
     * @return StripeCustomerPortalRequestDTO|null
     */
    public function buildFromRequest(Request $request): ?StripeCustomerPortalRequestDTO
    {
        $orderId = (int) $request->request->get('order_id');
        $test = (bool)$request->request->getInt('test');
        $returnUrl = $request->request->get('return_url');

        if (!isset($orderId, $returnUrl)) {
            return null;
        }
        return new StripeCustomerPortalRequestDTO(
            $orderId,
            $this->serviceNameProvider->getServiceName(),
            $test,
            $returnUrl,
            (int) $request->request->get('plan_id')
        );
    }
}
