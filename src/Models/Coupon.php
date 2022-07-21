<?php

namespace Tasmidur\Coupon\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{

    const COUPON_TYPE = [
        "FIXED_PRICE",
        "DISCOUNT_PRICE"
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'coupon_code',
        'coupon_type',
        'price',
        'status',
        'expired_at'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('coupon.table', 'coupons');
    }

    /**
     * Get where apply this coupon.
     *
     * @return BelongsToMany
     */
    public function applies(): BelongsToMany
    {
        return $this->belongsToMany(config('coupon.relation_model_class'), config('coupon.relation_table'),'coupon_id','apply_for_id')->withPivot('applied_at');
    }

    /**
     * Check if code is expired.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        $expiredAt = Carbon::createFromFormat('Y-m-d H:i:s', $this->expired_at);
        $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
        return $expiredAt && $now->gte($expiredAt);
    }

    /**
     * Check if code is not expired.
     *
     * @return bool
     */
    public function isNotExpired(): bool
    {
        return !$this->isExpired();
    }
}
