<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/30
 * Time: 下午 03:15
 */

namespace App\Services\Schedule\Holiday;


use App\Holiday;
use App\Schedule;
use App\Type;

class Holiday病假 extends AbstractHolidayType
{
    public function post($request)
    {
        $this->create($request);
    }

    /**
     * @param $request
     */
    private function create($request): void
    {
        $holidayType = Type::where('type', $request->type)->first();
        $holiday = $this->createHoliday($request);
        $holiday->types()->attach($holidayType->id);
        $schedule = $this->makeSchedule($request, $holiday);
        auth()->user()->schedules()->save($schedule);
    }

    private function createHoliday($request)
    {
        return Holiday::create([
            'begin' => $request->begin,
            'end' => $request->end,
            'hours' => $request->hours,
        ]);
    }

    protected function makeSchedule($request, $holiday)
    {
        return new Schedule([
            'date' => $request->date,
            'action_type' => 'App\\' . $request->category,
            'action_id' => $holiday->id
        ]);
    }


}