<?php

namespace AppPaymentClient\Service\Stripe\Subscription;

use AppPaymentClient\Service\AbstractClient;
use AppPaymentClient\Service\ServiceNameProvider;
use AppPaymentClient\Service\Stripe\Subscription\DTO\StripeSubscriptionDTO;
use AppPaymentClient\Service\Stripe\Subscription\Exception\StripeSubscriptionException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SubscriptionService extends AbstractClient implements SubscriptionServiceInterface
{
    private const BASE_URI = '/api/stripe/subscription';

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
    public function getSubscription(string $subscriptionId, bool $test = false): ?StripeSubscriptionDTO
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->getAppPaymentsUrl() . self::BASE_URI . '/' . $subscriptionId,
                [
                    'query' => [
                        'test' => (int) $test,
                        'service_name' => $this->serviceNameProvider->getServiceName(),
                    ]
                ]
            );
            $data = json_decode($response->getContent(false), true);
        } catch (\Throwable $t) {
            throw StripeSubscriptionException::fromThrowable($t);
        }
        if (isset($data['error']) && $data['error']) {
            throw new StripeSubscriptionException($data['message'] ?? 'Stripe Client Error!');
        }
        if (!isset($data['subscription'])) {
            return null;
        }
        if (!isset($data['subscription']['id'], $data['subscription']['status'])) {
            throw StripeSubscriptionException::invalidResponse();
        }
        return new StripeSubscriptionDTO($data['subscription']['id'], $data['subscription']['status']);
    }

    /**
     * @inheritDoc
     */
    public function cancelSubscription(string $subscriptionId, bool $test = false): void
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->getAppPaymentsUrl() . self::BASE_URI . '/' . $subscriptionId . '/cancel',
                [
                    'body' => [
                        'test' => (int) $test,
                        'service_name' => $this->serviceNameProvider->getServiceName(),
                    ]
                ]
            );
            $data = json_decode($response->getContent(false), true);
        } catch (\Throwable $t) {
            throw StripeSubscriptionException::fromThrowable($t);
        }
        if (isset($data['error']) && $data['error']) {
            throw new StripeSubscriptionException($data['message'] ?? 'Stripe Client Error!');
        }
    }
}
