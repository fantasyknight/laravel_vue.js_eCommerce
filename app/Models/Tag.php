<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Tag extends Model
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
        'description',
        'type'
    ];

    public $sortable = [
        'name',
        'slug',
        'description',
        'count'
    ];

    public $sortableAs = [
        'posts_count',
        'products_count'
    ];

    public function delete() {
        if ($this->type == 'product') {
            $this->products()->detach();
        } else {
            $this->posts()->detach();
        }

        return parent::delete();
    }

    public function posts() {
        return $this->belongsToMany('App\Models\Post', 'post_tag');
    }

    public function products() {
        return $this->belongsToMany('App\Models\Product', 'product_tag');
    }
}
