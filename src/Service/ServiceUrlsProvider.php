<?php

namespace AppPaymentClient\Service;

class ServiceUrlsProvider
{
    /**
     * @var string
     */
    private $webhookUrl;

    /**
     * @var string
     */
    private $checkoutWebhookUrl;
//
//    /**
//     * @var string
//     */
//    private $orderUrl;

    public function __construct(
        string $webhookUrl,
        string $checkoutWebhookUrl
//        string $orderUrl
    )
    {
        $this->webhookUrl = $webhookUrl;
        $this->checkoutWebhookUrl = $checkoutWebhookUrl;
//        $this->orderUrl = $orderUrl;
    }

    /**
     * @return string
     */
    public function getWebhookUrl(): string
    {
        return $this->webhookUrl;
    }

    /**
     * @return string
     */
    public function getCheckoutWebhookUrl(): string
    {
        return $this->checkoutWebhookUrl;
    }

//    /**
//     * @return string
//     */
//    public function getOrderUrl(): string
//    {
//        return $this->orderUrl;
//    }
}