<?php

namespace AppPaymentClient\Service\Stripe\Subscription;

interface SubscriptionStatus
{
    public const ACTIVE = 'ACTIVE';
    public const CANCELED = 'CANCELED';
    public const FAILED = 'FAILED';
    public const EXPIRED = 'EXPIRED';
    public const PAUSED = 'PAUSED';
}
