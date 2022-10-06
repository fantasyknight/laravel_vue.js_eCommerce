<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AttributeTerm extends Model
{
    use HasFactory;
    use Sortable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attribute_id',
        'name',
        'slug',
        'description',
        'count',
    ];

    public $sortable = [
        'name',
        'slug',
        'description'
    ];

    public function attribute() {
        return $this->belongsTo('App\Models\Attribute');
    }

    public function product() {
        return $this->belongsToMany('App\Models\Product', 'product_terms');
    }
}
