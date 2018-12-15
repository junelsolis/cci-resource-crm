<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class ExecController extends Controller
{
    public function showDashboard() {


      $userDetails = $this->getLoggedInUserDetails();

      return view('executive/exec-main')
        ->with('userDetails', $userDetails);
    }






    private function getLoggedInUserDetails() {
      /*  returns the user's full name
          and role
      */

      $user_id = session()->get('logged_in_user_id');     // get user id from session
      $name = DB::table('users')->where('id', $user_id)->pluck('name')->first();

      $role = 'Executive';

      $collect = collect([
        'name' => $name,
        'role' => $role
      ]);

      return $collect;
    }
}
