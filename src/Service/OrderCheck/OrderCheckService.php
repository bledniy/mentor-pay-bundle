<?php

namespace AppPaymentClient\Service\OrderCheck;

use AppPaymentClient\Service\OrderCheck\Client\OrderCheckClient;

class OrderCheckService
{
    /**
     * @var OrderCheckClient
     */
    private $client;

    public function __construct(OrderCheckClient $orderCheckClient)
    {
        $this->client = $orderCheckClient;
    }

    public function checkIsMeQrOrderActive(int $orderId, int $planId): bool
    {
        return $this->client->checkIsMeQrOrderActive($orderId, $planId);
    }

    public function checkIsOrderExist(int $orderId, int $planId, string $serviceName): bool
    {
        return $this->client->checkIsOrderExist($orderId, $planId, $serviceName);
    }

    public function checkIsOrderExistNoPlanId(int $orderId, string $serviceName): bool
    {
        return $this->client->checkIsOrderExistNoPlanId($orderId, $serviceName);
    }
}
