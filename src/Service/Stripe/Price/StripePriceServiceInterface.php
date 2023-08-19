<?php

namespace AppPaymentClient\Service\Stripe\Price;

use AppPaymentClient\Service\Stripe\Price\DTO\CurrencyAmountDTO;
use AppPaymentClient\Service\Stripe\Price\Exception\StripePriceException;

interface StripePriceServiceInterface
{
    /**
     * @param int $plan
     * @param bool $test
     * @return CurrencyAmountDTO[]
     * @throws StripePriceException
     */
    public function getCurrencyAmount(int $plan, bool $test = false): array;
}