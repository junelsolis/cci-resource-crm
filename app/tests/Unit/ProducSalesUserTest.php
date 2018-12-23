<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


use App\ProductSalesUser;
use Carbon\Carbon;
use App\Project;
use DB;

class ProducSalesUserTest extends TestCase
{

    use RefreshDatabase;

    private $user;


    public function setUp() {
      parent::setUp();

      // create product sales user
      $this->user = factory('App\ProductSalesUser')->create([
        'id' => 22,
      ]);

      // create user role
      DB::table('user_roles')->insert([
        'user_id' => 22, 'role' => 'product_sales',
      ]);

      // insert project status
      DB::table('project_status')->insert([
        ['id' => 1, 'status' => 'New'],
        ['id' => 2, 'status' => 'Quoted'],
        ['id' => 3, 'status' => 'Sold'],
        ['id' => 4, 'status' => 'Engineered'],
        ['id' => 5, 'status' => 'Lost']
      ]);
    }

    /** @test */
    public function a_user_has_projects_for_this_year() {

      factory('App\Project', 55)->create([
        'product_sales_id' => 22,
        'bid_date' => Carbon::now()->subMonths(rand(0,11))
      ]);

      factory('App\Project', 10)->create([
        'product_sales_id' => 22,
        'bid_date' => Carbon::now()->addMonths(rand(0,6))
      ]);

      factory('App\Project', 60)->create([
        'product_sales_id' => 22,
        'bid_date' => Carbon::now()->subMonths(rand(13,20))
      ]);

      $this->assertTrue($this->user->projectsThisYear()->count() == 65);

    }

    /** @test */
    public function a_user_has_upcoming_projects() {

      // new projects
      factory('App\Project', 15)->create([
        'product_sales_id' => 22,
        'bid_date' => Carbon::now()->addMonths(rand(0,11)),
        'status_id' => 1
      ]);

      factory('App\Project', 10)->create([
        'product_sales_id' => 22,
        'bid_date' => Carbon::now()->subDays(rand(1,60)),
      ]);

      // quoted
      factory('App\Project', 10)->create([
        'product_sales_id' => 22,
        'bid_date' => Carbon::now()->subWeeks(rand(1,5)),
        'status_id' => 2
      ]);

      // engineered
      factory('App\Project', 5)->create([
        'product_sales_id' => 22,
        'bid_date'  => Carbon::now()->addDays(rand(1,30)),
        'status_id' => 4
      ]);

      // sold
      factory('App\Project', 30)->create([
        'product_sales_id' => 22,
        'bid_date' => Carbon::now()->addDays(rand(1,30)),
        'status_id' => 3
      ]);

      // lost
      factory('App\Project', 10)->create([
        'product_sales_id' => 22,
        'bid_date' => Carbon::now()->addDays(rand(1,30)),
        'status_id' => 5
      ]);


      $this->assertTrue($this->user->upcomingProjects()->count() == 30);

    }



}
