<?php

namespace AppPaymentClient\Service;

use Symfony\Component\HttpFoundation\Request;

class WebhookResponse
{
    /**
     * @var string
     */
    private $orderId;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $plan;

    public function __construct(string $orderId, int $status, string $plan)
    {
        $this->orderId = $orderId;
        $this->status = $status;
        $this->plan = $plan;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getPlan(): int
    {
        return $this->plan;
    }

    /**
     * @param Request $request
     * @return static|null
     */
    public static function build(Request $request): ?self
    {
        $data = json_decode($request->getContent(), true);
        if (!$data || !isset($data['order_id'], $data['status'], $data['plan'])) {
            return null;
        }
        return new self($data['order_id'], $data['status'], $data['plan']);
    }
}