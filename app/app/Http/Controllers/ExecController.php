<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Traits\PeopleData;
use App\Traits\ProjectData;
use App\Traits\ChartData;

class ExecController extends Controller
{

    use PeopleData;
    use ProjectData;
    use ChartData;

    public function showDashboard() {
      if ($this->checkLoggedIn()) {}
      else { return redirect('/'); }

      $userDetails = $this->getLoggedInUserDetails();
      $productSalesReps = $this->getProductSalesReps();
      $insideSalesReps = $this->getInsideSalesReps();
      $allProjects = $this->getAllProjects();
      $chartData = $this->execCharts();
      
      // set session key
      session(['current_section' => 'executive']);

      return view('executive/exec-main')
        ->with('userDetails', $userDetails)
        ->with('productSalesReps', $productSalesReps)
        ->with('projects', $allProjects)
        ->with('chartData', $chartData);
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

    private function checkLoggedIn() {
      if (session()->has('logged_in_user_id') && session('logged_in_user_roles')->contains('executive')) {
        return true;
      }

      return false;
    }
}
