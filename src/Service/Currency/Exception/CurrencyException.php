<?php

namespace AppPaymentClient\Service\Currency\Exception;

class CurrencyException extends \Exception
{
    /**
     * @param \Throwable $t
     * @return static
     */
    public static function fromThrowable(\Throwable $t): self
    {
        return new self($t->getMessage(), $t->getCode(), $t);
    }
}