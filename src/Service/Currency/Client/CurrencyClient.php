<?php

namespace AppPaymentClient\Service\Currency\Client;

use AppPaymentClient\Service\AbstractClient;
use AppPaymentClient\Service\Currency\DTO\FromEuroResponseDTO;
use AppPaymentClient\Service\Currency\DTO\ToEuroResponseDTO;
use AppPaymentClient\Service\Currency\Exception\CurrencyException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CurrencyClient extends AbstractClient
{
    private const CURRENCY_URL = '/api/currency';

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $currency
     * @param float|null $amount
     * @return FromEuroResponseDTO
     * @throws CurrencyException
     */
    public function fromEuro(string $currency, ?float $amount = null): FromEuroResponseDTO
    {
        $url = $this->getAppPaymentsUrl() . self::CURRENCY_URL . '/from-euro';
        $query = ['currency' => $currency];
        if (!is_null($amount)) {
            $query['amount'] = $amount;
        }
        try {
            $response = $this->httpClient->request('GET', $url, ['query' => $query]);
            $data = json_decode($response->getContent(), true);
            if (isset($data['error'])) {
                throw new CurrencyException($data['message'] ?? 'Client error', $data['code'] ?? 500);
            }
            if (isset($data['currency'], $data['rate'], $data['amount'])) {
                return new FromEuroResponseDTO($data['currency'], $data['rate'], $data['amount']);
            }
            throw new CurrencyException('Invalid response from client', 500);
        } catch (\Throwable $t) {
            throw CurrencyException::fromThrowable($t);
        }
    }

    /**
     * @throws CurrencyException
     */
    public function toEuro(string $currency, ?float $amount = null): ToEuroResponseDTO
    {
        $url = $this->getAppPaymentsUrl() . self::CURRENCY_URL . '/to-euro';
        $query = ['currency' => $currency];
        if (!is_null($amount)) {
            $query['amount'] = $amount;
        }
        try {
            $response = $this->httpClient->request('GET', $url, ['query' => $query]);
            $data = json_decode($response->getContent(), true);
            if (isset($data['error'])) {
                throw new CurrencyException($data['message'] ?? 'Client error', $data['code'] ?? 500);
            }
            if (isset($data['currency'], $data['rate'], $data['amount'])) {
                return new ToEuroResponseDTO($data['currency'], $data['rate'], $data['amount']);
            }
            throw new CurrencyException('Invalid response from client', 500);
        } catch (\Throwable $t) {
            throw CurrencyException::fromThrowable($t);
        }
    }
}