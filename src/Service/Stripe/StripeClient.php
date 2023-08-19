<?php

namespace AppPaymentClient\Service\Stripe;

use AppPaymentClient\Service\AbstractClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StripeClient extends AbstractClient
{
    private const API_STRIPE_URL = '/api/stripe';
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param StripeRequestDTO $stripeRequestDTO
     * @return string|null
     */
    public function getCheckoutUrl(StripeRequestDTO $stripeRequestDTO): ?string
    {
        $body = [
            'plan_type' => $stripeRequestDTO->getPlan(),
            'test' => (int)$stripeRequestDTO->getTest(),
            'service_name' => $stripeRequestDTO->getServiceName(),
            'order_id' => $stripeRequestDTO->getOrderId(),
            'success_url' => $stripeRequestDTO->getSuccessUrl(),
            'cancel_url' => $stripeRequestDTO->getCancelUrl(),
            'webhook_url' => $stripeRequestDTO->getWebhookUrl(),
        ];
        if (!is_null($stripeRequestDTO->getCoupon())) {
            $body['coupon'] = $stripeRequestDTO->getCoupon();
        }
        if (!is_null($stripeRequestDTO->getCurrency())) {
            $body['currency'] = $stripeRequestDTO->getCurrency();
        }
        if (!is_null($stripeRequestDTO->getDelayDate())) {
            /** @noinspection NullPointerExceptionInspection */
            $body['payment_date'] = $stripeRequestDTO->getDelayDate()->format('Y-m-d');
        }
        if (!is_null($stripeRequestDTO->getAmountDiscount())) {
            $body['amount_discount'] = $stripeRequestDTO->getAmountDiscount();
        }
        if (!is_null($stripeRequestDTO->getCustomerId())) {
            $body['customer_id'] = $stripeRequestDTO->getCustomerId();
        }
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->getAppPaymentsUrl() . self::API_STRIPE_URL . '/subscription-middleware',
                ['body' => $body]
            );
            $response = json_decode($response->getContent(), true);
        } catch (TransportExceptionInterface | ClientExceptionInterface
            | RedirectionExceptionInterface | ServerExceptionInterface $e) {
            return null;
        }
        if (!$response || isset($response['error']) || !isset($response['ok'])) {
            return null;
        }
        return $response['url'];
    }

    /**
     * @param StripeCheckoutRequestDTO $stripeCheckoutRequest
     * @return string|null
     */
    public function getPaymentUrl(StripeCheckoutRequestDTO $stripeCheckoutRequest): ?string
    {
        $body = [
            'amount' => $stripeCheckoutRequest->getAmount(),
            'service_name' => $stripeCheckoutRequest->getServiceName(),
            'success_url' => $stripeCheckoutRequest->getSuccessUrl(),
            'cancel_url' => $stripeCheckoutRequest->getCancelUrl(),
            'webhook_url' => $stripeCheckoutRequest->getWebhookUrl(),
            'order_id' => $stripeCheckoutRequest->getOrderId(),
            'test' => (int) $stripeCheckoutRequest->getTest(),
            'currency' => $stripeCheckoutRequest->getCurrency(),
        ];
        if ($title = $stripeCheckoutRequest->getTitle()) {
            $body['title'] = $title;
        }
        if ($description = $stripeCheckoutRequest->getDescription()) {
            $body['description'] = $description;
        }
        if ($transferData = $stripeCheckoutRequest->getTransferData()) {
            $body['transfer_data'] = $transferData;
        }
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->getAppPaymentsUrl() . self::API_STRIPE_URL . '/checkout-middleware',
                [
                    'body' => $body,
                ]
            );
            $response = json_decode($response->getContent(), true);
            return $response['url'] ?? null;
        } catch (ClientExceptionInterface | RedirectionExceptionInterface
            | ServerExceptionInterface | TransportExceptionInterface $e) {
            return null;
        }
    }

    /**
     * @param StripeCancelSubscriptionRequestDTO $stripeCancelSubscriptionRequestDTO
     * @return array
     */
    public function cancelSubscription(StripeCancelSubscriptionRequestDTO $stripeCancelSubscriptionRequestDTO): array
    {
        $body = [
            'service_name' => $stripeCancelSubscriptionRequestDTO->getServiceName(),
            'order_id' => $stripeCancelSubscriptionRequestDTO->getOrderId(),
            'disable_logs' => $stripeCancelSubscriptionRequestDTO->isDisableLogs(),
        ];
        if ($stripeCancelSubscriptionRequestDTO->getPlanId()) {
            $body['plan_id'] = $stripeCancelSubscriptionRequestDTO->getPlanId();
        }
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->getAppPaymentsUrl() . self::API_STRIPE_URL . '/cancel-subscription',
                [
                    'body' => $body,
                ]
            );
            $response = json_decode($response->getContent(), true);
            return $response ?? [];
        } catch (ClientExceptionInterface | RedirectionExceptionInterface
            | ServerExceptionInterface | TransportExceptionInterface $e) {
            return ['error' => 'AppPaymentClient error ' . $e->getMessage()];
        }
    }

    /**
     * @param StripeCustomerPortalRequestDTO $customerPortalRequestDTO
     * @return string|null
     */
    public function customerPortal(StripeCustomerPortalRequestDTO $customerPortalRequestDTO): ?string
    {
        $body = [
            'order_id' => $customerPortalRequestDTO->getOrderId(),
            'service_name' => $customerPortalRequestDTO->getServiceName(),
            'test' => (int)$customerPortalRequestDTO->isTest(),
            'return_url' => $customerPortalRequestDTO->getReturnUrl()
        ];
        if ($customerPortalRequestDTO->getPlanId()) {
            $body['plan_id'] = $customerPortalRequestDTO->getPlanId();
        }
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->getAppPaymentsUrl() . self::API_STRIPE_URL . '/customer-portal-middleware',
                [
                    'body' => $body,
                ]
            );
            $response = json_decode($response->getContent(), true);
            return $response['url'] ?? null;
        } catch (TransportExceptionInterface|ClientExceptionInterface
            |ServerExceptionInterface|RedirectionExceptionInterface $e) {
            return null;
        }
    }
}
