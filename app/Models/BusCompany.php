<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusCompany extends Model
{
    protected $table = 'bus_companies';

    protected $fillable = [
        'company_name',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
