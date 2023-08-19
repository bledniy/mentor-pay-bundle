<?php

namespace AppPaymentClient\Service\Stripe\CustomerPortal\Exception;

use AppPaymentClient\Core\Exception\AppException;

class StripeCustomerPortalException extends AppException
{
    /**
     * @param \Throwable $t
     * @return self
     */
    public static function fromThrowable(\Throwable $t): self
    {
        return new self($t->getMessage(), "stipe.customer_portal.error", $t);
    }
}