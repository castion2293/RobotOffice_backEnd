<?php

namespace App;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [];

    protected $with = 'action';

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($schedule) {
            if ($schedule->action_type == 'App\\Holiday') {
                $schedule->action->types()->detach();
            }

            $schedule->action->delete();
        });
    }

    public function users()
    {
        return $this->belongsTo('App\User');
    }

    public function action()
    {
        return $this->morphTo();
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query->where('user_id', auth()->id()));
    }
}
