<?php

namespace AppPaymentClient\Service\Stripe;

use AppPaymentClient\Entity\StripePlanInterface;

class StripePlansProvider
{
    /**
     * @return array
     */
    public static function getStripePlans(): array
    {
        return [
            StripePlanInterface::YEARLY_PLAN,
            StripePlanInterface::MONTHLY_PLAN,
            StripePlanInterface::ME_PAGE_YEARLY_PLAN,
            StripePlanInterface::ME_PAGE_MONTHLY_PLAN,
            StripePlanInterface::ME_MENU_MONTHLY_PLAN,
            StripePlanInterface::ME_QR_LITE_PLAN,
            StripePlanInterface::ME_QR_MONTHLY_PLAN,
            StripePlanInterface::ME_QR_YEARLY_PLAN,
            StripePlanInterface::ME_QR_LITE_YEARLY_PLAN,
        ];
    }
}