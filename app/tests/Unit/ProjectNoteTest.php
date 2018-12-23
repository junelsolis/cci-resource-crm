<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\ProjectNote;
use App\Project;
use App\User;
use Carbon\Carbon;

class ProjectNoteTest extends TestCase
{


  use RefreshDatabase;

  protected $project;
  protected $user;

  public function setUp() {
    parent::setUp();


    // create user
    $this->user = factory('App\Project')->create([
      'id' => 27,
      'name' => 'Woodrow Wilson'
    ]);

    $this->withSession(['logged_in_user_id' => 27]);

    // create project
    // $this->project = factory('App\Project')->create([
    //   'product_sales_id' => session('logged_in_user_id'),
    //
    // ]);

  }

  /** @test */
  public function a_note_has_an_author() {


    // create project
    $project = factory('App\Project')->create([
      'product_sales_id' => session('logged_in_user_id'),
    ]);


    $this->assertTrue($project->notes->first()->author->name == 'Woodrow Wilson');
  }

  /** @test */
  public function a_note_returns_formatted_date() {
    $note = $this->project->notes()->last()->note;
    $year = Carbon::now()->format('Y');

    $this->assertTrue($note == $year);

  }
}
