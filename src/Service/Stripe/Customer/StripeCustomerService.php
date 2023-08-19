<?php

namespace AppPaymentClient\Service\Stripe\Customer;

use AppPaymentClient\Core\Error\Error;
use AppPaymentClient\Service\AbstractClient;
use AppPaymentClient\Service\ServiceNameProvider;
use AppPaymentClient\Service\Stripe\Customer\DTO\CustomerDTO;
use AppPaymentClient\Service\Stripe\Customer\Exception\CustomerException;
use AppPaymentClient\Service\Stripe\Exception\AbstractStripeException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StripeCustomerService extends AbstractClient implements StripeCustomerServiceInterface
{
    private const BASE_URI = '/api/stripe/customer';

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
     * @throws CustomerException
     * @throws AbstractStripeException
     */
    private function checkData(?array $data): void
    {
        if (isset($data['error']) && $data['error'] === true) {
            if (isset($data['errors'])) {
                $errors = [];
                foreach ($data['errors'] as $error) {
                    if (isset($error['message'])) {
                        $errors[] = new Error($error['message'], $error['code'] ?? null);
                    }
                }
            }
            throw CustomerException::make(
                $data['message'] ?? 'Stripe Error!',
                $data['code'] ?? null,
                $errors ?? null
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function createCustomer(string $email, bool $test = false): CustomerDTO
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->getAppPaymentsUrl() . self::BASE_URI . '/',
                ['body' => [
                    'email' => $email,
                    'test' => (int) $test,
                    'service_name' => $this->serviceNameProvider->getServiceName(),
                ]]
            );
            $data = json_decode($response->getContent(false), true);
        } catch (\Throwable $t) {
            throw CustomerException::fromThrowable($t);
        }
        $this->checkData($data);
        if (!isset($data['customer']['id'])) {
            throw CustomerException::make('Invalid response from stripe');
        }
        return new CustomerDTO($data['customer']['id'], $data['customer']['email'] ?? null);
    }

    /**
     * @inheritDoc
     */
    public function getCustomer(string $id, bool $test = false): CustomerDTO
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->getAppPaymentsUrl() . self::BASE_URI . '/' . $id,
                ['query' => [
                    'service_name' => $this->serviceNameProvider->getServiceName(),
                    'test' => (int) $test,
                ]]
            );
            $data = json_decode($response->getContent(false), true);
        } catch (\Throwable $t) {
            throw CustomerException::fromThrowable($t);
        }
        $this->checkData($data);
        if (!isset($data['customer']['id'])) {
            throw CustomerException::make('Invalid response from stripe');
        }
        return new CustomerDTO($data['customer']['id'], $data['customer']['email'] ?? null);
    }
}
