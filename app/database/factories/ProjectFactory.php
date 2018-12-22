<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'status_id' => 1,
        'bid_date' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = '+6 months', $timezone = null),
        'manufacturer' => $faker->company,
        'product' => 'product',
        'product_sales_id' => rand(1,120),
        'inside_sales_id' => rand(1,120),
        'amount' => rand(6000,100000),
        'apc_opp_id' => rand(10000,99999),
        'invoice_link' => $faker->url,
        'engineer' => $faker->name,
        'contractor' => $faker->name,
        'created_at' => Carbon::now()
    ];
});
