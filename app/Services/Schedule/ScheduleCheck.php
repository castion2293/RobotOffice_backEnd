<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/30
 * Time: 下午 03:27
 */

namespace App\Services\Schedule;


use Gate;
use Lang;

trait ScheduleCheck
{
    public function authorize($policies, $request)
    {
        $policies->each(function ($policy) use ($request) {
            if (Gate::allows($policy, $request)) {
                abort(400, Lang::get('schedule')[$policy]);
            }
        });

        return $this;
    }
}