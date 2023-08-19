<?php

namespace AppPaymentClient\Service\Currency;

use AppPaymentClient\Service\AbstractClient;
use AppPaymentClient\Service\Currency\DTO\Request\ConvertCurrencyRequestDTO;
use AppPaymentClient\Service\Currency\Exception\CurrencyConvertorException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CurrencyConvertor extends AbstractClient implements CurrencyConverterInterface
{
    private const BASE_URL = '/api/currency';

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @inheritDoc
     */
    public function convert(ConvertCurrencyRequestDTO $requestDTO): float
    {
        $url = $this->getAppPaymentsUrl() . self::BASE_URL . '/convert';
        try {
            $response = $this->httpClient->request('GET', $url, [
                'query' => [
                    'from' => $requestDTO->getFrom(),
                    'to' => $requestDTO->getTo(),
                    'amount' => $requestDTO->getAmount(),
                ],
            ]);
            $data = json_decode($response->getContent(), true);
        } catch (\Throwable $t) {
            throw CurrencyConvertorException::fromThrowable($t);
        }
        if (!isset($data['result'])) {
            if (isset($data['error'], $data['message'])) {
                throw new CurrencyConvertorException('Currency Convertor Error: ' . $data['message']);
            }
            throw new CurrencyConvertorException('Invalid Response Received from AppPayment Convertor');
        }
        return $data['result'];
    }
}