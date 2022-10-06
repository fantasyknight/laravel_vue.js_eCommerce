<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZoneMethod extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'shipping_zone_id',
        'tax_status',
        'cost',
        'free_shipping_requirement',
        'minimum_order_amount',
        'enabled',
        'description'
    ];
}
