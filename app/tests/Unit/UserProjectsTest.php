<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Project;
use Carbon\Carbon;
use DB;



class UserProjectTest extends TestCase
{

  use RefreshDatabase;

  private $user;


  public function setUp() {
    parent::setUp();

    // create project status
    DB::table('project_status')->insert([
      ['id' => 1, 'status' => 'New'],
      ['id' => 2, 'status' => 'Quoted'],
      ['id' => 3, 'status' => 'Sold'],
      ['id' => 4, 'status' => 'Engineered'],
      ['id' => 5, 'status' => 'Sold']
    ]);

    $this->user = factory('App\User')->create();

  }

  /** @test */
  public function a_user_has_product_sales_projects() {

    $projects = factory(Project::class, 25)->create([
      'product_sales_id' => $this->user->id,
    ]);

    $this->assertTrue($this->user->productSalesProjects()->count() == 25);
  }

  /** @test */
  public function a_user_has_inside_sales_projects() {

    $projects = factory(Project::class, 32)->create([
      'inside_sales_id' => $this->user->id,
    ]);

    $this->assertTrue($this->user->insideSalesProjects()->count() == 32);
  }

  /** @test */
  public function a_user_has_upcoming_projects() {

    $now = Carbon::now();
    $nextWeek = $now->addWeek();

    factory(Project::class, 5)->create([
      'product_sales_id' => $this->user->id,
      'bid_date' => $nextWeek,
    ]);

    $tomorrow = Carbon::tomorrow();

    factory(Project::class, 5)->create([
      'product_sales_id' => $this->user->id,
      'bid_date' => $tomorrow,
    ]);

    $this->assertTrue($this->user->upcomingProjects()->count() == 10);

  }

  /** @test */
  public function a_user_has_projects_this_year() {
    $time = Carbon::yesterday();
    $time->subYear();

    factory(Project::class, 5)->create([
      'product_sales_id' => $this->user->id,
      'bid_date' => $time
    ]);

    factory(Project::class, 7)->create([
      'product_sales_id' => $this->user->id,
      'bid_date' => Carbon::yesterday()
    ]);

    factory(Project::class, 3)->create([
      'product_sales_id' => $this->user->id,
      'bid_date' => new Carbon('last month')
    ]);


    $this->assertTrue($this->user->projectsLastYear()->count() == 10);

  }



}
