<?php

namespace AppPaymentClient\Entity;

interface StripePlanInterface
{
    public const YEARLY_PLAN = 1;
    public const MONTHLY_PLAN = 2;
    public const ME_PAGE_YEARLY_PLAN = 3;
    public const ME_PAGE_MONTHLY_PLAN = 4;
    public const ME_MENU_MONTHLY_PLAN = 5;
    public const ME_QR_LITE_PLAN = 6;
    public const ME_QR_MONTHLY_PLAN = 7;
    public const ME_QR_YEARLY_PLAN = 8;
    public const ME_MENU_PDF_PREMIUM = 9;
    public const ME_QR_LITE_YEARLY_PLAN = 13;
    public const ME_POS_LITE_MONTHLY_PLAN = 14;
    public const ME_POS_LITE_YEARLY_PLAN = 15;
    public const ME_POS_PREMIUM_MONTHLY_PLAN = 16;
    public const ME_POS_PREMIUM_YEARLY_PLAN = 17;
    public const ME_POS_WAREHOUSE_MONTHLY_PLAN = 18;
    public const ME_POS_WAREHOUSE_YEARLY_PLAN = 19;
    public const ME_WEB_SITE_PREMIUM_MONTHLY_PLAN = 20;
    public const ME_WEB_SITE_PREMIUM_YEARLY_PLAN = 21;
}
