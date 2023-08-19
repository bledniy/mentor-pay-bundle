<?php

namespace AppPaymentClient\Core\Error;

class Error
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var string|null
     */
    private $code;

    public function __construct(string $message, ?string $code = null)
    {
        $this->message = $message;
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }
}