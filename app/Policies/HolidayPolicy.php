<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HolidayPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function checkHolidayHours($user, $request)
    {
        return $request->hours > $user->holiday;
    }

    public function checkRestHours($user, $request)
    {
        return $request->hours > $user->rest;
    }
}
