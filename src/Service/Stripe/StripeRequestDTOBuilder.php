<?php

namespace AppPaymentClient\Service\Stripe;

use Symfony\Component\HttpFoundation\Request;

class StripeRequestDTOBuilder
{
    /**
     * @param Request $request
     * @return StripeRequestDTO|null
     */
    public static function buildFromRequest(Request $request): ?StripeRequestDTO
    {
        $plan = $request->request->getInt('plan_type');
        $test = (bool)$request->request->getInt('test');
        $serviceName = $request->request->get('service_name');
        $orderId = $request->request->get('order_id');
        $successUrl = $request->request->get('success_url');
        $cancelUrl = $request->request->get('cancel_url');
        $webhookUrl = $request->request->get('webhook_url');
        $coupon = $request->request->get('coupon');
        $currency = $request->request->get('currency');
        if (empty($coupon)) {
            $coupon = null;
        }
        if (empty($currency)) {
            $currency = null;
        }
        if (!isset($plan, $test, $serviceName, $orderId, $successUrl, $cancelUrl, $webhookUrl)) {
            return null;
        }
        return new StripeRequestDTO($serviceName, $orderId, $successUrl, $cancelUrl, $webhookUrl, $plan, $test, $coupon, $currency);
    }
}