<?php

use Faker\Generator as Faker;

$factory->define(App\Trip::class, function (Faker $faker) {
    return [
        'begin' => null,
        'end' => null,
        'location' => $faker->city,
        'hours' => 8
    ];
});
