<?php

namespace AppPaymentClient\Service\Stripe\Price;

use AppPaymentClient\Service\AbstractClient;
use AppPaymentClient\Service\ServiceNameProvider;
use AppPaymentClient\Service\Stripe\Price\DTO\CurrencyAmountDTO;
use AppPaymentClient\Service\Stripe\Price\Exception\StripePriceException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StripePriceService extends AbstractClient implements StripePriceServiceInterface
{
    private const BASE_URI = '/api/stripe/price';

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
        $this->serviceNameProvider = $serviceNameProvider;
        $this->httpClient = $httpClient;
    }

    /**
     * @inheritDoc
     */
    public function getCurrencyAmount(int $plan, bool $test = false): array
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->getAppPaymentsUrl() . self::BASE_URI . '/currency-amount',
                ['query' => [
                    'plan' => $plan,
                    'test' => (int) $test,
                    'service_name' => $this->serviceNameProvider->getServiceName(),
                ]]
            );
            $data = json_decode($response->getContent(), true);
        } catch (\Throwable $t) {
            throw StripePriceException::fromThrowable($t);
        }
        if (isset($data['error']) && $data['error']) {
            throw StripePriceException::make($data['message'] ?? 'Stripe error');
        }
        if (!isset($data['currency_amount'])) {
            throw StripePriceException::make('Invalid response from received from stripe');
        }
        $result = [];
        foreach ($data['currency_amount'] as $datum) {
            if (!isset($datum['currency'], $datum['amount'])) {
                continue;
            }
            $result[] = CurrencyAmountDTO::make($datum['currency'], $datum['amount']);
        }
        return $result;
    }
}
