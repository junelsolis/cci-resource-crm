<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SalesController extends Controller
{

  public function showDashboard() {
    if ($this->checkLoggedIn()) {}
    else { return redirect('/'); }


    $userDetails = $this->getLoggedInUserDetails();

    return view('sales/sales-main')
      ->with('userDetails', $userDetails);
  }



  private function checkLoggedIn() {
    if (session()->has('logged_in_user_id') && session('logged_in_user_roles')->contains('sales')) {
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

    $role = 'Sales';

    $collect = collect([
      'name' => $name,
      'role' => $role
    ]);

    return $collect;
  }
}
