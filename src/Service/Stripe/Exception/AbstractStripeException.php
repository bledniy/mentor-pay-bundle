<?php

namespace AppPaymentClient\Service\Stripe\Exception;

use AppPaymentClient\Core\Error\Error;

abstract class AbstractStripeException extends \Exception
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
     * @return array|Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * @param string $message
     * @param int|null $code
     * @param array|null $errors
     * @return $this
     */
    public static function make(string $message, ?int $code = null, ?array $errors = null): self
    {
        return new static($message, $code, null, $errors);
    }

    /**
     * @param \Throwable $t
     * @return $this
     */
    public static function fromThrowable(\Throwable $t): self
    {
        return new static($t->getMessage(), $t->getCode(), $t);
    }
}
