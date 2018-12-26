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
use DB;

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

    DB::table('user_roles')->insert([
      'user_id' => 27,
      'role' => 'product-sales'
    ]);

    $this->project = factory('App\Project')->create([
      'id' => 100,
      'product_sales_id' => session('logged_in_user_id'),
      'inside_sales_id' => 33
    ]);


  }

  /** @test */
  public function a_note_has_an_author() {

    $this->assertTrue($this->project->notes->first()->author()->name == 'Woodrow Wilson');
  }

  /** @test */
  public function a_note_checks_if_user_is_editor() {

    // create a note
    factory('App\ProjectNote')->create([
      'project_id' => 100,
      'last_updated_by_id' => $this->user->id,
    ]);


    // product sales of project is an editor
    $isEditor = $this->project->notes->last()->isEditor();
    $this->assertTrue($isEditor == true);


    // other product sales person cannot be editor
    // if is not product sales for project
    $this->session(['logged_in_user_id' => 128]);

    $user = factory('App\User')->create([
      'id' => 128,
    ]);

    DB::table('user_roles')->insert([
      'user_id' => 128,
      'role' => 'product-sales'
    ]);

    $isEditor = $this->project->notes->last()->isEditor();
    $this->assertTrue($isEditor == false);

    // an inside sales person can only edit a note
    // if they are inside sales for a project
    $insideSales1 = factory('App\User')->create([
      'id' => 33,
    ]);

    DB::table('user_roles')->insert([ 'user_id' => 33, 'role' => 'inside-sales']);

    $this->session(['logged_in_user_id' => 33]);
    $isEditor = $this->project->notes->last()->isEditor();
    $this->assertTrue($isEditor == true);



    $this->session(['logged_in_user_id' => 44]);
    $insideSales2 = factory('App\User')->create([ 'id' => 44]);
    DB::table('user_roles')->insert(['user_id' => 44, 'role' => 'inside-sales' ]);

    $isEditor = $this->project->notes->last()->isEditor();
    $this->assertTrue($isEditor == false);



    // an executive may edit any note
    $this->session(['logged_in_user_id' => 55]);
    $execUser = factory('App\User')->create([ 'id' => 55]);
    DB::table('user_roles')->insert(['user_id' => 55, 'role' => 'executive']);

    $isEditor = $this->project->notes->last()->isEditor();
    $this->assertTrue($isEditor == true);

  }

  /** @test */
  public function a_note_returns_formatted_date() {
    $note = $this->project->notes->last()->formattedDate();
    $year = Carbon::now()->format('Y');

    $this->assertTrue(str_contains($note,$year));

  }


}
