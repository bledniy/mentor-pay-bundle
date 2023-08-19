<?php

namespace AppPaymentClient\Service\Stripe\Coupon;

use AppPaymentClient\Service\Stripe\Coupon\DTO\CouponDTO;
use AppPaymentClient\Service\Stripe\Coupon\DTO\Request\StripeCreateCouponDTO;
use AppPaymentClient\Service\Stripe\Coupon\DTO\Request\StripeUpdateCouponDTO;
use AppPaymentClient\Service\Stripe\Coupon\Exception\StripeCouponException;

interface StripeCouponServiceInterface
{
    /**
     * @param string $id
     * @param bool $test
     * @return CouponDTO|null
     * @throws StripeCouponException
     */
    public function getCoupon(string $id, bool $test = false): ?CouponDTO;

    /**
     * @param StripeCreateCouponDTO $requestDTO
     * @return CouponDTO
     * @throws StripeCouponException
     */
    public function createCoupon(StripeCreateCouponDTO $requestDTO): CouponDTO;

    /**
     * @param string $id
     * @param StripeUpdateCouponDTO $requestDTO
     * @return CouponDTO
     * @throws StripeCouponException
     */
    public function updateCoupon(string $id, StripeUpdateCouponDTO $requestDTO): CouponDTO;

    /**
     * @param string $id
     * @param bool $test
     * @return void
     * @throws StripeCouponException
     */
    public function deleteCoupon(string $id, bool $test = false): void;

    /**
     * @param bool $test
     * @return CouponDTO[]
     * @throws StripeCouponException
     */
    public function getList(bool $test = false): array;
}