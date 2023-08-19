<?php

namespace AppPaymentClient\Service;

abstract class AbstractClient
{
    private const APP_PAYMENT_URL = 'https://payments.me-qr.com';

    /**
     * @return string
     */
    protected function getAppPaymentsUrl(): string
    {
        return self::APP_PAYMENT_URL;
    }
}