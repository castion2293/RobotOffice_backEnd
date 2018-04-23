<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $guarded = [];

    public function holidays()
    {
        return $this->belongsToMany('App\Holiday', 'holiday_type');
    }
}
