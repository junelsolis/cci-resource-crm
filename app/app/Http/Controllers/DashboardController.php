<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function selectUserRole() {

      $logged_in_user_id = session('logged_in_user_id');
      $change_password = DB::table('users')->where('id', $logged_in_user_id)->pluck('change_password')->first();

      if ($change_password == true) {
        return redirect('/dashboard/set-password');
      }




      $user_roles = session()->get('logged_in_user_roles');     // get user roles array stored in session

      if ($user_roles->contains('sales')) {
        return redirect('/sales');
      }

      if ($user_roles->contains('service')) {
        return redirect('/service');
      }

      if ($user_roles->contains('executive')) {
        return redirect('/executive');
      }

      if ($user_roles->contains('administrator')) {
        return redirect('/administrator');
      }

      return redirect('/');

    }

    public function showSetPassword() {
      $user_id = session('logged_in_user_id');
      $name = DB::table('users')->where('id', $user_id)->pluck('name')->first();

      return view('set-password')->with('name', $name);
    }

    public function setPassword(Request $request) {

    }
}
