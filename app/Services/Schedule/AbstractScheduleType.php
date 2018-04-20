<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/20
 * Time: 上午 08:33
 */

namespace App\Services\Schedule;

use Illuminate\Http\Request;

abstract class AbstractScheduleType
{
    abstract public function post(Request $request);
}