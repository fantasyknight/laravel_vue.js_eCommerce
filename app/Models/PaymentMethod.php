<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'environment',
        'enabled',
        'description'
    ];

    /**
     * Set the enabled.
     *
     * @param  string  $value
     * @return void
     */
    public function setEnabledAttribute($value)
    {
        if (is_bool($value) == true) {
            $this->attributes['enabled'] = true;
        } else {
            $this->attributes['enabled'] = false;
        }

        $this->attributes['enabled'] = $value == "true" ? true : false;
    }
}
