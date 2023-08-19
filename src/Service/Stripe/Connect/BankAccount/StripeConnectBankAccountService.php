<?php

namespace AppPaymentClient\Service\Stripe\Connect\BankAccount;

use AppPaymentClient\Service\AbstractClient;
use AppPaymentClient\Service\ServiceNameProvider;
use AppPaymentClient\Service\Stripe\Connect\BankAccount\DTO\CountryDTO;
use AppPaymentClient\Service\Stripe\Connect\BankAccount\DTO\CurrencyDTO;
use AppPaymentClient\Service\Stripe\Connect\BankAccount\DTO\Request\CreateStripeConnectBankAccountRequestDTO;
use AppPaymentClient\Service\Stripe\Connect\BankAccount\DTO\Request\UpdateStripeConnectBankAccountRequestDTO;
use AppPaymentClient\Service\Stripe\Connect\BankAccount\DTO\StripeConnectBankAccountDTO;
use AppPaymentClient\Service\Stripe\Connect\BankAccount\Exception\StripeConnectBankAccountException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StripeConnectBankAccountService extends AbstractClient implements StripeConnectBankAccountServiceInterface
{
    private const BASE_URL = '/api/stripe/connect/bank-account';

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
        $this->httpClient = $httpClient;
        $this->serviceNameProvider = $serviceNameProvider;
    }

    /**
     * @inheritDoc
     */
    public function getCurrencies(): array
    {
        try {
            $response = $this->httpClient->request('GET', $this->getAppPaymentsUrl() . self::BASE_URL . '/currencies');
            $data = json_decode($response->getContent(false), true);
        } catch (\Throwable $t) {
            throw StripeConnectBankAccountException::fromThrowable($t);
        }
        if (!isset($data['currencies'])) {
            throw StripeConnectBankAccountException::make('Invalid response received from stripe');
        }
        $result = [];
        foreach ($data['currencies'] as $currency) {
            $result[] = new CurrencyDTO($currency);
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getCountries(): array
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->getAppPaymentsUrl() . self::BASE_URL . '/countries'
            );
            $data = json_decode($response->getContent(false), true);
        } catch (\Throwable $t) {
            throw StripeConnectBankAccountException::fromThrowable($t);
        }
        if (!isset($data['countries'])) {
            throw StripeConnectBankAccountException::make('Invalid response received from stripe');
        }
        $result = [];
        foreach ($data['countries'] as $code => $name) {
            $result[] = new CountryDTO($name, $code);
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function createBankAccount(CreateStripeConnectBankAccountRequestDTO $requestDTO): StripeConnectBankAccountDTO
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->getAppPaymentsUrl() . self::BASE_URL . '/create',
                ['body' => [
                    'account_id' => $requestDTO->getAccountId(),
                    'type' => $requestDTO->getType(),
                    'country' => $requestDTO->getCountry(),
                    'currency' => $requestDTO->getCurrency(),
                    'holder_name' => $requestDTO->getHolderName(),
                    'account_number' => $requestDTO->getAccountNumber(),
                    'test' => $requestDTO->isTest(),
                    'service_name' => $this->serviceNameProvider->getServiceName(),
                ]]
            );
            $data = json_decode($response->getContent(false), true);
        } catch (\Throwable $t) {
            throw StripeConnectBankAccountException::fromThrowable($t);
        }
        if (isset($data['error']) && $data['error'] === true) {
            throw StripeConnectBankAccountException::make($data['message'] ?? 'Stripe error');
        }
        if (!isset($data['bank_account']['id'], $data['bank_account']['type'], $data['bank_account']['country'], $data['bank_account']['currency'])) {
            throw StripeConnectBankAccountException::make('Invalid response received from stripe');
        }
        return new StripeConnectBankAccountDTO(
            $data['bank_account']['id'],
            $data['bank_account']['type'],
            $data['bank_account']['holder_name'] ?? null,
            $data['bank_account']['holder_type'] ?? null,
            $data['bank_account']['bank_name'] ?? null,
            $data['bank_account']['country'],
            $data['bank_account']['currency']
        );
    }

    /**
     * @inheritDoc
     */
    public function getBankAccount(string $accountId, string $bankAccountId, bool $test = false): ?StripeConnectBankAccountDTO
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->getAppPaymentsUrl() . self::BASE_URL . '/' . $bankAccountId . '/account/' . $accountId,
                ['query' => [
                    'test' => (int) $test,
                    'service_name' => $this->serviceNameProvider->getServiceName(),
                ]]
            );
            $data = json_decode($response->getContent(false), true);
        } catch (\Throwable $t) {
            throw StripeConnectBankAccountException::fromThrowable($t);
        }
        if (isset($data['error']) && $data['error'] === true) {
            throw StripeConnectBankAccountException::make($data['message'] ?? 'Stripe error');
        }
        if (!isset($data['bank_account'])) {
            return null;
        }
        if (!isset($data['bank_account']['id'], $data['bank_account']['type'], $data['bank_account']['country'], $data['bank_account']['currency'])) {
            throw StripeConnectBankAccountException::make('Invalid response received from stripe');
        }
        return new StripeConnectBankAccountDTO(
            $data['bank_account']['id'],
            $data['bank_account']['type'],
            $data['bank_account']['holder_name'] ?? null,
            $data['bank_account']['holder_type'] ?? null,
            $data['bank_account']['bank_name'] ?? null,
            $data['bank_account']['country'],
            $data['bank_account']['currency']
        );
    }

    /**
     * @inheritDoc
     */
    public function updateBankAccount(UpdateStripeConnectBankAccountRequestDTO $requestDTO): StripeConnectBankAccountDTO
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->getAppPaymentsUrl() . '/' . $requestDTO->getBankAccountId() . '/account/' . $requestDTO->getAccountId(),
                ['body' => [
                    'holder_name' => $requestDTO->getHolderName(),
                    'test' => $requestDTO->isTest(),
                    'service_name' => $this->serviceNameProvider->getServiceName(),
                ]]
            );
            $data = json_decode($response->getContent(false), true);
        } catch (\Throwable $t) {
            throw StripeConnectBankAccountException::fromThrowable($t);
        }
        if (isset($data['error']) && $data['error'] === true) {
            throw StripeConnectBankAccountException::make($data['message'] ?? 'Stripe Error');
        }
        if (!isset($data['bank_account']['id'], $data['bank_account']['type'], $data['bank_account']['country'], $data['bank_account']['currency'])) {
            throw StripeConnectBankAccountException::make('Invalid response received from stripe');
        }
        return new StripeConnectBankAccountDTO(
            $data['bank_account']['id'],
            $data['bank_account']['type'],
            $data['bank_account']['holder_name'] ?? null,
            $data['bank_account']['holder_type'] ?? null,
            $data['bank_account']['bank_name'] ?? null,
            $data['bank_account']['country'],
            $data['bank_account']['currency']
        );
    }

    /**
     * @inheritDoc
     */
    public function deleteBankAccount(string $accountId, string $bankAccountId, bool $test = false): void
    {
        try {
            $response = $this->httpClient->request(
                'DELETE',
                $this->getAppPaymentsUrl() . self::BASE_URL . '/' . $bankAccountId . '/account/' . $accountId,
                ['query' => ['service_name' => $this->serviceNameProvider->getServiceName(), 'test' => (int) $test]]
            );
            $data = json_decode($response->getContent(false), true);
        } catch (\Throwable $t) {
            throw StripeConnectBankAccountException::fromThrowable($t);
        }
        if (isset($data['error']) && $data['error'] === true) {
            throw StripeConnectBankAccountException::make($data['message'] ?? 'Stripe error');
        }
    }
}
