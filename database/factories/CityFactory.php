<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Dashboard\City;
use Faker\Generator as Faker;

$factory->define(City::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
        'is_active' => $faker->randomElement(array('0', '1')),
    ];
});
