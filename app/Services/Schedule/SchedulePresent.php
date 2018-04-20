<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/20
 * Time: 上午 08:35
 */

namespace App\Services\Schedule;


use App\Present;
use App\Schedule;
use Illuminate\Http\Request;

class SchedulePresent extends AbstractScheduleType
{
    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function post(Request $request)
    {
        if ($this->checkDoublePostPresent($request)) {
            return response(['error' => '重複打卡上班，請先刪除之前打卡紀錄，再重新打卡上班'], 400);
        }

        $present  = $this->createPresent($request);

        $schedule = $this->makeSchedule($request, $present->id);

        $this->user->schedules()->save($schedule);

        return response(['message' => 'success upload'], 200);
    }

    private function createPresent ($request)
    {
        if ($request->work == '上班') {
            return $this->createPresentForWorkOn($request);
        } else if ($request->work == '下班') {

        } else {
            return '';
        }
    }

    private function makeSchedule($request, $id)
    {
        return new Schedule([
            'date' => $request->date,
            'action_type' => 'App\\' . $request->category,
            'action_id' => $id
        ]);
    }

    /**
     * @param $request
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    private function createPresentForWorkOn($request)
    {
        return Present::create([
            'begin' => $request->time
        ]);
    }

    private function checkDoublePostPresent($request)
    {
        $schedule = optional($this->user->schedules()->where('date', $request->date))->first();

        if (!$schedule) {
            return false;
        }

        $present = $schedule->action()->first();

        if (!$present->begin) {
            return false;
        }

        return true;
    }
}