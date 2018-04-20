<?php

use Faker\Generator as Faker;

$factory->define(App\Present::class, function (Faker $faker) {
    return [
        'begin' => null,
        'end' => null
    ];
});
