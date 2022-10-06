<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'parent_id',
        'name',
        'qty',
        'net_revenue',
        'gross_revenue',
        'coupon_amount',
        'tax_amount',
        'shipping_amount',
        'shipping_tax_amount'
    ];

    public function order() {
        return $this->belongsTo('App\Models\Order');
    }

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }
}
