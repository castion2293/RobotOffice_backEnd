<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/20
 * Time: 上午 08:29
 */

namespace App\Services\Schedule;


use App\Services\Schedule\Holiday\AbstractHolidayType;
use Illuminate\Support\Facades\App;

class ScheduleFactoryService
{
    public static function create($type)
    {
        App::bind(AbstractScheduleType::class, 'App\\Services\\Schedule\\Schedule' . $type);
        return App::make(AbstractScheduleType::class);
    }

    public static function createHoliday($type)
    {
        App::bind(AbstractHolidayType::class, 'App\\Services\\Schedule\\Holiday\\Holiday' . $type);
        return App::make(AbstractHolidayType::class);
    }
}