<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use DB;
use Hash;

class UserController extends Controller
{
    public function add(Request $request) {
      $check = $this->checkAllowed();
      if ($check == false) {
        return response('Error 2700',404);
      }

      $request->validate([
        'name' => 'required|string',
        'roles' => 'required|array'
      ]);

      $name = $request['name'];
      $roles = $request['roles'];

      // create username string
      $array = explode(" ", strtolower($name));
      $firstInitial = substr($array[0],0,1);
      $lastname = $array[1];
      $username = $firstInitial . $lastname;

      // random password string
      $password = $this->randomPasswordString();

      // create user
      $user = new User;
      $user->name = $name;
      $user->username = $username;
      $user->password = Hash::make($password);

      $user->save();

      $user = $user->fresh();

      // just in case, remove all role entries containing ID
      DB::table('user_roles')->where('user_id', $user->id)->delete();

      // create role entries
      foreach ($roles as $i) {
        DB::table('user_roles')->insert([
          'user_id' => $user->id,
          'role' => $i
        ]);
      }

      return redirect()->back()->with('success', 'Username <strong>' . $user->username . '</strong> added. The temporary password is <strong>' . $password . '</strong>');


    }
    public function editName(Request $request) {
      $check = $this->checkAllowed();
      if ($check == false) {
        return response('Error 2700',404);
      }

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      // update DB
      DB::table('users')->where('id', $id)->update([
        'name' => $value,
        'updated_at' => Carbon::now()
      ]);
    }
    public function editUsername(Request $request) {
      $check = $this->checkAllowed();
      if ($check ==false) {
        return response('Error 2700',404);
      }

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      // update username
      DB::table('users')->where('id', $id)->update([
        'username' => $value,
        'updated_at' => Carbon::now()
      ]);

    }
    public function editRoles(Request $request) {
      $check = $this->checkAllowed();
      if ($check ==false) {
        return response('Error 2700',404);
      }

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      if (empty($value)) {
        return response('Must select one.',404);
      }

      // delete all roles for id
      DB::table('user_roles')->where('user_id', $id)->delete();

      // insert new user roles
      foreach ($value as $role){
        DB::table('user_roles')->insert([
          'user_id' => $id,
          'role' => $role,
          'created_at' => Carbon::now()
        ]);
      }
    }
    public function resetPassword(Request $request) {
      $check = $this->checkAllowed();
      if ($check == false) {
        return response('Error 2700',404);
      }

      // retrieve user
      $user = User::find($request['id']);

      // generate new password
      $password = $this->randomPasswordString();

      $user->password = Hash::make($password);
      $user->save();

      return redirect()->back()->with('success', 'The password of user <strong>' . $user->name . '</strong> has been reset. The new password is <strong>' . $password . '</strong>');


    }
    public function delete(Request $request) {
      $check = $this->checkAllowed();
      if ($check == false) {
        return response('Error 2700',404);
      }

      $id = $request['id'];

      // retrieve user
      $user = User::find($id);

      // delete all project notes belonging to user
      DB::table('project_notes')->where('last_updated_by_id', $user->id)->delete();

      // delete all projects where user is product sales
      $ids = DB::table('projects')->where('product_sales_id', $user->id)->pluck('id');

        // delete related notes
        DB::table('project_notes')->whereIn('project_id', $ids)->delete();

        // delete the projects
        DB::table('projects')->whereIn('id', $ids)->delete();

      // delete all projects where user is inside sales
      $ids = DB::table('projects')->where('inside_sales_id', $user->id)->pluck('id');

        // delete related notes
        DB::table('project_notes')->whereIn('project_id', $ids)->delete();

        // delete the projects
        DB::table('projects')->whereIn('id', $ids)->delete();


      // delete user roles
      DB::table('user_roles')->where('user_id', $user->id)->delete();

      // finally, delete the user from the db
      $user->delete();

      return redirect()->back()->with('success', 'User <strong>' . $user->name . '</strong> has been deleted.');

    }


    private function checkAllowed() {
      /*  check if the user is an administrator */

      // check if user is logged in, else flush and return false
      if (session()->has('logged_in_user_id')) {
      } else {
        session()->flush();
        return false;
      }

      // check if user is an administrator
      $logged_in_user_roles = session('logged_in_user_roles');
      if ($logged_in_user_roles->contains('administrator')) {
        return true;
      }

      session()->flush();
      return false;

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
