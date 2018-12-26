<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Http\Controllers\NoteController;

use DB;
use App\User;
use App\Project;
use App\ProjectNote;

class NoteControllerTest extends TestCase
{

    use RefreshDatabase;

    protected $controller;
    protected $user;
    protected $project;

    public function setUp() {
      parent::setUp();

      $this->controller = new NoteController;

      // add user
      $this->user = factory('App\User')->create(['id' => 25]);
      DB::table('user_roles')->insert(['user_id' => 25, 'role' => 'inside-sales']);

      $this->session(['logged_in_user_id' => 25]);

      // add project
      $this->project = factory('App\Project')->create(['inside_sales_id' => 25]);
    }

    /** @test */
    public function a_note_can_be_added() {



      // add note
      $response = $this->call('POST', 'NoteController@addNote',
        [
          'project_id' => $this->project->id,
          'note' => 'This is a new note.',
        ]
      );

      // get notes from database
      $note = ProjectNote::all()->count();

      // there must be one note in the database
      $this->assertTrue($note == 1);

    }


    /** @test */
    public function a_note_can_be_edited() {

      // add note
      factory('App\ProjectNote')->create([
        'project_id' => $this->project->id,
        'last_updated_by_id' => $this->user->id,
        'note' => 'Test note for editing.'
      ]);

      $note = $this->project->notes->last();

      // edit the note
      $response = $this->json('POST', '/note/edit/'.$note->id,
        ['value' => 'This is an edited note.',
          'pk' => $note->id
        ]
      );

      $edited = Project::find($this->project->id)->notes->last()->note;

      $response->assertStatus(200);
      $this->assertEquals('Note edited.', $response->getContent());

    }

    /** @test */
    public function check_only_certain_users_can_add_note() {

      $user = factory('App\User')->create(['id' => 5]);
      DB::table('user_roles')->insert(['user_id' => $user->id, 'role' => 'product-sales']);

      $this->session(['logged_in_user_id' => $user->id]);

      $project = factory('App\Project')->create([
        // 'id' => 333,
        'product_sales_id' => 10,
        'inside_sales_id' => 20,
      ]);

      //  product sales of project can add a note
      factory('App\User')->create(['id' => 10]);
      DB::table('user_roles')->insert(['user_id' => 10, 'role' => 'product-sales']);

      $this->session(['logged_in_user_id' => 10]);
      $this->assertTrue($project->canAddNote() == true);

      // product sales not assigned to project cannot edit
      factory('App\User')->create(['id' => 11]);
      DB::table('user_roles')->insert(['user_id' => 11, 'role' => 'product-sales']);

      $this->session(['logged_in_user_id' => 11]);
      $this->assertTrue($project->canAddNote() == false);


      //  inside sales can add a note */
      factory('App\User')->create(['id' => 21]);
      DB::table('user_roles')->insert(['user_id' => 21, 'role' => 'inside-sales']);
      $this->session(['logged_in_user_id' => 21]);
      $this->assertTrue($project->canAddNote() == true);


      // inside sales not assigned to project cannot add a note
      // factory('App\User')->create(['id' => 23]);
      // DB::table('user_roles')->insert(['user_id' => 23, 'role' => 'inside-sales']);
      // $this->session(['logged_in_user_id' => 23]);
      // $this->assertTrue($project->canAddNote() == false);

      //  exec can add a note
      $exec = factory('App\User')->create(['id' => 31]);
      DB::table('user_roles')->insert(['user_id' => $exec->id, 'role' => 'executive']);
      $this->session(['logged_in_user_id' => $exec->id]);
      $this->assertTrue($project->canAddNote() == true);

    }



    /** @test */
    // public function a_note_can_be_deleted() {}

    /** @test */


}
