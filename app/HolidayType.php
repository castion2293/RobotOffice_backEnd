<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HolidayType extends Model
{
    protected $guarded = [];

    public function holidays()
    {
        return $this->belongsToMany('App\Holiday', 'holiday_type', 'type_id', 'holiday_id');
    }
}
