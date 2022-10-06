<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Post extends Model
{
    use HasFactory;
    use Sortable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'allow_comments',
        'enabled',
        'description',
        'short_desc'
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'allow_comments' => 'boolean'
    ];

    public $sortable = [
        'title',
        'created_at'
    ];

    public $sortableAs = [
        'comments_count'
    ];

    protected $appends = [
        'period'
    ];

    public function getPeriodAttribute() {
        return date('F Y', strtotime($this->created_at));
    }

    // Relationship

    public function author() {
        return $this->belongsTo('App\Models\User');
    }
    
    public function categories() {
        return $this->belongsToMany('App\Models\Category', 'post_category');
    }
    
    public function comments() {
        return $this->hasMany('App\Models\PostComment');
    }

    public function media() {
        return $this->belongsToMany('App\Models\Media', 'post_media');
    }

    public function tags() {
        return $this->belongsToMany('App\Models\Tag', 'post_tag');
    }

    // Extend basic functions

    public function delete() {
        $this->categories()->detach();
        $this->tags()->detach();
        $this->media()->detach();
        $this->comments()->delete();

        return parent::delete();
    }
}
