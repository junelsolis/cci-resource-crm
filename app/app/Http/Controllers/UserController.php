<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class UserController extends Controller
{
    public function addUser(Request $request) {}
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

}
