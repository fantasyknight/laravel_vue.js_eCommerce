<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
// use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;
use Carbon\Carbon;

class User extends Authenticatable
{
    // use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role_id',
        'website',
        'description',

        'ip_address',
        'billing_first_name',
        'billing_last_name',
        'billing_company',
        'billing_address_1',
        'billing_address_2',
        'billing_city',
        'billing_state',
        'billing_postcode',
        'billing_country',
        'billing_email',
        'billing_phone',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_company',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_city',
        'shipping_state',
        'shipping_postcode',
        'shipping_country',

        'sign_up',
        'last_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    public $sortable = [
        'first_name',
        'email',
        'sign_up',
        'last_active'
    ];

    public $sortableAs = [
        'orders_count',
        'posts_count',
        'total_spend',
        'aov'
    ];

    public function products() {
        return $this->hasMany('App\Models\Product', 'author_id');
    }

    public function posts() {
        return $this->hasMany('App\Models\Post', 'author_id');
    }

    public function media() {
        return $this->hasMany('App\Models\Media', 'author_id');
    }

    public function role() {
        return $this->belongsTo('App\Models\Role');
    }

    public function vendor() {
        return $this->hasOne('App\Models\Vendor');
    }

    // Orders those were placed by this user
    public function orders() {
        return $this->hasMany('App\Models\Order', 'customer_email', 'email');
    }

    public function withdraws() {
        return $this->hasMany('App\Models\UserWithdraw', 'user_id');
    }

    public function delete() {
        $this->posts()->delete();
        $this->products()->delete();
        $this->vendor()->delete();

        return parent::delete();
    }

    // Order itesm those were processed by this user
    public function processedOrderItems() {
        return $this->hasManyThrough('App\Models\OrderItem', 'App\Models\Order' , 'author_id');
    }

    public function getLastActiveAttribute($value) {
        return ! $value ? null : Carbon::createFromDate($value);
    }

    public function getSignUpAttribute($value) {
        return ! $value ? null : Carbon::createFromDate($value);
    }
}
