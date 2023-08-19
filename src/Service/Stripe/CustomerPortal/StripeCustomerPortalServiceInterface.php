<?php

namespace AppPaymentClient\Service\Stripe\CustomerPortal;

use AppPaymentClient\Service\Stripe\CustomerPortal\Exception\StripeCustomerPortalException;

interface StripeCustomerPortalServiceInterface
{
    /**
     * @param string $email
     * @param bool $test
     * @return string
     * @throws StripeCustomerPortalException
     */
    public function getCachedUrlByEmail(string $email, bool $test = false): string;

    /**
     * @param string $customerId
     * @param bool $test
     * @return string
     * @throws StripeCustomerPortalException
     */
    public function getCachedUrlByCustomerId(string $customerId, bool $test = false): string;

    /**
     * @param string $customerId
     * @param string $returnUrl
     * @param bool $test
     * @return string
     * @throws StripeCustomerPortalException
     */
    public function getUrlByCustomerId(string $customerId, string $returnUrl, bool $test = false): string;
}
