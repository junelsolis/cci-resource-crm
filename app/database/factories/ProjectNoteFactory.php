<?php

use Faker\Generator as Faker;

$factory->define(App\ProjectNote::class, function (Faker $faker) {
    return [
      'last_updated_by_id' => session('logged_in_user_id')
    ];
});
