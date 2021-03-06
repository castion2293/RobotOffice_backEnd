<?php

Route::group([

    'prefix' => 'auth'

], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('schedule','ScheduleController');
    Route::get('holiday/type', 'TypeController@index');

    Route::post('reset/profile', 'UserController@resetUserProfile');
    Route::post('reset/password', 'UserController@resetUserPassword');
});


