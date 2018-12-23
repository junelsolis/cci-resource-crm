<?php

use Faker\Generator as Faker;

$factory->define(App\ProductSalesUser::class, function (Faker $faker) {
    return [
        'username' => $faker->username,
        'name' => $faker->name,
        'password' => Hash::make($faker->password),
        'change_password' => true,
    ];
});
