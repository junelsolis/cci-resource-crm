<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Project;
use App\ProjectStatus;
use App\ProjectNote;
use App\User;
use App\Note;

class ProjectTest extends TestCase
{

    use DatabaseMigrations;
    use RefreshDatabase;

    private $project;
    private $status;
    private $productSalesUser;
    private $insideSalesUser;
    private $note;

    public function setUp() {
      parent::setUp();
      // $this->runDatabaseMigrations();;

      $this->project = factory(Project::class)->create();

      $this->status = new ProjectStatus([
        // 'id' => 1,
        'status' => 'New',
      ]);
      $this->status->save();

      $this->productSalesUser = factory('App\User')->create();

      $this->insideSalesUser = factory('App\User')->create();

      $this->note =  new ProjectNote([
        'project_id' => $this->project->id,
        'last_updated_by_id' => $this->productSalesUser->id,
        'note' => 'Project added',
      ]);

    }

    /** @test */
    public function a_project_has_a_status() {

      $this->assertSame('New', $this->project->status->status);

    }

    /** @test */
    public function a_project_has_product_sales() {
      $this->assertNotNull($this->project->productSales);
    }

    /** @test */
    public function a_project_has_inside_sales() {
      $this->assertNotNull($this->project->insideSales);
    }

}
