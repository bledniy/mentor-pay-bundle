<?php

namespace AppPaymentClient\Service\Stripe\Price\Exception;

class StripePriceException extends \Exception
{
    /**
     * @param \Throwable $t
     * @return static
     */
    public static function fromThrowable(\Throwable $t): self
    {
        return new self($t->getMessage(), $t->getCode(), $t);
    }

    /**
     * @param string $message
     * @param string|null $code
     * @return static
     */
    public static function make(string $message, string $code = null): self
    {
        return new self($message, $code);
    }
}