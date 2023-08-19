<?php

namespace AppPaymentClient\Service\Stripe\Subscription;

use AppPaymentClient\Service\Stripe\Subscription\DTO\StripeSubscriptionDTO;
use AppPaymentClient\Service\Stripe\Subscription\Exception\StripeSubscriptionException;

interface SubscriptionServiceInterface
{
    /**
     * @param string $subscriptionId
     * @param bool $test
     * @return StripeSubscriptionDTO|null
     * @throws StripeSubscriptionException
     */
    public function getSubscription(string $subscriptionId, bool $test = false): ?StripeSubscriptionDTO;

    /**
     * @param string $subscriptionId
     * @param bool $test
     * @return void
     * @throws StripeSubscriptionException
     */
    public function cancelSubscription(string $subscriptionId, bool $test = false): void;
}
