<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Project;
use App\ProjectStatus;

class ProjectTest extends TestCase
{


    private $project;
    private $status;

    public function setUp() {
      parent::setUp();

      $this->project = factory(Project::class)->create();
      // $this->status = new ProjectStatus([
      //   // 'id' => 1,
      //   'status' => 'New'
      // ]);
      //
      // $this->status->save();


    }

    /** @test */
    public function a_project_has_a_status() {
      // given a project

      // when the projectStatus() function is called
      //$this->$project->status();

      // then it returns a project status object
      $this->assertSame('New', $this->project->status->status);



    }

    use RefreshDatabase;
}
