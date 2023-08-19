<?php

namespace AppPaymentClient\Core\Exception;

class AppException extends \Exception
{
    /**
     * @var string
     */
    private $appCode;

    public function __construct(string $message = "", string $appCode = "", ?\Throwable $prev = null)
    {
        $this->appCode = $appCode;
        if (!is_null($prev)) {
            $code = $prev->getCode();
        }
        parent::__construct($message, $code ?? null, $prev);
    }

    /**
     * @return string
     */
    public function getAppCode(): string
    {
        return $this->appCode;
    }
}