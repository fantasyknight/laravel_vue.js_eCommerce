<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCoupon extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'coupon_id',
        'coupon_code',
        'coupon_amount',
        'coupon_tax_amount'
    ];

    public function order() {
        return $this->belongsTo('App\Models\Order');
    }
}
