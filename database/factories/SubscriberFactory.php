<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Subscriber;
use Faker\Generator as Faker;

$factory->define(Subscriber::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'status' => 'active'
    ];
});
