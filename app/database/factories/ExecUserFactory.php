<?php

use Faker\Generator as Faker;

$factory->define(App\ExecUser::class, function (Faker $faker) {
    return [
        'id' => rand(71,80),
        'username' => $faker->username,
        'name' => $faker->name,
        'password' => Hash::make($faker->password),
        'change_password' => true,
    ];
});
