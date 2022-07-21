<?php

namespace Tasmidur\Coupon\Traits;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;
use Tasmidur\Coupon\Facades\Coupons;
use Tasmidur\Coupon\Models\Coupon;

trait CouponTrait
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

    /**
     * @throws Exception
     */
    public function applyUniqueCoupon(string $code)
    {
        $coupon = Coupons::check($code);
        Log::info($this->coupons()->get());
        if ($this->coupons()->count() > 0) {
            throw new Exception("The coupon is already applied");
        }

        if ($coupon->isExpired()) {
            throw new Exception("The coupon is already expire now");
        }
        $this->coupons()->attach($coupon, [
            'applied_at' => Carbon::now()
        ]);
        return $coupon;
    }

    /**
     * @return BelongsToMany
     */
    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(Coupon::class, config('coupon.relation_table', "coupon_applied"), 'coupon_id', "apply_for_id")->withPivot('applied_at');
    }

}
