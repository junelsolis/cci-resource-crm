<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\ProjectController;


use DB;
use App\User;
use App\Project;

class ProjectControllerTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    protected $productSales;
    protected $insideSales;
    protected $exec;
    protected $controller;

    public function setUp() {
      parent::setUp();

      $this->controller = new ProjectController;

      // product sales user
      $this->productSales = factory('App\User')->create();
      DB::table('user_roles')->insert([
        'user_id' => $this->productSales->id,
        'role' => 'product-sales',
      ]);

      // inside sales user
      $this->insideSales = factory('App\User')->create();
      DB::table('user_roles')->insert([
        'user_id' => $this->insideSales->id,
        'role' => 'inside-sales',
      ]);

      // exec user
      $this->exec = factory('App\User')->create();
      DB::table('user_roles')->insert([
        'user_id' => $this->exec->id,
        'role' => 'executive',
      ]);


    }


    /** @test */
    public function can_add_project() {

      // product sales can add a project
      $this->session(['logged_in_user_id' => $this->productSales->id]);

      $response = $this->json('POST', '/project/add', [
        'name' => 'Product Sales Project',
        'status_id' => rand(1,5),
        'bid_date' => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = '+6 months', $timezone = null),
        'manufacturer' => $this->faker->company,
        'product' => $this->faker->word,
        'product_sales_id' => $this->productSales->id,
        'inside_sales_id' => rand(51,60),
        'amount' => rand(6000,100000),
        'apc_opp_id' => rand(10000,99999),
        'invoice_link' => $this->faker->url,
        'engineer' => $this->faker->name,
        'contractor' => $this->faker->name,
      ]);

      $response->assertStatus(200);

    }


    /** @test */
    public function can_editName() {

    }

    /** @test */
    public function can_edit_status() {}

    /** @test */
    public function can_edit_manufacturer() {}

    /** @test */
    public function can_edit_product() {}

    /** @test */
    public function can_edit_product_sales() {}

    /** @test */
    public function can_edit_inside_sales() {}

    /** @test */
    public function can_edit_amount() {}

    /** @test */
    public function can_edit_apcOppId() {}

    /** @test */
    public function can_edit_invoice_link() {}

    /** @test */
    public function can_edit_engineer() {}

    /** @test */
    public function can_edit_contractor() {}
}
