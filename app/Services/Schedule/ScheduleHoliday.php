<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/20
 * Time: 下午 02:03
 */

namespace App\Services\Schedule;


use App\Holiday;
use App\HolidayType;
use App\Schedule;
use App\Type;
use Illuminate\Http\Request;

class ScheduleHoliday extends AbstractScheduleType
{
    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function post(Request $request)
    {
        switch ($request->type) {
            case '事假':
                $this->createHolidayForBusiness($request);
                break;
            case '病假':
                $this->createHolidayForSick($request);
                break;
            case '特休':
                if ($this->checkHolidayHours($request)) {
                    return response(['error' => '剩餘的特休時數不足，請重新選擇時段'], 400);
                }

                $this->createHolidayForHoliday($request);
                break;
            case '補休':
                if ($this->checkRestHours($request)) {
                    return response(['error' => '剩餘的補休時數不足，請重新選擇時段'], 400);
                }

                $this->createHolidayForRest($request);
                break;
            default:
                break;
        }

        return response(['message' => 'success upload'], 200);
    }

    private function createHolidayForBusiness($request)
    {
        $holidayType = Type::where('type', $request->type)->first();
        $holiday = $this->createHoliday($request);
        $holiday->types()->attach($holidayType->id);
        $schedule = $this->makeSchedule($request, $holiday);
        $this->user->schedules()->save($schedule);
    }

    private function createHolidayForSick($request)
    {
        $holidayType = Type::where('type', $request->type)->first();
        $holiday = $this->createHoliday($request);
        $holiday->types()->attach($holidayType->id);
        $schedule = $this->makeSchedule($request, $holiday);
        $this->user->schedules()->save($schedule);
    }

    private function createHolidayForHoliday($request)
    {
        $holidayType = Type::where('type', $request->type)->first();
        $holiday = $this->createHoliday($request);
        $holiday->types()->attach($holidayType->id);
        $schedule = $this->makeSchedule($request, $holiday);
        $this->user->schedules()->save($schedule);

        $this->user->holiday -= $request->hours;
        $this->user->save();
    }

    private function createHolidayForRest($request)
    {
        $holidayType = Type::where('type', $request->type)->first();
        $holiday = $this->createHoliday($request);
        $holiday->types()->attach($holidayType->id);
        $schedule = $this->makeSchedule($request, $holiday);
        $this->user->schedules()->save($schedule);

        $this->user->rest -= $request->hours;
        $this->user->save();
    }

    private function checkHolidayHours($request)
    {
        return $request->hours > $this->user->holiday;
    }

    private function checkRestHours($request)
    {
        return $request->hours > $this->user->rest;
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