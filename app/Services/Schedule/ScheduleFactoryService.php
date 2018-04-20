<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/20
 * Time: 上午 08:29
 */

namespace App\Services\Schedule;


use Illuminate\Support\Facades\App;

class ScheduleFactoryService
{
    public static function create($type)
    {
        App::bind(AbstractScheduleType::class, 'App\\Services\\Schedule\\Schedule' . $type);
        return App::make(AbstractScheduleType::class);
    }
}