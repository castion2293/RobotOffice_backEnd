<?php

use Faker\Generator as Faker;

$factory->define(App\Holiday::class, function (Faker $faker) {
    return [
        'begin' => null,
        'end' => null,
        'hours' => 8
    ];
});
