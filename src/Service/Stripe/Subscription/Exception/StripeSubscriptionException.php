<?php

namespace AppPaymentClient\Service\Stripe\Subscription\Exception;

class StripeSubscriptionException extends \Exception
{
    /**
     * @param \Throwable $t
     * @return self
     */
    public static function fromThrowable(\Throwable $t): self
    {
        return new self($t->getMessage(), $t->getCode(), $t);
    }

    public static function invalidResponse(): self
    {
        return new self('Invalid response');
    }
}
