<?php

use Faker\Generator as Faker;

$factory->define(App\ProjectStatus::class, function (Faker $faker) {
    return [
        'id' => 1,
        'status' => 'New'
    ];
});
