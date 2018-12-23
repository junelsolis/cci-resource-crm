<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Project;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        factory('App\Project', 5)->create([
          'product_sales_id' => 2,
          // 'inside_sales_id' => 3,
          // 'bid_date' => Carbon::now()->addWeeks(rand(1,15)),
          'status_id' => 1
        ]);

        factory('App\Project', 15)->create([
          'product_sales_id' => 2,
          // 'inside_sales_id' => 3,
          // 'bid_date' => Carbon::now()->addMonths(rand(0,6)),
          'status_id' => 2
        ]);

        factory('App\Project', 8)->create([
          'product_sales_id' => 2,
          // 'inside_sales_id' => 3,
          // 'bid_date' => Carbon::tomorrow()->addWeeks(rand(1,5)),
          'status_id' => 4
        ]);

        factory('App\Project', 65)->create([
          'product_sales_id' => 2,
          // 'inside_sales_id' => 3,
          // 'bid_date' => Carbon::now()->subMonths(rand(0,11)),
          'status_id' => 3
        ]);

        factory('App\Project', 3)->create([
          'product_sales_id' => 2,
          // 'inside_sales_id' => 3,
          // 'bid_date' => Carbon::now()->subMonths(rand(0,11)),
          'status_id' => 5
        ]);



        // create random projects for random product sales and random inside sales

        factory('App\Project', 700)->create();
    }
}
