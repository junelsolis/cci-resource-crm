<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

use App\Project;
use App\ProjectStatus;
use App\ProjectNote;
use App\User;
use Carbon\Carbon;

class ProjectTest extends TestCase
{

    //use DatabaseMigrations;
    use RefreshDatabase;

    private $project;
    private $status;
    private $productSalesUser;
    private $insideSalesUser;
    private $note;

    public function setUp() {
      parent::setUp();

      $this->productSalesUser = factory('App\User')->create([
        'id' => 3
      ]);

      $this->insideSalesUser = factory('App\User')->create([
        'id' => 5
      ]);

      $this->status = factory('App\ProjectStatus')->create();

      $this->project = factory('App\Project')->create([
        'status_id' => 1,
        'bid_date' => Carbon::now(),
        'product_sales_id' => $this->productSalesUser->id,
        'inside_sales_id' => $this->insideSalesUser->id,
      ]);

      $this->note = ProjectNote::create([
        'id' => 22,
        'project_id' => $this->project->id,
        'last_updated_by_id' => $this->productSalesUser->id,
        'note' => 'Project added. This is a note.',
      ]);




    }

    /** @test */
    public function a_project_has_a_status() {

      $this->assertSame('New', $this->project->status->status);
      $this->assertEquals($this->project->status->id, 1);
    }

    /** @test */
    public function a_project_has_product_sales() {
      $this->assertNotNull($this->project->productSales);
      $this->assertTrue(is_string($this->project->productSales->name));
    }

    /** @test */
    public function a_project_has_inside_sales() {

      $this->project->insideSales();

      $this->assertNotNull($this->project->insideSales);
      $this->assertTrue(is_string($this->project->insideSales->name));
    }

}
