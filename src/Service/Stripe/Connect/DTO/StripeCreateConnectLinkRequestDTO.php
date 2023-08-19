<?php

namespace AppPaymentClient\Service\Stripe\Connect\DTO;

use AppPaymentClient\Service\Stripe\Connect\StripeConnectAccountLinkTypeInterface;

class StripeCreateConnectLinkRequestDTO
{
    /**
     * @var string
     */
    private $account;
    /**
     * @var string
     */
    private $returnUrl;
    /**
     * @var string
     */
    private $refreshUrl;
    /**
     * @var bool
     */
    private $test;
    /**
     * @var string
     */
    private $type;

    public function __construct(string $account, string  $returnUrl, string $refreshUrl, bool $test, string $type = StripeConnectAccountLinkTypeInterface::ACCOUNT_ONBOARDING)
    {
        $this->account = $account;
        $this->returnUrl = $returnUrl;
        $this->refreshUrl = $refreshUrl;
        $this->test = $test;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getAccount(): string
    {
        return $this->account;
    }

    /**
     * @return string
     */
    public function getReturnUrl(): string
    {
        return $this->returnUrl;
    }

    /**
     * @return string
     */
    public function getRefreshUrl(): string
    {
        return $this->refreshUrl;
    }

    /**
     * @return bool
     */
    public function isTest(): bool
    {
        return $this->test;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}