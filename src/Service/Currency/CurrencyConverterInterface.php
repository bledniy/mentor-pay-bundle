<?php

namespace AppPaymentClient\Service\Currency;

use AppPaymentClient\Service\Currency\DTO\Request\ConvertCurrencyRequestDTO;
use AppPaymentClient\Service\Currency\Exception\CurrencyConvertorException;

interface CurrencyConverterInterface
{
    /**
     * @param ConvertCurrencyRequestDTO $requestDTO
     * @return float
     * @throws CurrencyConvertorException
     */
    public function convert(ConvertCurrencyRequestDTO $requestDTO): float;
}