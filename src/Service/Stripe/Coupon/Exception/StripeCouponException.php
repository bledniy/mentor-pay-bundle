<?php

namespace AppPaymentClient\Service\Stripe\Coupon\Exception;

use AppPaymentClient\Core\Error\Error;

class StripeCouponException extends \Exception
{
    /**
     * @var Error[]|null
     */
    private $errors;

    public function __construct($message = "", $code = 0, \Throwable $previous = null, ?array $errors = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * @param string $message
     * @param int|null $code
     * @param Error[]|null $errors
     * @return static
     */
    public static function make(string $message, ?int $code = null, ?array $errors = null): self
    {
        return new self($message, $code, null, $errors);
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