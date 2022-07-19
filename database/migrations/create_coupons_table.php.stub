<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $couponTable = config('coupon.table', 'coupons');
        $couponApplied = config('coupon.coupon_applied_table', 'coupon_applied');

        Schema::create($couponTable, function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code', 64)->unique();
            $table->string('coupon_type')->comment("1=>FIXED_PRICE, 2=>DISCOUNT_PRICE");
            $table->double('price')->nullable();
            $table->double('status')->default(1)->comment("1=>CREATED,2=>ASSIGN,3=>EXPIRED depend on expired at that will be managed logically");
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });

        $couponId = str_ends_with($couponTable, 's') ? substr_replace($couponTable, "_id", -1) : $couponTable . "_id";

        Schema::create($couponApplied, function (Blueprint $table) use ($couponTable, $couponId) {
            $table->id();
            $table->unsignedBigInteger($couponId);
            $table->morphs('model');
            $table->double('net_price');
            $table->timestamp('applied_at')->nullable();
            $table->timestamps();

            $table->foreign($couponId)
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->on($couponTable);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(config('coupon.table', 'coupons'));
        Schema::dropIfExists(config('coupon.coupon_applied_table', 'coupon_applied'));
    }
}
