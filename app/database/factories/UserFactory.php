<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
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
        'username' => $faker->username,
        'name' => $faker->name,
        'password' => Hash::make($faker->password),
        'change_password' => true,
        'created_at' => Carbon::now()
    ];
});
