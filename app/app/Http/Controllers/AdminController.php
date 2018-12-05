<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;

class AdminController extends Controller
{
    public function showDashboard() {
      if ($this->checkLoggedIn()) {}
      else { return redirect('/'); }


      $userDetails = $this->getUserDetails();
      $userDirectory = $this->getUserDirectory();

      return view('administrator/main')
        ->with('userDetails', $userDetails)
        ->with('userDirectory', $userDirectory);
    }


    public function addUser(Request $request) {
      if ($this->checkLoggedIn()) {}
      else { return redirect('/'); }

      /*  Add a user, set its roles,
          generate initial password,
          set change password on next login
      */

      $request->validate([
        'username' => 'required|string',
        'name' => 'required|string',
        'roles' => 'required|array'
      ]);

      $username = $request['username'];
      $name = $request['name'];
      $roles = $request['roles'];

      $username = strtolower($username);
      $password = $this->randomPasswordString();

      // create user in user table
      $user_id = DB::table('users')->insertGetId([
        'username' => $username,
        'name' => $name,
        'password' => Hash::make($password),
        'change_password' => true,
        'created_at' => \Carbon\Carbon::now()
      ]);

      // create role entries for user
      foreach ($roles as $role) {
        DB::table('user_roles')->insert([
          'user_id' => $user_id,
          'role' => strtolower($role),
          'created_at' => \Carbon\Carbon::now()
        ]);
      }

      return redirect('/admin')
        ->with('success', 'User added. The temporary password is <strong>' . $password . '</strong>');
    }


    private function checkLoggedIn() {
      if (session()->has('logged_in_user_id') && session('logged_in_user_roles')->contains('administrator')) {
        return true;
      }

      return false;
    }
    private function getUserDetails() {
      /*  returns the user's full name
          and role
      */

      $user_id = session()->get('logged_in_user_id');     // get user id from session
      $name = DB::table('users')->where('id', $user_id)->pluck('name')->first();

      $role = 'System Administrator';

      $collect = collect([
        'name' => $name,
        'role' => $role
      ]);

      return $collect;
    }
    private function getUserDirectory() {
      /*  Return a collection containing data for all users
          to show in the user directory
      */

      $currentUserId = session('logged_in_user_id');

      $users = DB::table('users')
        ->select('id', 'username', 'name', 'created_at')
        ->orderBy('name')
        ->where('id', '!=', $currentUserId)
        ->get();

      foreach ($users as $user) {
        $date = $user->created_at;
        $date = strtotime($date);
        $date = date('M d, Y');

        $user->created_at = $date;
      }

      return $users;

    }
    private function randomPasswordString($length = 8) {
  	  $str = "";
    	$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
    	$max = count($characters) - 1;
    	for ($i = 0; $i < $length; $i++) {
    		$rand = mt_rand(0, $max);
    		$str .= $characters[$rand];
    	}
    	return $str;
    }

}
