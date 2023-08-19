<?php

namespace AppPaymentClient\Service\Stripe\CustomerPortal;

use AppPaymentClient\Service\AbstractClient;
use AppPaymentClient\Service\ServiceNameProvider;
use AppPaymentClient\Service\Stripe\CustomerPortal\Exception\StripeCustomerPortalException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StripeCustomerPortalService extends AbstractClient implements StripeCustomerPortalServiceInterface
{
    private const BASE_URI = '/api/stripe/customer-portal';

    /**
     * @var HttpClientInterface
     */
    private $httpClient;
    /**
     * @var ServiceNameProvider
     */
    private $serviceNameProvider;

    public function __construct(HttpClientInterface $httpClient, ServiceNameProvider $serviceNameProvider)
    {
        $this->httpClient = $httpClient;
        $this->serviceNameProvider = $serviceNameProvider;
    }

    /**
     * @inheritDoc
     */
    public function getCachedUrlByEmail(string $email, bool $test = false): string
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->getAppPaymentsUrl() . self::BASE_URI . '/cached-url',
                [
                    'query' => [
                        'email' => $email,
                        'test' => $test,
                    ],
                ]
            );
            $data = json_decode($response->getContent(false), true);
        } catch (\Throwable $t) {
            throw StripeCustomerPortalException::fromThrowable($t);
        }
        if (isset($data['error']) && $data['error'] === true) {
            throw new StripeCustomerPortalException(
                $data['message'] ?? 'Stripe Customer Portal Error',
                $data['code'] ?? 'stripe.customer_portal.error'
            );
        }
        if (!isset($data['url'])) {
            throw new StripeCustomerPortalException(
                'Invalid Response from stripe',
                'stripe.customer_portal.invalid_response'
            );
        }
        return $data['url'];
    }

    /**
     * @inheritDoc
     */
    public function getCachedUrlByCustomerId(string $customerId, bool $test = false): string
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->getAppPaymentsUrl() . self::BASE_URI . '/cached-url',
                [
                    'query' => [
                        'id' => $customerId,
                        'test' => $test,
                    ],
                ]
            );
            $data = json_decode($response->getContent(false), true);
        } catch (\Throwable $t) {
            throw StripeCustomerPortalException::fromThrowable($t);
        }
        if (isset($data['error']) && $data['error'] === true) {
            throw new StripeCustomerPortalException(
                $data['message'] ?? 'Stripe Customer Portal Error',
                $data['code'] ?? 'stripe.customer_portal.error'
            );
        }
        if (!isset($data['url'])) {
            throw new StripeCustomerPortalException(
                'Invalid response from stripe',
                'stripe.customer_portal.invalid_response'
            );
        }
        return $data['url'];
    }

    /**
     * @inheritDoc
     */
    public function getUrlByCustomerId(string $customerId, string $returnUrl, bool $test = false): string
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->getAppPaymentsUrl() . self::BASE_URI . "/customer/$customerId/url",
                ['query' => [
                    'return_url' => $returnUrl,
                    'test' => (int) $test,
                    'service_name' => $this->serviceNameProvider->getServiceName(),
                ]]
            );
            $data = json_decode($response->getContent(false), true);
        } catch (\Throwable $t) {
            throw StripeCustomerPortalException::fromThrowable($t);
        }
        if (isset($data['error']) && $data['error']) {
            throw new StripeCustomerPortalException($data['message'] ?? 'Stripe Customer Portal Error');
        }
        if (!isset($data['url'])) {
            throw new StripeCustomerPortalException('Invalid response from stripe');
        }
        return $data['url'];
    }
}
