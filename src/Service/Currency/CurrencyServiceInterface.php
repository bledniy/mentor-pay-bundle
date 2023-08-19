<?php

namespace AppPaymentClient\Service\Currency;

use AppPaymentClient\Service\Currency\DTO\FromEuroResponseDTO;
use AppPaymentClient\Service\Currency\DTO\ToEuroResponseDTO;
use AppPaymentClient\Service\Currency\Exception\CurrencyException;

interface CurrencyServiceInterface
{
    /**
     * @param string $currency
     * @param float $amount
     * @return FromEuroResponseDTO
     * @throws CurrencyException
     */
    public function fromEuro(string $currency, float $amount = 1): FromEuroResponseDTO;

    /**
     * @param string $currency
     * @param float $amount
     * @return ToEuroResponseDTO
     * @throws CurrencyException
     */
    public function toEuro(string $currency, float $amount = 1): ToEuroResponseDTO;
}