<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use \App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\User')->create([
          'id' => 2,
          'username' => 'jsmith',
          'name' => 'John Smith',
          'password' => Hash::make('ccipassword'),
          'change_password' => false
        ]);

        DB::table('user_roles')->insert([
          'user_id' => 2,
          'role' => 'product-sales',
        ]);



        factory('App\User')->create([
          'id' => 3,
          'username' => 'esimmons',
          'name' => 'Ella Simmons',
          'password' => Hash::make('ccipassword'),
          'change_password' => false
        ]);

        DB::table('user_roles')->insert([
          'user_id' => 3,
          'role' => 'inside-sales'
        ]);



        factory('App\User')->create([
          'id' => 4,
          'username' => 'rharris',
          'name' => 'Richard Harris',
          'password' => Hash::make('ccipassword'),
          'change_password' => false
        ]);
    }
}
