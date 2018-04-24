<?php

use Faker\Generator as Faker;

$factory->define(App\Rest::class, function (Faker $faker) {
    return [
        'begin' => null,
        'end' => null,
        'reason' => $faker->city,
        'hours' => 8
    ];
});
