<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'promo_code',
        'discount_type',
        'discount_value',
        'route',
    ];
}
