<?php

namespace AppPaymentClient\Service\Stripe;

use AppPaymentClient\Service\OrderProvider;
use AppPaymentClient\Service\ServiceNameProvider;
use AppPaymentClient\Service\ServiceUrlsProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeCheckoutRequestDTOBuilder
{
    /**
     * @var ServiceUrlsProvider
     */
    private $serviceUrlsProvider;

    /**
     * @var ServiceNameProvider
     */
    private $serviceNameProvider;

    /**
     * @var OrderProvider
     */
    private $orderProvider;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(
        ServiceUrlsProvider $serviceUrlsProvider,
        ServiceNameProvider $serviceNameProvider,
        OrderProvider $orderProvider,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->serviceUrlsProvider = $serviceUrlsProvider;
        $this->serviceNameProvider = $serviceNameProvider;
        $this->orderProvider = $orderProvider;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param Request $request
     * @return StripeCheckoutRequestDTO|null
     */
    public function buildFromRequest(Request $request): ?StripeCheckoutRequestDTO
    {
        $amount = $request->request->get('amount');
        $successUrl = $request->request->get('success_url');
        $cancelUrl = $request->request->get('cancel_url');
        $test = $request->request->get('test', false);
        $orderId = $request->request->get('order_id');
        $currency = strtolower($request->request->get('currency', 'usd'));
        $webhookRoute = $this->serviceUrlsProvider->getCheckoutWebhookUrl();
        $webhookUrl = $this->urlGenerator->generate($webhookRoute, [], UrlGeneratorInterface::ABSOLUTE_URL);
        $serviceName = $this->serviceNameProvider->getServiceName();
//        $orderId = $this->orderProvider->getOrderId();
        if (!isset($amount, $successUrl, $cancelUrl, $test, $orderId, $webhookUrl, $serviceName)) {
            return null;
        }
        return new StripeCheckoutRequestDTO(
            $amount,
            $serviceName,
            $successUrl,
            $cancelUrl,
            $webhookUrl,
            $orderId,
            $test,
            $request->request->get('title'),
            $currency,
            $request->request->get('description'),
            $request->request->get('transfer_data')
        );
    }
}