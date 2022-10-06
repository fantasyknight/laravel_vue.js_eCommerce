<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ShippingZone extends Model
{
    use HasFactory;
    use Sortable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'enabled'
    ];

    public $sortable = [
        'name'
    ];
    
    public function shippingZoneMethods() {
        return $this->hasMany('App\Models\ShippingZoneMethod');
    }

    public function shippingLocations() {
        return $this->hasMany('App\Models\ShippingLocation');
    }

    public function delete() {
        $this->shippingZoneMethods()->delete();
        $this->shippingLocations()->delete();
        return parent::delete();
    }
}
