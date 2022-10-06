<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Order extends Model
{
    use HasFactory;
    use Sortable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent',
        'order_type',
        'customer_name',
        'customer_email',
        'author_id',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_company',
        'shipping_street_1',
        'shipping_street_2',
        'shipping_city',
        'shipping_state',
        'shipping_postcode',
        'shipping_country',
        'billing_first_name',
        'billing_last_name',
        'billing_company',
        'billing_street_1',
        'billing_street_2',
        'billing_city',
        'billing_state',
        'billing_postcode',
        'billing_country',
        'billing_phone',
        'billing_email',
        'shipping_method',
        'payment_method',
        'shipping_cost',
        'shipping_tax',
        'order_tax',
        'order_total_price',
        'order_total_qty',
        'status',
        'order_info',
        'vendor_net'
    ];

    protected $appends = [
        'diff'
    ];

    public $sortable = [
        'id',
        'created_at',
        'order_total_price'
    ];


    public function author() {
        return $this->belongsTo('App\Models\User');
    }

    public function customer() {
        return $this->belongsTo('App\Models\User', 'customer_email', 'email');
    }

    public function coupons() {
        return $this->hasMany('App\Models\OrderCoupon');
    }

    public function items() {
        return $this->hasMany('App\Models\OrderItem');
    }

    public function notes() {
        return $this->hasMany('App\Models\OrderNote');
    }

    public function delete() {
        // Remove refunded & suborders
        $subs = Order::where('parent', $this->id)->get()->pluck('id');
        Order::destroy($subs);

        $this->items()->delete();
        $this->notes()->delete();
        $this->coupons()->delete();
        return parent::delete();
    }

    public function getDiffAttribute() {
        return $this->created_at->diffForHumans();
    }
}
