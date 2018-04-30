<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/30
 * Time: 下午 03:03
 */

namespace App\Services\Schedule\Holiday;


abstract class AbstractHolidayType
{
    abstract public function post($request);
}