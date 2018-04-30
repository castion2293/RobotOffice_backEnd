<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/30
 * Time: 下午 03:17
 */

namespace App\Services\Schedule\Holiday;


use App\Holiday;
use App\Schedule;
use App\Services\Schedule\ScheduleCheck;
use App\Type;

class Holiday特休 extends AbstractHolidayType
{
    use ScheduleCheck;

    public function post($request)
    {
        $this->authorize(collect(['checkHolidayHours']), $request)
            ->create($request);
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

        auth()->user()->holiday -= $request->hours;
        auth()->user()->save();
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