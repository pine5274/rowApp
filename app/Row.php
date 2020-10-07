<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    protected $fillable = [
        'boat_name',
        'date_time',
    ];
}
