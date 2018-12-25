<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Traits\PeopleData;
use App\Traits\ProjectData;
use App\Traits\ChartData;
use App\ExecUser;

class ExecController extends Controller
{

    use PeopleData;
    use ProjectData;
    use ChartData;

    public function showDashboard() {
      if ($this->checkLoggedIn()) {}
      else { return redirect('/'); }

      $user = ExecUser::find(session('logged_in_user_id'));

      $userDetails = $user->details();
      $productSalesReps = $this->getProductSalesReps();
      foreach ($productSalesReps as $i) {
        $i->projectsThisYear();
        $i->upcomingProjects();
        $i->ongoingProjects();
        $i->chartData();
      }

      $upcomingProjects = $this->getUpcomingProjects();

      $insideSalesReps = $this->getInsideSalesReps();
      $projectsThisYear = $this->projectsThisYear();
      $projectStatusCodes = $this->getProjectStatusCodes();
      $chartData = $this->execCharts();

      // set session key
      session(['current_section' => 'executive']);

      return view('executive/exec-main')
        ->with('userDetails', $userDetails)
        ->with('productSalesReps', $productSalesReps)
        ->with('projects', $projectsThisYear)
        ->with('chartData', $chartData)
        ->with('projectStatusCodes', $projectStatusCodes)
        ->with('insideSales', $insideSalesReps)
        ->with('upcomingProjects', $upcomingProjects);
    }

    private function getProjectStatusCodes() {
      /*  Returns a collection of project status
          including id and code
      */

      $codes = DB::table('project_status')->get();

      return $codes;
    }

    private function checkLoggedIn() {
      if (session()->has('logged_in_user_id') && session('logged_in_user_roles')->contains('executive')) {
        return true;
      }

      return false;
    }
}
