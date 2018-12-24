<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\ExecUser;
use Carbon\Carbon;
use DB;

class ExecUserTest extends TestCase
{

    use RefreshDatabase;

    protected $user;

    public function setUp() {
      parent::setUp();

      $this->user = factory('App\ExecUser')->create([
        'id' => 31,
        'name' => 'John Quincy Adams',
      ]);

      // DB::table('user_roles')->insert([
      //   'user_id' => 31,
      //   'role' => 'executive',
      // ]);
    }

    /** @test */
    public function a_user_has_details() {

      // $this->assertTrue($this->user->details()->get('name') == 'John Quincy Adams');
      $this->assertTrue($this->user->details()->get('role') == 'Executive');
    }

    /** @test */
}
