<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/20
 * Time: 上午 08:33
 */

namespace App\Services\Schedule;

use Gate;
use Illuminate\Http\Request;
use Lang;

abstract class AbstractScheduleType
{
    abstract public function post(Request $request);

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