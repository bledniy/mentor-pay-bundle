<?php

namespace AppPaymentClient\Service\Stripe\Connect\BankAccount;

use AppPaymentClient\Service\Stripe\Connect\BankAccount\DTO\CountryDTO;
use AppPaymentClient\Service\Stripe\Connect\BankAccount\DTO\CurrencyDTO;
use AppPaymentClient\Service\Stripe\Connect\BankAccount\DTO\Request\CreateStripeConnectBankAccountRequestDTO;
use AppPaymentClient\Service\Stripe\Connect\BankAccount\DTO\Request\UpdateStripeConnectBankAccountRequestDTO;
use AppPaymentClient\Service\Stripe\Connect\BankAccount\DTO\StripeConnectBankAccountDTO;
use AppPaymentClient\Service\Stripe\Connect\BankAccount\Exception\StripeConnectBankAccountException;

interface StripeConnectBankAccountServiceInterface
{
    /**
     * @return CurrencyDTO[]
     * @throws StripeConnectBankAccountException
     */
    public function getCurrencies(): array;

    /**
     * @return CountryDTO[]
     * @throws StripeConnectBankAccountException
     */
    public function getCountries(): array;

    /**
     * @param CreateStripeConnectBankAccountRequestDTO $requestDTO
     * @return StripeConnectBankAccountDTO
     * @throws StripeConnectBankAccountException
     */
    public function createBankAccount(CreateStripeConnectBankAccountRequestDTO $requestDTO): StripeConnectBankAccountDTO;

    /**
     * @param string $accountId
     * @param string $bankAccountId
     * @param bool $test
     * @return StripeConnectBankAccountDTO
     * @throws StripeConnectBankAccountException
     */
    public function getBankAccount(string $accountId, string $bankAccountId, bool $test = false): ?StripeConnectBankAccountDTO;

    /**
     * @param UpdateStripeConnectBankAccountRequestDTO $requestDTO
     * @return StripeConnectBankAccountDTO
     * @throws StripeConnectBankAccountException
     */
    public function updateBankAccount(UpdateStripeConnectBankAccountRequestDTO $requestDTO): StripeConnectBankAccountDTO;

    /**
     * @param string $accountId
     * @param string $bankAccountId
     * @param bool $test
     * @return void
     * @throws StripeConnectBankAccountException
     */
    public function deleteBankAccount(string $accountId, string $bankAccountId, bool $test = false): void;
}