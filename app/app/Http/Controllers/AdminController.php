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


      $userDetails = $this->getLoggedInUserDetails();
      $userDirectory = $this->getUserDirectory();
      $stats = $this->getStats();

      return view('administrator/main')
        ->with('userDetails', $userDetails)
        ->with('userDirectory', $userDirectory)
        ->with('stats', $stats);
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

      $password = $this->createUser($username, $name, $roles);

      return redirect('/administrator')
        ->with('success', 'User added. The temporary password is <strong>' . $password . '</strong>');
    }
    public function viewUser($id) {
      if ($this->checkLoggedIn()) {}
      else { return redirect('/'); }

      $userDetails = $this->getLoggedInUserDetails();
      $userDirectory = $this->getUserDirectory();
      $user = $this->getUserDetails($id);

      return view('administrator/user-edit')
        ->with('userDetails', $userDetails)
        ->with('userDirectory', $userDirectory)
        ->with('user', $user);
    }
    public function editUser($id, Request $request) {
      if ($this->checkLoggedIn()) {}
      else { return redirect('/'); }

      $request->validate([
        'username' => 'required|string',
        'name' => 'required|string',
        'roles' => 'required|array'
      ]);

      $username = $request['username'];
      $name = $request['name'];
      $roles = $request['roles'];

      $this->modifyUser($id, $username, $name, $roles);

      return redirect('/administrator/user/'.$id)
        ->with('success', 'Changes saved.');
    }
    public function resetPassword($id) {
      if ($this->checkLoggedIn()) {}
      else { return redirect('/'); }

      $password = $this->modifyUserPassword($id);

      return redirect('/administrator/user/'.$id)
        ->with('success', 'Password changed. The temporary password is <strong>' . $password . '</strong>');
    }


    private function checkLoggedIn() {
      if (session()->has('logged_in_user_id') && session('logged_in_user_roles')->contains('administrator')) {
        return true;
      }

      return false;
    }

    private function getLoggedInUserDetails() {
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

    private function createUser($username, $name, $roles) {
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

      return $password;
    }

    private function modifyUser($id, $username, $name, $roles) {
      $username = strtolower($username);

      // edit user in users table
      DB::table('users')->where('id', $id)->update([
        'username' => $username,
        'name' => $name,
        'updated_at' => \Carbon\Carbon::now()
      ]);

      // clear all role entries for user
      DB::table('user_roles')->where('user_id', $id)->delete();

      // create role entries for user
      foreach ($roles as $role) {
        DB::table('user_roles')->insert([
          'user_id' => $id,
          'role' => strtolower($role),
          'created_at' => \Carbon\Carbon::now()
        ]);
      }

      return;
    }

    private function modifyUserPassword($id) {
      /*  Modify the user password matching the id
      */

      $password = $this->randomPasswordString();

      DB::table('users')->where('id', $id)->update([
        'password' => Hash::make($password),
        'change_password' => true,
        'updated_at' => \Carbon\Carbon::now(),
      ]);

      return $password;
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
        $date = date('M d, Y', $date);

        $user->created_at = $date;
      }

      return $users;

    }

    private function getUserDetails($id) {
      $user = DB::table('users')->where('id', $id)
        ->select('id', 'username', 'name', 'created_at')
        ->first();

      $date = $user->created_at;
      $date = strtotime($date);
      $date = date('M d, Y', $date);

      $roles = DB::table('user_roles')->where('user_id', $id)->pluck('role');
      $user->roles = $roles;

      return $user;
    }

    private function getStats() {
      /*  calculates some statistics
          to be shown on the dashboard
      */

      $totalUsers = DB::table('users')->count();

      $stats = collect();

      $stats->totalUsers = $totalUsers;

      return $stats;
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
