<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'status_id' => 1,
        'bid_date' => Carbon::now(),
        'manufacturer' => $faker->company,
        'product' => 'product',
        'product_sales_id' => 3,
        'inside_sales_id' => 6,
        'amount' => 10000,
        'apc_opp_id' => rand(10000,99999),
        'invoice_link' => $faker->url,
        'engineer' => $faker->name,
        'contractor' => $faker->name,
        'created_at' => Carbon::now()
    ];
});
