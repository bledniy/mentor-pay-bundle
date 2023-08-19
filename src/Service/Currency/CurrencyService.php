<?php

namespace AppPaymentClient\Service\Currency;

use AppPaymentClient\Service\Currency\Client\CurrencyClient;
use AppPaymentClient\Service\Currency\DTO\FromEuroResponseDTO;
use AppPaymentClient\Service\Currency\DTO\ToEuroResponseDTO;
use AppPaymentClient\Service\Currency\Exception\CurrencyException;

class CurrencyService implements CurrencyServiceInterface
{
    /**
     * @var CurrencyClient
     */
    private $client;

    public function __construct(CurrencyClient $currencyClient)
    {
        $this->client = $currencyClient;
    }

    /**
     * @inheritDoc
     */
    public function fromEuro(string $currency, float $amount = 1): FromEuroResponseDTO
    {
        return $this->client->fromEuro($currency, $amount);
    }

    /**
     * @inheritDoc
     */
    public function toEuro(string $currency, float $amount = 1): ToEuroResponseDTO
    {
        return $this->client->toEuro($currency, $amount);
    }
}