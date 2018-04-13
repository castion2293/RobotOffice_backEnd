<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo('App\User');
    }

    public function action()
    {
        return $this->morphTo();
    }
}
