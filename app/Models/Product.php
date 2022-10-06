<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use Helper;

class Product extends Model
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
        'slug',
        'type',
        'enabled',
        'description',
        'short_desc',
        'excerpt',
        'parent',
        'min_price',
        'max_price',
        'price',
        'sale_price',
        'sale_schedule',
        'sale_start',
        'sale_end',
        'tax_type_id',
        'tax_status',
        'sku',
        'manage_stock',
        'stock_quantity',
        'allow_backorder',
        'low_stock_threshold',
        'stock_status',
        'sold_individually',
        'weight',
        'length',
        'width',
        'height',
        'upsells',
        'cross_sells',
        'purchase_note',
        'menu_order',
        'enable_reviews',
        'downloadable',
        'virtual',
        'product_status',
        'featured',
        'author_id',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'sale_schedule' => 'boolean',
        'manage_stock' => 'boolean',
        'sold_individually' => 'boolean',
        'enable_reviews' => 'boolean',
        'downloadable' => 'boolean',
        'virtual' => 'boolean',
        'featured' => 'boolean'
    ];

    public $sortable = [
        'name',
        'sku',
        'stock_status',
        'created_at',
        'featured'
    ];

    protected $appends = [
        'min_max_price', 'average_rating'
    ];

    public function tags() {
        return $this->belongsToMany('App\Models\Tag', 'product_tag');
    }

    public function media() {
        return $this->belongsToMany('App\Models\Media', 'product_media')->withPivot('default');
    }

    public function files() {
        return $this->belongsToMany('App\Models\Media', 'product_files')->withPivot('name');
    }

    public function categories() {
        return $this->belongsToMany('App\Models\Category', 'product_category');
    }

    public function reviews() {
        return $this->hasMany('App\Models\ProductReview', 'product_id');
    }

    public function approvedReviews() {
        return $this->reviews()->where('approved', true);
    }

    public function attributes() {
        return $this->belongsToMany('App\Models\Attribute', 'product_attribute')
                    ->withPivot('term_ids', 'show_product_page', 'used_for_variation');
    }

    public function terms() {
        return $this->belongsToMany('App\Models\AttributeTerm', 'product_terms');
    }
    
    public function defaultImage() {
        return $this->belongsToMany('App\Models\Media', 'product_media')->wherePivot('default', '1');
    }

    public function taxType() {
        return $this->belongsTo('App\Models\TaxType');
    }

    public function author() {
        return $this->belongsTo('App\Models\User', 'author_id');
    }

    public function delete() {
        $this->categories()->detach();
        $this->tags()->detach();
        $this->media()->detach();
        $this->files()->detach();
        $this->reviews()->delete();
        if ($this->type="variable") {
            Product::where('parent', $this->id)->delete();
        }

        return parent::delete();
    }

    public function setSaleStartAttribute($value) {
        if (gettype($value) == 'string') {
            $this->attributes['sale_start'] = date('Y-m-d', strtotime($value));
        } else {
            $this->attributes['sale_start'] = $value;
        }
    }

    public function setSaleEndAttribute($value) {
        if (gettype($value) == 'string') {
            $this->attributes['sale_end'] = date('Y-m-d', strtotime($value));
        } else {
            $this->attributes['sale_end'] = $value;
        }
    }

    public function setUpsellsAttribute($value) {
        $this->attributes['upsells'] = implode(',', $value);
    }

    public function getUpsellsAttribute($value) {
        return explode(',', $value);
    }

    public function setCrossSellsAttribute($value) {
        $this->attributes['cross_sells'] = implode(',', $value);
    }

    public function getCrossSellsAttribute($value) {
        return explode(',', $value);
    }

    public function getMinMaxPriceAttribute() {
        return Helper::portoGetMinMaxPrice($this);
    }

    public function getAverageRatingAttribute() {
        $rating = $this->reviews()->where('approved', 1)->where('parent', 0)->avg('rating');
        return $rating ? round($rating, 2): 0;
    }
}
