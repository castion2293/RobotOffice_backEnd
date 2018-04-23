<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/23
 * Time: 下午 02:04
 */

namespace App\Services\Schedule;


use App\Rest;
use App\Schedule;
use Illuminate\Http\Request;

class ScheduleRest extends AbstractScheduleType
{
    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function post(Request $request)
    {
        $this->createNewRest($request);

        return response(['message' => 'success upload'], 200);
    }

    private function createNewRest($request)
    {
        $rest = $this->createRest($request);
        $schedule = $this->makeSchedule($request, $rest);
        $this->user->schedules()->save($schedule);

        $this->user->rest += $request->hours;
        $this->user->save();
    }

    /**
     * @param $request
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    private function createRest($request)
    {
        $rest = Rest::create([
            'begin' => $request->begin,
            'end' => $request->end,
            'reason' => $request->reason,
            'hours' => $request->hours
        ]);
        return $rest;
    }

    /**
     * @param $request
     * @param $rest
     * @return Schedule
     */
    private function makeSchedule($request, $rest): Schedule
    {
        $schedule = new Schedule([
            'date' => $request->date,
            'action_type' => 'App\\' . $request->category,
            'action_id' => $rest->id
        ]);
        return $schedule;
    }
}