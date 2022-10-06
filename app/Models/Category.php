<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use App\Http\Controllers\Admin\CategoryController;
use App\Models\Product;
use App\Models\Post;

class Category extends Model
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
        'parent',
        'description',
        'display_type',
        'media_id',
        'icon',
        'type'
    ];

    protected $appends = [
        'count'
    ];

    public $sortable = [
        'name',
        'slug',
        'description'
    ];

    public function posts()
    {
        return $this->belongsToMany('App\Models\Post', 'post_category');
    }

    public function products() {
        return $this->belongsToMany('App\Models\Product', 'product_category');
    }

    public function media()
    {
        return $this->belongsTo('App\Models\Media', 'media_id');
    }

    public function delete() {
        Category::where('parent', $this->id)->update(['parent' => $this->parent]);
        return parent::delete();
    }

    public function getCountAttribute() {
        $category_controller = new CategoryController();
        $children_categories = $category_controller->categorySorted($this->type, $this->id)->pluck('id');
        if ($this->type == 'product') {
            return Product::whereHas('categories', function ($query) use ($children_categories) {
                $query->whereIn('category_id', $children_categories);
            } )->count();
        } else {
            return Post::whereHas('categories', function ($query) use ($children_categories) {
                $query->whereIn('category_id', $children_categories);
            } )->count();
        }
    }
}
