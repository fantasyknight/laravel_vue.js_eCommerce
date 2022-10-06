<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ProductReview extends Model
{
    use HasFactory;
    use Sortable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'author_name',
        'author_email',
        'content',
        'rating',
        'parent',
        'approved'
    ];

    protected $casts = [
        'approved' => 'boolean'
    ];

    protected $appends = [
        'parent_author_name'
    ];

    public $sortable = [
        'author_name',
        'rating',
        'created_at'
    ];

    public $sortableAs = [
        'product_title'
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function getParentAuthorNameAttribute() {
        $parent = ProductReview::where('id', $this->parent)->first();
        return $parent ? $parent->author_name : null;
    }

    public function delete() {
        ProductReview::where('parent', $this->id)->update(['parent' => $this->parent]);
        return parent::delete();
    }
}
