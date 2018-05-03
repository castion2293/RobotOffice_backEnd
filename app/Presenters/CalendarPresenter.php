<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/5/3
 * Time: 上午 10:37
 */

namespace App\Presenters;


use Carbon\Carbon;

class CalendarPresenter
{
    public function year($year, $month, $dir)
    {
        return Carbon::create($year, $month)->$dir()->year;
    }

    public function month($year, $month, $dir)
    {
        return Carbon::create($year, $month)->$dir()->month;
    }
}