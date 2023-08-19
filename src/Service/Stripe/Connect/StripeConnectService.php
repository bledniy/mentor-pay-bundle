<?php

namespace AppPaymentClient\Service\Stripe\Connect;

use AppPaymentClient\Service\AbstractClient;
use AppPaymentClient\Service\ServiceNameProvider;
use AppPaymentClient\Service\Stripe\Connect\DTO\StripeConnectedAccountDetailsDTO;
use AppPaymentClient\Service\Stripe\Connect\DTO\StripeConnectedAccountDetailsRequestDTO;
use AppPaymentClient\Service\Stripe\Connect\DTO\StripeConnectedAccountDTO;
use AppPaymentClient\Service\Stripe\Connect\DTO\StripeCreateConnectedAccountRequestDTO;
use AppPaymentClient\Service\Stripe\Connect\DTO\StripeCreateConnectLinkRequestDTO;
use AppPaymentClient\Service\Stripe\Connect\Exception\StripeConnectException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StripeConnectService extends AbstractClient
{
    private const CONNECT_API_URL = '/api/stripe/connect';

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
     * @param StripeCreateConnectedAccountRequestDTO $requestDTO
     * @return StripeConnectedAccountDTO
     * @throws StripeConnectException
     */
    public function createConnectedAccount(StripeCreateConnectedAccountRequestDTO $requestDTO): StripeConnectedAccountDTO
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->getAppPaymentsUrl() . self::CONNECT_API_URL . '/create-account',
                [
                    'body' => [
                        'test' => (int)$requestDTO->isTest(),
                        'email' => $requestDTO->getEmail(),
                        'country' => $requestDTO->getCountry(),
                        'service_name' => $this->serviceNameProvider->getServiceName(),
                    ]
                ]
            );
            $data = json_decode($response->getContent(), true);
            if (isset($data['account']['account_id'], $data['account']['email'], $data['account']['country'])) {
                return new StripeConnectedAccountDTO(
                    $data['account']['account_id'],
                    $data['account']['email'],
                    $data['account']['country']
                );
            }
            throw StripeConnectException::createInvalidResponse();
        } catch (StripeConnectException $e) {
            throw $e;
        } catch (\Throwable $t) {
            throw StripeConnectException::createFromThrowable($t);
        }
    }

    /**
     * @param StripeCreateConnectLinkRequestDTO $requestDTO
     * @return string
     * @throws StripeConnectException
     */
    public function getConnectLink(StripeCreateConnectLinkRequestDTO $requestDTO): string
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->getAppPaymentsUrl() . self::CONNECT_API_URL . '/create-link',
                [
                    'body' => [
                        'test' => (int)$requestDTO->isTest(),
                        'account' => $requestDTO->getAccount(),
                        'return_url' => $requestDTO->getReturnUrl(),
                        'refresh_url' => $requestDTO->getRefreshUrl(),
                        'type' => $requestDTO->getType(),
                        'service_name' => $this->serviceNameProvider->getServiceName(),
                    ]
                ]
            );
            $data = json_decode($response->getContent(), true);
            if (isset($data['url'])) {
                return $data['url'];
            }
            throw StripeConnectException::createInvalidResponse();
        } catch (StripeConnectException $e) {
            throw $e;
        } catch (\Throwable $t) {
            throw StripeConnectException::createFromThrowable($t);
        }
    }

    /**
     * @param StripeConnectedAccountDetailsRequestDTO $requestDTO
     * @return StripeConnectedAccountDetailsDTO
     * @throws StripeConnectException
     */
    public function getConnectedAccountDetails(
        StripeConnectedAccountDetailsRequestDTO $requestDTO
    ): StripeConnectedAccountDetailsDTO
    {
        $url = $this->getAppPaymentsUrl() . self::CONNECT_API_URL . '/account/' .
            $requestDTO->getAccountId() . '/details';
        $query = ['service_name' => $this->serviceNameProvider->getServiceName()];
        if ($requestDTO->isTest()) {
            $query['test'] = true;
        }
        try {
            $response = $this->httpClient->request('GET', $url, ['query' => $query]);
            $data = json_decode($response->getContent(), true);
            if (isset($data['id'], $data['country'])) {
                return new StripeConnectedAccountDetailsDTO(
                    $data['id'],
                    $data['business_type'] ?? null,
                    $data['capabilities'] ?? [],
                    $data['country'],
                    $data['email'] ?? null,
                    $data['details_submitted'] ?? false
                );
            }
            throw StripeConnectException::createInvalidResponse();
        } catch (StripeConnectException $e) {
            throw $e;
        } catch (\Throwable $t) {
            throw StripeConnectException::createFromThrowable($t);
        }
    }
}
