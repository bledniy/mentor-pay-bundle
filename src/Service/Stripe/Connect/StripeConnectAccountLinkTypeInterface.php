<?php

namespace AppPaymentClient\Service\Stripe\Connect;

interface StripeConnectAccountLinkTypeInterface
{
    public const ACCOUNT_ONBOARDING = 'account_onboarding';
    public const ACCOUNT_UPDATE = 'account_update';
}