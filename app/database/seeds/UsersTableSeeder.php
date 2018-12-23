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

        /*    Product sales user IDs: 21 - 40
              Inside Sales User IDs: 51-60
        */


        // create main product sales user
        factory('App\User')->create([
          'id' => 2,
          'username' => 'jsmith',
          'name' => 'John Smith',
          'password' => Hash::make('ccipassword'),
        ]);

        DB::table('user_roles')->insert([
          'user_id' => 2,
          'role' => 'product-sales',
        ]);


        // create other product sales users
        $index = 21;
        while ($index <= 40) {


          factory('App\User')->create([
            'id' => $index,
          ]);

          DB::table('user_roles')->insert([
            'user_id' => $index,
            'role' => 'product-sales'
          ]);

          $index++;

        }


        // main inside sales user
        factory('App\User')->create([
          'id' => 3,
          'username' => 'esimmons',
          'name' => 'Ella Simmons',
          'password' => Hash::make('ccipassword'),
        ]);

        DB::table('user_roles')->insert([
          'user_id' => 3,
          'role' => 'inside-sales'
        ]);


        // create other inside sales users
        $index = 51;
        while ($index <= 60) {

          factory('App\User')->create([
            'id' => $index,
          ]);

          DB::table('user_roles')->insert([
            'user_id' => $index,
            'role' => 'inside-sales'
          ]);

          $index++;

        }



        factory('App\User')->create([
          'id' => 4,
          'username' => 'rharris',
          'name' => 'Richard Harris',
          'password' => Hash::make('ccipassword'),
        ]);
    }
}
