<?php

namespace AppPaymentClient\Service\Stripe\Connect\BankAccount\Exception;

class StripeConnectBankAccountException extends \Exception
{
    /**
     * @param string $message
     * @param int|null $code
     * @return static
     */
    public static function make(string $message = '', ?int $code = null): self
    {
        return new self($message, $code);
    }

    /**
     * @param \Throwable $t
     * @return static
     */
    public static function fromThrowable(\Throwable $t): self
    {
        return new self($t->getMessage(), $t->getCode(), $t);
    }
}