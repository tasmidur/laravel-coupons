<?php

namespace Tasmidur\Coupon\Traits;

use Carbon\Carbon;
use Exception;
use Tasmidur\Coupon\Facades\Coupons;
use Tasmidur\Coupon\Models\Coupon;

trait CanApplyCoupon
{

    /**
     * @throws Exception
     */
    public function applyCoupon(string $code)
    {
        $coupon = Coupons::check($code);
        if ($coupon->isExpired()) {
            throw new Exception("The coupon is already expire now");
        }
        $this->coupons()->attach($coupon, [
            'applied_at' => Carbon::now()
        ]);
        return $coupon;
    }

//    /**
//     * @throws Exception
//     */
//    public function applyCoupon(Coupon $coupon)
//    {
//        return $this->applyCode($coupon->coupon_code);
//    }

    /**
     * @return mixed
     */
    public function coupons(): mixed
    {
        return $this->belongsToMany(Coupon::class, config('coupon.relation_table', "coupon_applied"))->withPivot('applied_at');

    }
}
