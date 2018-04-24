<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $guarded = [];

    protected $with = 'types';

    public function schedules()
    {
        return $this->morphMany('App\Schedule', 'action');
    }

    public function types()
    {
        return $this->belongsToMany('App\Type', 'holiday_type');
    }
}
