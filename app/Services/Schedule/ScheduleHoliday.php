<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/20
 * Time: 下午 02:03
 */

namespace App\Services\Schedule;

use App\Schedule;
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
        ScheduleFactoryService::createHoliday($request->type)->post($request);

        return response(['message' => 'success upload'], 200);
    }

    public function delete(Schedule $schedule)
    {
        $this->complementHours($schedule);

        $schedule->delete();

        return response(['message' => 'success deleted'], 200);
    }

    private function complementHours(Schedule $schedule): void
    {
        if ($schedule->holidayType == '特休') {
            $this->user->holiday += $schedule->action->hours;
            $this->user->save();
        } else if ($schedule->holidayType == '補休') {
            $this->user->rest += $schedule->action->hours;
            $this->user->save();
        }
    }
}