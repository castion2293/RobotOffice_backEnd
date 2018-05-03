<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/25
 * Time: 下午 01:39
 */

namespace App\Transformers\Schedule;


class TransformerTripAnalysis extends AbstractTransformerType
{
    public function transform($attributes)
    {
        return collect([])->put('data', $attributes->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'date' => $schedule->date,
                'begin' => $schedule->action->begin,
                'end' => $schedule->action->end,
                'location' => $schedule->action->location,
                'hours' => $schedule->action->hours
            ];
        }))->put('hours_count', $attributes->reduce(function ($carry, $schedule) {
            return $carry + $schedule->action->hours;
        }))->put('count', $attributes->count());
    }
}