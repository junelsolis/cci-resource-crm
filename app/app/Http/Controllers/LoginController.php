<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Carbon\Carbon;

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

    public function changePassword(Request $request) {
      $request->validate([
        'currentPassword' => 'required|string',
      ]);

      $currentPassword = $request['currentPassword'];
      $newPassword = $request['newPassword'];
      $confirmNewPassword = $request['confirmNewPassword'];
      $user_id = session('logged_in_user_id');

      // confirm password matches DB;
      $password = DB::table('users')
        ->where('id', $user_id)
        ->pluck('password')
        ->first();

      if (Hash::check($currentPassword, $password)) {}
      else {
        return back()->with('change-password-error', 'Invalid password.');
      }

      $request->validate([
        'newPassword' => 'min:10|case_diff|numbers|letters|symbols',
        'confirmNewPassword' => 'required|string',
      ]);

      // check both passwords are the same
      if ($newPassword != $confirmNewPassword) {
        return back()->with('change-password-error', 'Passwords do not match.');
      }

      // set new password in DB
      DB::table('users')->where('id', $user_id)->update([
        'password' => Hash::make($newPassword),
        'updated_at' => Carbon::now()
      ]);

      return redirect(session('_previous')['url'])
        ->with('success', 'Password changed.');
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

        // // insert project status codes
        // DB::table('project_status')->insert([
        //   [ 'status' => 'New' ],
        //   [ 'status' => 'Quoted' ],
        //   [ 'status' => 'Sold' ],
        //   [ 'status' => 'Engineered' ],
        //   [ 'status' => 'Lost']
        // ]);

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

        // record last login data
        DB::table('users')->where('id', $user->id)->update([
          'last_login' => Carbon::now()
        ]);

        return true;
      }

      return false;
    }
}
