<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'enable_archives',
        'sort_by'
    ];

    protected $casts = [
        'enable_archives' => 'boolean'
    ];

    public function terms() {
        return $this->hasMany('App\Models\AttributeTerm');
    }

    public function delete() {
        $this->terms()->delete();
        return parent::delete();
    }
}
