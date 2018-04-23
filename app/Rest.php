<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    protected $guarded = [];

    public function schedules()
    {
        return $this->morphMany('App\Schedule', 'action');
    }
}
