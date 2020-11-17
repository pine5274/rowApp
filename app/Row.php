<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    protected $fillable = [
        'boat_name',
        'date_time',
    ];

    /** JSONに含める属性 */
    protected $visible = [
        'owner', 'date_time', 'boat_name', 'on_the_water', 'off_the_water', 'lower_limit_area', 'upper_limit_area',
    ];

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id', 'id', 'users');
    }
}
