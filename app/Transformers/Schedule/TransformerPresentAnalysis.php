<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/25
 * Time: 上午 11:52
 */

namespace App\Transformers\Schedule;


class TransformerPresentAnalysis extends AbstractTransformerType
{
    public function transform($attributes)
    {
       return $attributes->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'date' => $schedule->date,
                'begin' => $schedule->action->begin,
                'end' => $schedule->action->end
            ];
        })->put('count', $attributes->count());
    }
}