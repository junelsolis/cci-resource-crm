<?php

use Faker\Generator as Faker;

$factory->define(App\InsideSalesUser::class, function (Faker $faker) {
    return [
      'id' => rand(51,60),
      'username' => $faker->username,
      'name' => $faker->name,
      'password' => Hash::make($faker->password),
      'change_password' => true,
    ];
});
