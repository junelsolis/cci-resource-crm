<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\User;
use App\Project;
use DB;

class UserTest extends TestCase
{

    use RefreshDatabase;


    private $user;
    private $project1;
    private $project2;

    public function setUp() {
      parent::setUp();

      // create user
      $this->user = factory('App\User')->create([
        'id' => 3,
        'password' => Hash::make('thisIsThePassword1234'),
      ]);

      // insert roles
      DB::table('user_roles')->insert([
        ['user_id' => $this->user->id, 'role' => 'product-sales'],
        ['user_id' => $this->user->id, 'role' => 'executive'],
      ]);

      // create project 1
      $this->project1 = factory('App\Project')->create([
        'product_sales_id' => 3,
        'inside_sales_id' => 5,
        'bid_date' => Carbon::now()
      ]);

      // create proejct 2
      $this->project2 = factory('App\Project')->create([
        'product_sales_id' => 5,
        'inside_sales_id' => 3,
        'bid_date' => Carbon::now()
      ]);

    }

    /** @test */
    public function a_user_has_roles() {

      $this->assertCount(2,$this->user->roles());
      $this->assertTrue(in_array('product-sales', $this->user->roles()));
      $this->assertTrue(in_array('executive', $this->user->roles()));

    }


}
