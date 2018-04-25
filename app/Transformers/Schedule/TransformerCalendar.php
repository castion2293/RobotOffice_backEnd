<?php
/**
 * Created by PhpStorm.
 * User: robotech
 * Date: 2018/4/25
 * Time: 上午 09:01
 */

namespace App\Transformers\Schedule;


class TransformerCalendar extends AbstractTransformerType
{
    public function transform($attributes)
    {
        return $attributes->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'title' => $this->checkType($schedule),
                'start' => $schedule->date . 'T' . $schedule->action->begin,
                'end' => $schedule->date . 'T' . $schedule->action->end,
                'color' => $this->checkColor($schedule->action_type)
            ];
        });
    }

    private function checkType($schedule)
    {
        switch ($schedule->action_type) {
            case 'App\\Present':
                return $this->presentTitle($schedule->action);
                break;
            case 'App\\Holiday':
                return $this->holidayTitle($schedule->action);
                break;
            case 'App\\Trip':
                return $this->tripTitle($schedule->action);
                break;
            case 'App\\Rest':
                return $this->restTitle($schedule->action);
                break;
            default:
                break;
        }
    }

    private function checkColor($type)
    {
        switch ($type) {
            case 'App\\Present':
                return '#4FC3F7';
                break;
            case 'App\\Holiday':
                return '#81C784';
                break;
            case 'App\\Trip':
                return '#FFA726';
                break;
            case 'App\\Rest':
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
    private function presentTitle($present): string
    {
        return '上班' . ((!!$present->end) ? '~' . substr($present->end, 0, 5) . '下班' : '');
    }

    /**
     * @param $schedule
     * @return string
     */
    private function holidayTitle($holiday): string
    {
        return '請' . $holiday->types()->first()->type . '~' . substr($holiday->end, 0, 5);
    }

    /**
     * @param $schedule
     * @return string
     */
    private function tripTitle($trip): string
    {
        return $trip->location . '出差~' . substr($trip->end, 0, 5);
    }

    /**
     * @param $schedule
     * @return string
     */
    private function restTitle($rest): string
    {
        return $rest->reason . '補休~' . substr($rest->end, 0, 5);
    }
}