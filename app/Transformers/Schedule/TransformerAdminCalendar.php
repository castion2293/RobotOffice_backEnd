<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/30
 * Time: 上午 10:20
 */

namespace App\Transformers\Schedule;


class TransformerAdminCalendar extends AbstractTransformerType
{
    public function transform($attributes)
    {
        return $attributes->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'title' => $this->checkType($schedule),
                'start' => $schedule->date . 'T' . $schedule->action->begin,
                'end' => $schedule->date . 'T' . $schedule->action->end,
                'color' => $this->checkColor($schedule->user_id),
                'textColor' => 'white'
            ];
        });
    }

    private function checkType($schedule)
    {
        switch ($schedule->action_type) {
            case 'App\\Present':
                return $this->presentTitle($schedule->action, $schedule->users->name);
                break;
            case 'App\\Holiday':
                return $this->holidayTitle($schedule->action, $schedule->users->name);
                break;
            case 'App\\Trip':
                return $this->tripTitle($schedule->action, $schedule->users->name);
                break;
            case 'App\\Rest':
                return $this->restTitle($schedule->action, $schedule->users->name);
                break;
            default:
                break;
        }
    }

    private function checkColor($id)
    {
        switch ($id) {
            case 1:
                return '#4FC3F7';
                break;
            case 2:
                return '#81C784';
                break;
            case 3:
                return '#FFA726';
                break;
            case 4:
                return '#EF5350';
                break;
            default:
                break;
        }
    }

    /**
     * @param $schedule
     * @return string
     */
    private function presentTitle($present, $name): string
    {
        return $name . ' 上班' . ((!!$present->end) ? '~' . substr($present->end, 0, 5) . '下班' : '');
    }

    /**
     * @param $schedule
     * @return string
     */
    private function holidayTitle($holiday, $name): string
    {
        return $name. ' 請' . $holiday->types()->first()->type . '~' . substr($holiday->end, 0, 5);
    }

    /**
     * @param $schedule
     * @return string
     */
    private function tripTitle($trip, $name): string
    {
        return $name . ' ' . $trip->location . '出差~' . substr($trip->end, 0, 5);
    }

    /**
     * @param $schedule
     * @return string
     */
    private function restTitle($rest, $name): string
    {
        return $name . ' ' . $rest->reason . '補休~' . substr($rest->end, 0, 5);
    }
}