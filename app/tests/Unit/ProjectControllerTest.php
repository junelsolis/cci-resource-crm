<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Response;


use DB;
use App\User;
use App\Project;
use App\ProjectNote;
use Carbon\Carbon;

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

      // $this->withoutExceptionHandling();

      $this->controller = new ProjectController;

      // product sales user
      $this->productSales = factory('App\User')->create(['id' => 10 ]);
      DB::table('user_roles')->insert([
        'user_id' => $this->productSales->id,
        'role' => 'product-sales',
      ]);

      // inside sales user
      $this->insideSales = factory('App\User')->create(['id' => 20]);
      DB::table('user_roles')->insert([
        'user_id' => $this->insideSales->id,
        'role' => 'inside-sales',
      ]);

      // exec user
      $this->exec = factory('App\User')->create(['id' => 30]);
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
        'status_id' => 3,
        'bid_date' => Carbon::now()->format('Y-m-d'),
        'manufacturer' => $this->faker->company,
        'product' => $this->faker->word,
        'product_sales_id' => $this->productSales->id,
        'inside_sales_id' => $this->insideSales->id,
        'amount' => rand(6000,100000),
        'apc_opp_id' => rand(10000,99999),
        'invoice_link' => $this->faker->url,
        'engineer' => $this->faker->name,
        'contractor' => $this->faker->name,
        'note' => $this->faker->text($maxNbChars = 200)
      ]);


      $this->assertTrue(Project::all()->count() == 1);
      $this->assertTrue(ProjectNote::all()->count() == 2);

    }


    /** @test */
    public function can_edit_name() {

      // product sales can edit name
      $this->session(['logged_in_user_id' => $this->productSales->id]);

      $project = factory('App\Project')->create([
        'id' => 27,
        'name' => 'original',
        'product_sales_id' => $this->productSales->id
      ]);

      $response = $this->json('POST', '/project/edit/name', [
        'pk' => $project->id,
        'value' => 'changed',
        'name' => 'name'
      ]);

      $response->assertStatus(200);
      $this->assertTrue(Project::find(27)->name == 'changed');

      $this->assertTrue(Project::find(27)->notes->count() == 2);
      $this->assertTrue(Project::find(27)->notes->last()->note == 'Project name changed.');
    }

    /** @test */
    public function can_edit_status() {

      // product sales can edit name
      $this->session(['logged_in_user_id' => $this->productSales->id]);

      $project = factory('App\Project')->create([
        'id' => 27,
        'status_id' => 1,
        'product_sales_id' => $this->productSales->id
      ]);

      $response = $this->json('POST', '/project/edit/status', [
        'pk' => $project->id,
        'value' => 5,
        'name' => 'status'
      ]);

      $response->assertStatus(200);
      $this->assertTrue(Project::find(27)->status_id == 5);

      $this->assertTrue(Project::find(27)->notes->count() == 2);
      $this->assertTrue(Project::find(27)->notes->last()->note == 'Status changed.');
    }

    /** @test */
     public function can_edit_bid_date() {

       // product sales can edit name
       $this->session(['logged_in_user_id' => $this->productSales->id]);

       $project = factory('App\Project')->create([
         'id' => 27,
         'status_id' => 1,
         'product_sales_id' => $this->productSales->id
       ]);

       $response = $this->json('POST', '/project/edit/bid-date', [
         'pk' => $project->id,
         'value' => Carbon::now()->format('Y-m-d')
       ]);

       $response->assertStatus(200);

       $this->assertTrue(Project::find(27)->notes->count() == 2);
       $this->assertTrue(Project::find(27)->notes->last()->note == 'Bid date changed.');
     }


    /** @test */
    public function can_edit_manufacturer() {

      // product sales can edit name
      $this->session(['logged_in_user_id' => $this->productSales->id]);

      $project = factory('App\Project')->create([
        'id' => 27,
        'product_sales_id' => $this->productSales->id
      ]);

      $response = $this->json('POST', '/project/edit/manufacturer', [
        'pk' => $project->id,
        'value' => 'changed',
        'name' => 'manufacturer'
      ]);

      $response->assertStatus(200);
      $this->assertTrue(Project::find(27)->manufacturer == 'changed');

      $this->assertTrue(Project::find(27)->notes->count() == 2);
      $this->assertTrue(Project::find(27)->notes->last()->note == 'Manufacturer changed.');

    }

    /** @test */
    public function can_edit_product() {

      // product sales can edit name
      $this->session(['logged_in_user_id' => $this->productSales->id]);

      $project = factory('App\Project')->create([
        'id' => 27,
        'product_sales_id' => $this->productSales->id
      ]);

      $response = $this->json('POST', '/project/edit/product', [
        'pk' => $project->id,
        'value' => 'changed',
        'name' => 'product'
      ]);

      $response->assertStatus(200);
      $this->assertTrue(Project::find(27)->product == 'changed');

      $this->assertTrue(Project::find(27)->notes->count() == 2);
      $this->assertTrue(Project::find(27)->notes->last()->note == 'Product changed.');

    }

    /** @test */
    public function can_edit_product_sales() {
      // product sales can edit name
      $this->session(['logged_in_user_id' => $this->productSales->id]);

      $project = factory('App\Project')->create([
        'id' => 27,
        'product_sales_id' => $this->productSales->id
      ]);

      $response = $this->json('POST', '/project/edit/product-sales', [
        'pk' => $project->id,
        'value' => 32,
      ]);

      $response->assertStatus(200);
      $this->assertTrue(Project::find(27)->product_sales_id == 32);

      $this->assertTrue(Project::find(27)->notes->count() == 2);
      $this->assertTrue(Project::find(27)->notes->last()->note == 'Product Sales Rep changed.');
    }

    /** @test */
    public function can_edit_inside_sales() {

      // product sales can edit name
      $this->session(['logged_in_user_id' => $this->productSales->id]);

      $project = factory('App\Project')->create([
        'id' => 27,
        'product_sales_id' => $this->productSales->id
      ]);

      $response = $this->json('POST', '/project/edit/inside-sales', [
        'pk' => $project->id,
        'value' => 32,
      ]);

      $response->assertStatus(200);
      $this->assertTrue(Project::find(27)->inside_sales_id == 32);

      $this->assertTrue(Project::find(27)->notes->count() == 2);
      $this->assertTrue(Project::find(27)->notes->last()->note == 'Inside Sales Rep changed.');

    }

    /** @test */
    public function can_edit_amount() {
      // product sales can edit name
      $this->session(['logged_in_user_id' => $this->productSales->id]);

      $project = factory('App\Project')->create([
        'id' => 27,
        'product_sales_id' => $this->productSales->id
      ]);

      $response = $this->json('POST', '/project/edit/amount', [
        'pk' => $project->id,
        'value' => 25000,
      ]);

      $response->assertStatus(200);
      $this->assertTrue(Project::find(27)->amount == 25000);

      $this->assertTrue(Project::find(27)->notes->count() == 2);
      $this->assertTrue(Project::find(27)->notes->last()->note == 'Amount changed.');
    }

    /** @test */
    public function can_edit_apcOppId() {

      // product sales can edit name
      $this->session(['logged_in_user_id' => $this->productSales->id]);

      $project = factory('App\Project')->create([
        'id' => 27,
        'product_sales_id' => $this->productSales->id
      ]);

      $response = $this->json('POST', '/project/edit/apc-opp-id', [
        'pk' => $project->id,
        'value' => 29999,
      ]);

      $response->assertStatus(200);
      $this->assertTrue(Project::find(27)->apc_opp_id == 29999);


      $this->assertTrue(Project::find(27)->notes->count() == 2);
      $this->assertTrue(Project::find(27)->notes->last()->note == 'APC OPP ID changed.');
    }

    /** @test */
    public function can_edit_invoice_link() {

      // product sales can edit name
      $this->session(['logged_in_user_id' => $this->productSales->id]);

      $project = factory('App\Project')->create([
        'id' => 27,
        'product_sales_id' => $this->productSales->id
      ]);

      $response = $this->json('POST', '/project/edit/quote', [
        'pk' => $project->id,
        'value' => 'http://www.example.com',
      ]);

      $response->assertStatus(200);
      $this->assertTrue(Project::find(27)->invoice_link == 'http://www.example.com');

      $this->assertTrue(Project::find(27)->notes->count() == 2);
      $this->assertTrue(Project::find(27)->notes->last()->note == 'Quote link changed.');

    }

    /** @test */
    public function can_edit_engineer() {

      // product sales can edit name
      $this->session(['logged_in_user_id' => $this->productSales->id]);

      $project = factory('App\Project')->create([
        'id' => 27,
        'product_sales_id' => $this->productSales->id
      ]);

      $response = $this->json('POST', '/project/edit/engineer', [
        'pk' => $project->id,
        'value' => 'Daffy Duck',
      ]);

      $response->assertStatus(200);
      $this->assertTrue(Project::find(27)->engineer == 'Daffy Duck');

      $this->assertTrue(Project::find(27)->notes->count() == 2);
      $this->assertTrue(Project::find(27)->notes->last()->note == 'Engineer changed.');
    }

    /** @test */
    public function can_edit_contractor() {

      // product sales can edit name
      $this->session(['logged_in_user_id' => $this->productSales->id]);

      $project = factory('App\Project')->create([
        'id' => 27,
        'product_sales_id' => $this->productSales->id
      ]);

      $response = $this->json('POST', '/project/edit/contractor', [
        'pk' => $project->id,
        'value' => 'Donald Duck',
      ]);

      $response->assertStatus(200);
      $this->assertTrue(Project::find(27)->contractor == 'Donald Duck');

      $this->assertTrue(Project::find(27)->notes->count() == 2);
      $this->assertTrue(Project::find(27)->notes->last()->note == 'Contractor changed.');

    }
}
