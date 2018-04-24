<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/24
 * Time: 上午 08:31
 */

namespace App\Filters;


use Illuminate\Http\Request;

class ScheduleFilters extends QueryFilter
{
    public function year($year)
    {
        return $this->builder->whereYear('date', $year);
    }

    public function month($month)
    {
        return $this->builder->whereMonth('date', $month);
    }

    public function type($type)
    {
        return $this->builder->where('action_type', 'App\\' . $type );
    }
}