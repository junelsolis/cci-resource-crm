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
          'inside_sales_id' => 3,
          'bid_date' => new Carbon('next week'),
          'status_id' => 1
        ]);

        factory('App\Project', 4)->create([
          'product_sales_id' => 2,
          'inside_sales_id' => 3,
          'bid_date' => Carbon::now()->addDays(10),
          'status_id' => 2
        ]);

        factory('App\Project', 8)->create([
          'product_sales_id' => 2,
          'inside_sales_id' => 3,
          'bid_date' => Carbon::tomorrow()->addDays(3)
        ]);

        factory('App\Project', 15)->create([
          'product_sales_id' => 2,
          'inside_sales_id' => 3,
          'bid_date' => new Carbon('last month'),
          'status_id' => 3
        ]);

        factory('App\Project', 3)->create([
          'product_sales_id' => 2,
          'inside_sales_id' => 3,
          'bid_date' => Carbon::now()->subMonths(3),
          'status_id' => 5
        ]);
    }
}
