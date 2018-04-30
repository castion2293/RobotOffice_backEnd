<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        //'App\Schedule' => 'App\Policies\UserIDCheckPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('checkDoubleWorkOnPresent', 'App\Policies\PresentPolicy@checkDoubleWorkOnPresent');
        Gate::define('checkNoWorkOn', 'App\Policies\PresentPolicy@checkNoWorkOn');
        Gate::define('checkDoubleWorkOffPresent', 'App\Policies\PresentPolicy@checkDoubleWorkOffPresent');
        Gate::define('checkOffPresentLaterThanOnPresent', 'App\Policies\PresentPolicy@checkOffPresentLaterThanOnPresent');

        Gate::define('checkHolidayHours', 'App\Policies\HolidayPolicy@checkHolidayHours');
        Gate::define('checkRestHours', 'App\Policies\HolidayPolicy@checkRestHours');
    }
}
