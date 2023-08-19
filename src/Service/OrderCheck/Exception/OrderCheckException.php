<?php

namespace AppPaymentClient\Service\OrderCheck\Exception;

class OrderCheckException extends \Exception
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
