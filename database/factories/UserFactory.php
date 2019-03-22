<?php

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$NunsMkH.IB87k4D/PDaaQO8czLulbhLK6NZych7eWPMFe4R0Ypvo2', // laravel
        'role' => 'user',
        'remember_token' => str_random(10),
    ];
});