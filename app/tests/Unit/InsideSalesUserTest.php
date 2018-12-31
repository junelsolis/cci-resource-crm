<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\InsideSalesUser;
use Carbon\Carbon;
use App\Project;
use DB;


class InsideSalesUserTest extends TestCase
{

    use RefreshDatabase;

    protected $user;
    protected $productSales;

    public function setUp() {
      parent::setUp();

      $this->session(['logged_in_user_id' => 77]);

      $this->user = factory('App\InsideSalesUser')->create([
        'id' => 77,
        'name' => 'Samuel Langhorne Clemens'
      ]);

      $this->productSales = factory('App\ProductSalesUser')->create([
        'id' => 88,
      ]);

      // insert project statuses
      DB::table('project_status')->insert([
        ['id' => 1, 'status' => 'New'],
        ['id' => 2, 'status' => 'Quoted'],
        ['id' => 3, 'status' => 'Sold'],
        ['id' => 4, 'status' => 'Engineered'],
        ['id' => 5, 'status' => 'Lost']
      ]);
    }


    /** @test */
    public function a_user_has_projects_this_year() {

      // projects within this year
      factory('App\Project',30)->create([
        'bid_date' => Carbon::now()->subMonths(rand(0,11)),
        'inside_sales_id' => 77,
        'product_sales_id' => 88,
        // 'inside_sales_id' => $this->user->id
      ]);

      // projects more than a year old
      factory('App\Project',15)->create([
        'bid_date' => Carbon::now()->subMonths(rand(12,20)),
        'inside_sales_id' => 77,
        'product_sales_id' => 88,
        // 'inside_sales_id' => $this->user->id
      ]);

      $this->assertTrue($this->user->projectsThisYear()->count() == 30);
    }


    /** @test */
    public function a_user_has_upcomingProjects() {

      // new projects
      factory('App\Project', 15)->create([
        'inside_sales_id' => 77,
        'product_sales_id' => 88,
        'bid_date' => Carbon::now()->addMonths(rand(1,11)),
        'status_id' => 1
      ]);

      factory('App\Project', 10)->create([
        'inside_sales_id' => 77,
        'product_sales_id' => 88,
        'bid_date' => Carbon::now()->subDays(rand(1,60)),
        'status_id' => 1
      ]);

      // quoted
      factory('App\Project', 10)->create([
        'inside_sales_id' => 77,
        'product_sales_id' => 88,
        'bid_date' => Carbon::now()->subWeeks(rand(1,5)),
        'status_id' => 2
      ]);

      // engineered
      factory('App\Project', 5)->create([
        'inside_sales_id' => 77,
        'product_sales_id' => 88,
        'bid_date'  => Carbon::now()->addDays(rand(1,30)),
        'status_id' => 4
      ]);

      // sold
      factory('App\Project', 30)->create([
        'inside_sales_id' => 77,
        'product_sales_id' => 88,
        'bid_date' => Carbon::now()->addDays(rand(1,30)),
        'status_id' => 3
      ]);

      // lost
      factory('App\Project', 10)->create([
        'inside_sales_id' => 77,
        'product_sales_id' => 88,
        'bid_date' => Carbon::now()->addDays(rand(1,30)),
        'status_id' => 5
      ]);


      $this->assertTrue($this->user->upcomingProjects()->count() == 30);


    }


    /** @test */
    public function a_user_has_ongoing_projects() {
      factory('App\Project',10)->create([
        'inside_sales_id' => 77,
        'product_sales_id' => 88,
        'status_id' => 1,
        'bid_date' => Carbon::now()->addDays(rand(0,10))
      ]);

      factory('App\Project',15)->create([
        'inside_sales_id' => 77,
        'product_sales_id' => 88,
        'status_id' => 2,
        'bid_date' => Carbon::now()->addDays(rand(1,10))
      ]);

      factory('App\Project',10)->create([
        'inside_sales_id' => 77,
        'product_sales_id' => 88,
        'status_id' => 2,
        'bid_date' =>  Carbon::now()->subDays(rand(1,30))
      ]);

      factory('App\Project',20)->create([
        'inside_sales_id' => 77,
        'product_sales_id' => 88,
        'status_id' => 4,
        'bid_date' => Carbon::now()->addDays(rand(0,10))
      ]);

      factory('App\Project',15)->create([
        'inside_sales_id' => 77,
        'product_sales_id' => 88,
        'status_id' => 4,
        'bid_date' => Carbon::now()->subDays(rand(1,30))
      ]);

      $this->assertTrue($this->user->ongoingProjects()->count() == 70);
    }


    /** @test */
    public function a_user_has_details() {

      $this->assertTrue($this->user->userDetails()->get('name') == 'Samuel Langhorne Clemens');
      $this->assertTrue($this->user->userDetails()->get('role') == 'Inside Sales');
    }

}
