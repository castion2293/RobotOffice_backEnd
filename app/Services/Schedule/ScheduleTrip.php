<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/23
 * Time: 下午 01:39
 */

namespace App\Services\Schedule;


use App\Schedule;
use App\Trip;
use Illuminate\Http\Request;

class ScheduleTrip extends AbstractScheduleType
{
    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function post(Request $request)
    {
        $this->createNewTrip($request);
        return response(['message' => 'success upload'], 200);
    }

    private function createNewTrip($request)
    {
        $trip = $this->createTrip($request);
        $schedule = $this->makeSchedule($request, $trip);
        $this->user->schedules()->save($schedule);
    }

    /**
     * @param $request
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    private function createTrip($request)
    {
        $trip = Trip::create([
            'begin' => $request->begin,
            'end' => $request->end,
            'location' => $request->location,
            'hours' => $request->hours
        ]);
        return $trip;
    }

    /**
     * @param $request
     * @param $trip
     * @return Schedule
     */
    private function makeSchedule($request, $trip): Schedule
    {
        $schedule = new Schedule([
            'date' => $request->date,
            'action_type' => 'App\\' . $request->category,
            'action_id' => $trip->id
        ]);
        return $schedule;
    }


}