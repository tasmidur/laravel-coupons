<?php

namespace Tasmidur\Coupon\Facades;

use Carbon\Carbon;
use Illuminate\Support\Facades\Facade;

/**
 * Class Coupons
 * @method static array createCoupon(string $couponType, float $price, Carbon|null $expiredAt = null, int $totalAmount = 1)
 * @method static mixed getCouponList(string $sortBy = "id", string $orderBy = "ASC")
 * @method static mixed getCouponListWithPagination(int $length = 10, string $sortBy = "id", string $orderBy = "ASC")
 * @method static bool deleteCoupon(int $id)
 * @method static mixed getCoupon(int $id)
 * @method static mixed updateCoupon(array $payload, int $id)
 * @method static mixed check(string $code)
 * @method static mixed whereApplyCoupon(string $code)
 *
 * @see \Tasmidur\Coupon\CouponCode
 */
class Coupons extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'coupons';
    }
}
