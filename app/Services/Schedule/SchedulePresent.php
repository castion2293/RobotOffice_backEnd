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
use App\Transformers\ScheduleTransformer;
use Illuminate\Http\Request;

class SchedulePresent extends AbstractScheduleType
{
    use ScheduleCheck;

    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function post(Request $request)
    {
        if ($request->work == '上班') {
            $this->authorize(collect(['checkDoubleWorkOnPresent']), $request)
                 ->createPresentForWorkOn($request);

        } else if ($request->work == '下班') {
            $this->authorize(collect(['checkNoWorkOn', 'checkDoubleWorkOffPresent', 'checkOffPresentLaterThanOnPresent']), $request)
                ->createPresentForWorkOff($request);
        }

        return response(['message' => 'success upload'], 200);
    }

    public function delete(Schedule $schedule)
    {
        $schedule->delete();

        return response(['message' => 'success deleted'], 200);
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

    private function getSchedule($request)
    {
        return optional($this->user->schedules()->where('date', $request->date))->first();
    }
}