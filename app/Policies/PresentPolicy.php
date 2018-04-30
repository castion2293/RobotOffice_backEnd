<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class PresentPolicy
{
    use HandlesAuthorization;

    protected $user;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function checkDoubleWorkOnPresent($user, $request)
    {
        $schedule = $this->getSchedule($user, $request);

        if (!$schedule) {
            return false;
        }

        $present = $schedule->action()->first();

        if (!$present->begin) {
            return false;
        }

        return true;
    }

    public function checkNoWorkOn($user, $request)
    {
        $schedule = $this->getSchedule($user, $request);

        if (!$schedule) {
            return true;
        }

        $present = $schedule->action()->first();

        if (!$present->begin) {
            return true;
        }

        return false;
    }

    public function checkDoubleWorkOffPresent($user, $request)
    {
        $schedule = $this->getSchedule($user, $request);

        if (!$schedule) {
            return false;
        }

        $present = $schedule->action()->first();

        if (!$present->end) {
            return false;
        }

        return true;
    }

    public function checkOffPresentLaterThanOnPresent($user, $request)
    {
        $schedule = $this->getSchedule($user, $request);

        $present = $schedule->action()->first();

        if ($present->begin > $request->time) {
            return true;
        }

        return false;
    }

    private function getSchedule($user, $request)
    {
        return optional($user->schedules()->where('date', $request->date))->first();
    }
}
