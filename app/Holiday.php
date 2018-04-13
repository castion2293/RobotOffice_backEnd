<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $guarded = [];

    public function schedules()
    {
        return $this->morphMany('App\Schedule', 'action');
    }

    public function types()
    {
        return $this->belongsToMany('App\HolidayType', 'holiday_type', 'type_id', 'holiday_id');
    }
}
