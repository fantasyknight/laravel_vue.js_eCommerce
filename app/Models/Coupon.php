<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Coupon extends Model
{
    use HasFactory;
    use Sortable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'amount',
        'free_shipping',
        // 'expiry_date',
        'minimum_spend',
        'maximum_spend',
        'individual_use',
        'exclude_sale_items',
        'products',
        'exclude_products',
        'categories',
        'exclude_categories',
        'limit_per_coupon',
        'limit_x_items',
        'limit_per_user',
        'allowed_emails'
    ];
    
    public $sortable = [
        'expiry_date'
    ];

    protected $appends = [
        'usage'
    ];

    public function getUsageAttribute() {
        return $this->hasMany('App\Models\OrderCoupon')->count();
    }

    public function getProductsAttribute($value) {
        if ($value)
            return explode(',',  $value);
        else 
            return [];
    }

    public function setProductsAttribute($value) {
        if ($value) {
            $this->attributes['products'] = implode(',', $value);
        } else {
            $this->attributes['products'] = null;
        }
    }

    public function getExcludeProductsAttribute($value) {
        if ($value)
            return explode(',',  $value);
        else
            return [];
    }

    public function setExcludeProductsAttribute($value) {
        if ($value) {
            $this->attributes['exclude_products'] = implode(',', $value);
        } else {
            $this->attributes['exclude_products'] = null;
        }
    }

    public function getCategoriesAttribute($value) {
        if ($value)
            return explode(',',  $value);
        else
            return [];
    }

    public function setCategoriesAttribute($value) {
        if ($value) {
            $this->attributes['categories'] = implode(',', $value);
        } else {
            $this->attributes['categories'] = null;
        }
    }

    public function getExcludeCategoriesAttribute($value) {
        if ($value)
            return explode(',',  $value);
        else
            return [];
    }

    public function setExcludeCategoriesAttribute($value) {
        if ($value) {
            $this->attributes['exclude_categories'] = implode(',', $value);
        } else {
            $this->attributes['exclude_categories'] = null;
        }
    }
}
