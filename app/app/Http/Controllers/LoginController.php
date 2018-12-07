<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;

class LoginController extends Controller
{
    public function showLogin() {

      $this->checkFirstLogin();         // check if this is the first login

      $alreadyLoggedIn = $this->checkAlreadyLoggedIn();
      if ($alreadyLoggedIn == true) {
        return redirect('/dashboard');
      }
      return view('login');
    }

    public function login(Request $request) {
      /*  Process user-entered credentials for login
      */

      $request->validate([
        'username' => 'required',
        'password' => 'required'
      ]);

      $username = $request['username'];   // store from request
      $password = $request['password'];   // store from request

      $check = $this->checkUserPassword($username, $password);    // check user credentials
      if ($check == false) {
        return back()->with('error', 'error');
      }

      return redirect('/dashboard');

    }

    public function logout() {
      session()->flush();
      return redirect('/');
    }


    private function checkFirstLogin() {
      /*  Check for presence of users in users table
          If there are no users:
            -- create default admin user
            -- setup project status codes
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

        // insert project status codes
        DB::table('project_status')->insert([
          [ 'status' => 'New' ],
          [ 'status' => 'Quoted' ],
          [ 'status' => 'Sold' ],
          [ 'status' => 'Engineered' ],
          [ 'status' => 'Lost']
        ]);

        return;
      }

      else { return; }
    }
    private function checkAlreadyLoggedIn() {
      if (session()->has('logged_in_user_id') && session()->has('logged_in_user_roles')) {
        return true;
      }

      return false;

    }
    private function checkUserPassword($username, $password) {

      /* verify existence of username and compare entered password */
      $user = DB::table('users')->where('username', $username)->first();

      if (empty($user)) {
        return false;
      }

      if (Hash::check($password, $user->password)) {

        $user_roles = DB::table('user_roles')->where('user_id', $user->id)->pluck('role');             // retrive user roles

        session([ 'logged_in_user_id' => $user->id ]);      // store user id in session variable
        session([ 'logged_in_user_roles' => $user_roles ]);       // store user roles in session variable
        session([ 'logged_in_name' => $user->name ]);       // store user name in session variable

        return true;
      }

      return false;
    }
}
