<?php

namespace AppPaymentClient\Service\Stripe\Customer\DTO;

class CustomerDTO
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string|null
     */
    private $email;

    public function __construct(string $id, ?string $email)
    {
        $this->id = $id;
        $this->email = $email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
