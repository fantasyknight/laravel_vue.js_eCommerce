<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderNote extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'author_id',
        'content',
        'notify_customer'
    ];

    public function author() {
        return $this->belongsTo('App\Models\User', 'author_id');
    }

    public function order() {
        return $this->belongsTo('App\Models\Order');
    }
}
