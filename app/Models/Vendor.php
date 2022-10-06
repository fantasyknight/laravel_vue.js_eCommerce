<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'store_name',
        'banner_image',
        'paypal_email',
        'enable_add_product',
        'featured',
        'status',
        'profile_image',
        'phone',
        'street',
        'state',
        'country',
        'city',
        'postcode',
        'toc',
        'balance'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function banner() {
        return $this->belongsTo('App\Models\Media', 'banner_image');
    }

    public function profile() {
        return $this->belongsTo('App\Models\Media', 'profile_image');
    }
}
