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
        if ($request->work == '上班') {
            if ($this->checkDoubleWorkOnPresent($request)) {
                return response(['error' => '重複打卡上班，請先刪除之前打卡紀錄，再重新打卡上班'], 400);
            }

            $this->createPresentForWorkOn($request);

        } else if ($request->work == '下班') {
            if ($this->checkNoWorkOn($request)) {
                return response(['error' => '打卡下班前，需先打卡上班'], 400);
            } else if ($this->checkDoubleWorkOffPresent($request)) {
                return response(['error' => '重複打卡下班，請先刪除之前打卡紀錄，再重新打卡下班'], 400);
            } else if ($this->checkOffPresentLaterThanOnPresent($request)) {
                return response(['error' => '打卡下班時間需晚於打卡上班時間'], 400);
            }

            $this->createPresentForWorkOff($request);
        }

        return response(['message' => 'success upload'], 200);
    }

    private function createPresentForWorkOn($request)
    {
        $present = $this->createPresent($request);
        $schedule = $this->makeSchedule($request, $present->id);
        $this->user->schedules()->save($schedule);
    }

    private function createPresentForWorkOff($request)
    {
        $schedule = $this->getSchedule($request);

        $present = $schedule->action()->first();

        $present->update([
            'end' => $request->time
        ]);
    }

    private function makeSchedule($request, $id)
    {
        return new Schedule([
            'date' => $request->date,
            'action_type' => 'App\\' . $request->category,
            'action_id' => $id
        ]);
    }

    private function createPresent($request)
    {
        return Present::create([
            'begin' => $request->time
        ]);
    }

    private function checkDoubleWorkOnPresent($request)
    {
        $schedule = $this->getSchedule($request);

        if (!$schedule) {
            return false;
        }

        $present = $schedule->action()->first();

        if (!$present->begin) {
            return false;
        }

        return true;
    }

    private function checkNoWorkOn($request)
    {
        $schedule = $this->getSchedule($request);

        if (!$schedule) {
            return true;
        }

        $present = $schedule->action()->first();

        if (!$present->begin) {
            return true;
        }

        return false;
    }

    private function checkDoubleWorkOffPresent($request)
    {
        $schedule = $this->getSchedule($request);

        if (!$schedule) {
            return false;
        }

        $present = $schedule->action()->first();

        if (!$present->end) {
            return false;
        }

        return true;
    }

    private function checkOffPresentLaterThanOnPresent($request)
    {
        $schedule = $this->getSchedule($request);

        $present = $schedule->action()->first();

        if ($present->begin > $request->time) {
            return true;
        }

        return false;
    }

    /**
     * @param $request
     * @return mixed
     */
    private function getSchedule($request)
    {
        return optional($this->user->schedules()->where('date', $request->date))->first();
    }
}