<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'amazon_order_id',
        'product_name',
        'product_id',
        'variant_id',
        'is_voucher',
        'voucher_code',
        'product_review',
        'product_feedback',
        'product_rating',
        'order_status',
        'shopify_response'
    ];

    public static function getOrderStatusOptions()
    {
        return [
            'draft' => 'Draft',
            'voucher' => 'Voucher',
            'fulfilled' => 'Fulfilled'
        ];
    }
}
