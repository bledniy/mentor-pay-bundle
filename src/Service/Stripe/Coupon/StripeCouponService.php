<?php

namespace AppPaymentClient\Service\Stripe\Coupon;

use AppPaymentClient\Core\Error\Error;
use AppPaymentClient\Service\AbstractClient;
use AppPaymentClient\Service\Stripe\Coupon\DTO\CouponDTO;
use AppPaymentClient\Service\Stripe\Coupon\DTO\Request\StripeCreateCouponDTO;
use AppPaymentClient\Service\Stripe\Coupon\DTO\Request\StripeUpdateCouponDTO;
use AppPaymentClient\Service\Stripe\Coupon\Exception\StripeCouponException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StripeCouponService extends AbstractClient implements StripeCouponServiceInterface
{
    private const BASE_URI = '/api/stripe/coupon';

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param array $data
     * @return void
     * @throws StripeCouponException
     */
    private function checkData(array $data): void
    {
        if (isset($data['error']) && $data['error'] === true) {
            if (isset($data['errors'])) {
                $errors = [];
                foreach ($data['errors'] as $error) {
                    if (isset($error['message'])) {
                        $errors[] = new Error($error['message'], $error['code'] ?? null);
                    }
                }
            }
            throw StripeCouponException::make(
                $data['message'] ?? 'Stripe Error!',
                $data['code'] ?? null,
                $errors ?? null
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function getCoupon(string $id, bool $test = false): ?CouponDTO
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->getAppPaymentsUrl() . self::BASE_URI . '/' . $id,
                ['query' => ['test' => (int) $test]]
            );
            $data = json_decode($response->getContent(), true);
        } catch (\Throwable $t) {
            throw StripeCouponException::fromThrowable($t);
        }
        $this->checkData($data);
        if (!isset($data['coupon'])) {
            return null;
        }
        if (!isset($data['coupon']['id'], $data['coupon']['name'], $data['coupon']['value'], $data['coupon']['times_redeemed'])) {
            throw StripeCouponException::make('Invalid response received from stripe');
        }
        return CouponDTO::make(
            $data['coupon']['id'],
            $data['coupon']['name'],
            $data['coupon']['value'],
            $data['coupon']['times_redeemed'],
            $data['coupon']['max_redemptions'] ?? null,
            $data['coupon']['test'] ?? false
        );
    }

    /**
     * @inheritDoc
     */
    public function createCoupon(StripeCreateCouponDTO $requestDTO): CouponDTO
    {
        $body = [
            'id' => $requestDTO->getId(),
            'name' => $requestDTO->getName(),
            'value' => $requestDTO->getValue(),
            'test' => (int) $requestDTO->getTest(),
        ];
        if (!is_null($requestDTO->getMaxRedemptions())) {
            $body['max_redemptions'] = $requestDTO->getMaxRedemptions();
        }
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->getAppPaymentsUrl() . self::BASE_URI . '/new',
                ['body' => $body]
            );
            $data = json_decode($response->getContent(), true);
        } catch (\Throwable $t) {
            throw StripeCouponException::fromThrowable($t);
        }
        $this->checkData($data);
        if (!isset($data['coupon']['id'], $data['coupon']['name'], $data['coupon']['value'], $data['coupon']['times_redeemed'])) {
            throw StripeCouponException::make('Invalid response received from stripe');
        }
        return CouponDTO::make(
            $data['coupon']['id'],
            $data['coupon']['name'],
            $data['coupon']['value'],
            $data['coupon']['times_redeemed'],
            $data['coupon']['max_redemptions'] ?? null,
            $data['coupon']['test'] ?? false
        );
    }

    /**
     * @inheritDoc
     */
    public function updateCoupon(string $id, StripeUpdateCouponDTO $requestDTO): CouponDTO
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->getAppPaymentsUrl() . self::BASE_URI . '/' . $id,
                ['body' => [
                    'name' => $requestDTO->getName(),
                    'test' => (int) $requestDTO->getTest(),
                ]]
            );
            $data = json_decode($response->getContent(), true);
        } catch (\Throwable $t) {
            throw StripeCouponException::fromThrowable($t);
        }
        $this->checkData($data);
        if (!isset($data['coupon']['id'], $data['coupon']['name'], $data['coupon']['value'], $data['coupon']['times_redeemed'])) {
            throw StripeCouponException::make('Invalid response received from stripe');
        }
        return CouponDTO::make(
            $data['coupon']['id'],
            $data['coupon']['name'],
            $data['coupon']['value'],
            $data['coupon']['times_redeemed'],
            $data['coupon']['max_redemptions'] ?? null,
            $data['coupon']['test'] ?? false
        );
    }

    /**
     * @inheritDoc
     */
    public function deleteCoupon(string $id, bool $test = false): void
    {
        try {
            $response = $this->httpClient->request(
                'DELETE',
                $this->getAppPaymentsUrl() . self::BASE_URI . '/' . $id,
                ['query' => ['test' => (int) $test]]
            );
            $data = json_decode($response->getContent(), true);
        } catch (\Throwable $t) {
            throw StripeCouponException::fromThrowable($t);
        }
        $this->checkData($data);
    }

    /**
     * @inheritDoc
     */
    public function getList(bool $test = false): array
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->getAppPaymentsUrl() . self::BASE_URI . '/',
                ['query' => ['test' => (int) $test]]
            );
            $data = json_decode($response->getContent(), true);
        } catch (\Throwable $t) {
            throw StripeCouponException::fromThrowable($t);
        }
        $this->checkData($data);
        if (!isset($data['coupons'])) {
            throw StripeCouponException::make('Invalid response received from stripe');
        }
        $result = [];
        foreach ($data['coupons'] as $coupon) {
            if (!isset($coupon['id'], $coupon['name'], $coupon['value'], $coupon['times_redeemed'])) {
                continue;
            }
            $result[] = CouponDTO::make(
                $coupon['id'],
                $coupon['name'],
                $coupon['value'],
                $coupon['times_redeemed'],
                $coupon['max_redemptions'] ?? null,
                $coupon['test'] ?? false
            );
        }
        return $result;
    }
}