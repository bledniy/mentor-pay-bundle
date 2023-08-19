<?php

namespace AppPaymentClient\Service\OrderCheck;

use AppPaymentClient\Service\Currency\DTO\FromEuroResponseDTO;
use AppPaymentClient\Service\Currency\DTO\ToEuroResponseDTO;
use AppPaymentClient\Service\OrderCheck\Exception\OrderCheckException;

interface OrderCheckServiceInterface
{
    /**
     * @param int $orderId
     * @param int $planId
     * @param string $serviceName
     * @return bool
     * @throws OrderCheckException
     */
    public function checkIsOrderExist(int $orderId, int $planId, string $serviceName): bool;

    /**
     * @param int $orderId
     * @param int $planId
     * @return bool
     * @throws OrderCheckException
     */
    public function checkIsMeQrOrderActive(int $orderId, int $planId): bool;

    /**
     * @param int $orderId
     * @param string $serviceName
     * @return bool
     * @throws OrderCheckException
     */
    public function checkIsOrderExistNoPlanId(int $orderId, string $serviceName): bool;

}
