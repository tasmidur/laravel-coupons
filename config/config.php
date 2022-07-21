<?php

return [

    /*
     * Table that will be used for migration
     */
    'table' => 'coupons',

    /*
     * Model to use
     */
    'model' => \Tasmidur\Coupon\Models\Coupon::class,

    /*
     * Pivot table name for coupons and other table relation
     */
    'relation_table' => 'coupon_applied',

    /*
    * Pivot table model name for coupons and other table relation
    */

    'relation_model_class' => \App\Models\Course::class,
    /*
     * List of characters that will be used for Coupons code generation.
     */
    'coupon_mix_characters' => '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz',

    /*
     * Coupons code prefix.
     *
     * Example: course2022
     * Generated Code: course2022-37JH-1PUY
     */
    'prefix' => null,

    /*
     * Coupons code suffix.
     *
     * Example: course2022
     * Generated Code: 37JH-1PUY-course2022
     */
    'suffix' => null,

    /*
     * Separator to be used between prefix, code and suffix.
     */
    'separator' => '-',

    'coupon_format'=>'*****-*****'


];
