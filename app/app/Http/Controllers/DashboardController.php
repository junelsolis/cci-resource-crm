<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;

class DashboardController extends Controller
{
    public function selectUserRole() {

      $logged_in_user_id = session('logged_in_user_id');
      $change_password = DB::table('users')->where('id', $logged_in_user_id)->pluck('change_password')->first();

      if ($change_password == true) {
        return redirect('/dashboard/set-password');
      }


      $user_roles = session()->get('logged_in_user_roles');     // get user roles array stored in session

      if ($user_roles->contains('product-sales')) {
        return redirect('/product-sales');
      }

      if ($user_roles->contains('service-sales')) {
        return redirect('/service-sales');
      }

      if ($user_roles->contains('executive')) {
        return redirect('/executive');
      }

      if ($user_roles->contains('administrator')) {
        return redirect('/admin');
      }

      return redirect('/');

    }

    public function showSetPassword() {
      /*  check that a user is logged in.
          if not, redirect to login page
      */


      if (session()->has('logged_in_user_id') && session()->has('logged_in_user_roles')) {}
      else {
        return redirect('/');
      }


      $user_id = session('logged_in_user_id');
      $name = DB::table('users')->where('id', $user_id)->pluck('name')->first();

      return view('set-password')->with('name', $name);
    }

    public function setPassword(Request $request) {
      $request->validate([
        'password' => 'min:10|case_diff|numbers|letters|symbols',
        'confirmPassword' => 'required|string'
      ]);

      $password = $request['password'];
      $confirmPassword = $request['confirmPassword'];

      // check that both passwords match
      if ($password != $confirmPassword) {
        return back()->with('error', 'Both passwords must match.');
      }

      /*  if all checks pass, get user id from session,
          then update password
      */

      $id = session('logged_in_user_id');

      DB::table('users')->where('id', $id)->update([
        'password' => Hash::make($password),
        'change_password' => false,
        'updated_at' => \Carbon\Carbon::now()
      ]);

      // redirect to dashboard controller
      return redirect('/dashboard');

    }
}
