<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Report::class, function (Faker $faker) {
    return [
        'title' => Str::random(10),
        'description' => Str::random(100),
        'created_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
        'group_title' => ['GroupA', 'GroupB'][rand(0, count(['GroupA', 'GroupB']) - 1)],
        'user_id' => '1'
    ];
});
