<?php

namespace AppPaymentClient\Service\Stripe\Customer;

use AppPaymentClient\Service\Stripe\Customer\DTO\CustomerDTO;
use AppPaymentClient\Service\Stripe\Customer\Exception\CustomerException;

interface StripeCustomerServiceInterface
{
    /**
     * @param string $email
     * @param bool $test
     * @return CustomerDTO
     * @throws CustomerException
     */
    public function createCustomer(string $email, bool $test = false): CustomerDTO;

    /**
     * @param string $id
     * @param bool $test
     * @return CustomerDTO
     * @throws CustomerException
     */
    public function getCustomer(string $id, bool $test = false): CustomerDTO;
}
