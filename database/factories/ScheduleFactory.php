<?php

use Faker\Generator as Faker;

$factory->define(App\Schedule::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'date' =>  $faker->date(),
        'action_type' => '',
        'action_id' => 1
    ];
});
