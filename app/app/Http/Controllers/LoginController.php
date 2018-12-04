<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;

class LoginController extends Controller
{
    public function showLogin() {

      $this->checkFirstLogin();         // check if this is the first login
      return view('login');
    }


    private function checkFirstLogin() {
      /*  Check for presence of users in users table
          If there are no users, create default admin user
      */

      $count = DB::table('users')->count();

      if ($count == 0) {

        $password = Hash::make('cciadminpassword');

        // insert in users table
        $id = DB::table('users')->insertGetId([
          'username' => 'admin',
          'name' => 'Administrator',
          'password' => $password,
          'created_at' => \Carbon\Carbon::now()
        ]);

        // insert in roles table
        DB::table('user_roles')->insert([
          'user_id' => $id,
          'role' => 'administrator',
          'created_at' => \Carbon\Carbon::now()
        ]);

        return;
      }

      else { return; }
    }
}
