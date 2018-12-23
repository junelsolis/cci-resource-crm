<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
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

    $this->session(['logged_in_user_id' => 27]);

    // create user
    $this->user = factory('App\User')->create([
      'id' => 27,
      'name' => 'Woodrow Wilson'
    ]);

    $this->project = factory('App\Project')->create([
      'product_sales_id' => session('logged_in_user_id'),
    ]);


  }

  /** @test */
  public function a_note_has_an_author() {

    $this->assertTrue($this->project->notes->first()->author()->first()->name == 'Woodrow Wilson');
  }

  /** @test */
  public function a_note_returns_formatted_date() {
    $note = $this->project->notes->last()->formattedDate();
    $year = Carbon::now()->format('Y');

    $this->assertTrue(str_contains($note,$year));

  }
}
