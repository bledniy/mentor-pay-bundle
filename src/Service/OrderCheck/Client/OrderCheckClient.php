<?php

namespace AppPaymentClient\Service\OrderCheck\Client;

use AppPaymentClient\Service\AbstractClient;
use AppPaymentClient\Service\OrderCheck\Exception\OrderCheckException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OrderCheckClient extends AbstractClient
{
    private const ORDER_URL = '/order';

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param int $orderId
     * @param int $planId
     * @param string $serviceName
     * @return bool
     * @throws OrderCheckException
     */
    public function checkIsOrderExist(int $orderId, int $planId, string $serviceName): bool
    {
        $url = $this->getAppPaymentsUrl() . self::ORDER_URL . '/check';
        $data = ['order_id' => $orderId, 'plan_id' => $planId, 'service_name' => $serviceName];

        try {
            return $this->sendRequest($url, $data);
        } catch (\Throwable $t) {
            throw OrderCheckException::fromThrowable($t);
        }
    }

    /**
     * @param int $orderId
     * @param string $serviceName
     * @return bool
     * @throws OrderCheckException
     */
    public function checkIsOrderExistNoPlanId(int $orderId, string $serviceName): bool
    {
        $url = $this->getAppPaymentsUrl() . self::ORDER_URL . '/check-no-plan';
        $data = ['order_id' => $orderId, 'service_name' => $serviceName];

        try {
            return $this->sendRequest($url, $data);
        } catch (\Throwable $t) {
            throw OrderCheckException::fromThrowable($t);
        }
    }

    /**
     * @param int $orderId
     * @param int $planId
     * @return bool
     * @throws OrderCheckException
     */
    public function checkIsMeQrOrderActive(int $orderId, int $planId): bool
    {
        $url = $this->getAppPaymentsUrl() . self::ORDER_URL . '/check-is-me-qr-order-active';
        $data = ['order_id' => $orderId, 'plan_id' => $planId];

        try {
            return $this->sendRequest($url, $data);
        } catch (\Throwable $t) {
            throw OrderCheckException::fromThrowable($t);
        }
    }

    /**
     * @param string $url
     * @param array $data
     * @return bool
     * @throws OrderCheckException
     */
    public function sendRequest(string $url, array $data): bool
    {
        $response = $this->httpClient->request('GET', $url, ['query' => $data]);
        $data = json_decode($response->getContent(), true);

        if (isset($data['error'])) {
            throw new OrderCheckException($data['message'] ?? 'Client error', $data['code'] ?? 500);
        }

        if (isset($data['exists'])){
            return $data['exists'] === true;
        }

        return $data['active'] === true;
    }
}
