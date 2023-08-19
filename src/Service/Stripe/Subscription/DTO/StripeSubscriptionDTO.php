<?php

namespace AppPaymentClient\Service\Stripe\Subscription\DTO;

class StripeSubscriptionDTO
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $status;

    public function __construct(string $id, string $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
