<?php

namespace AppPaymentClient\Service\Stripe\Connect\Exception;

class StripeConnectException extends \Exception
{
    /**
     * @param \Throwable $t
     * @return static
     */
    public static function createFromThrowable(\Throwable $t): self
    {
        return new static($t->getMessage(), $t->getCode(), $t);
    }

    /**
     * @return static
     */
    public static function createInvalidResponse(): self
    {
        return new static('Invalid response from server', 500);
    }
}