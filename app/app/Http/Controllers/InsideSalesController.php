<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Traits\ProjectData;
use App\Traits\PeopleData;
use App\Traits\ChartData;
use App\InsideSalesUser;
use App\ProductSalesUser;

class InsideSalesController extends Controller
{

  use ProjectData;
  use PeopleData;
  use ChartData;

  public function showDashboard() {
    if ($this->checkLoggedIn()) {}
    else { return redirect('/'); }

    // set session key
    session(['current_section' => 'inside-sales']);

    // set user
    $user = InsideSalesUser::find(session('logged_in_user_id'));

    $userDetails = $user->userDetails();
    $upcomingProjects = $user->upcomingProjects();
    $allProjects = $user->projectsThisYear();
    $ongoingProjects = $user->ongoingProjects();

    $insideSales = $this->getInsideSalesReps();
    $productSales = $this->getProductSalesReps();
    foreach ($productSales as $user) {
      $user->projectsThisYear();
      $user->upcomingProjects();
      $user->ongoingProjects();
    }

    $chartData = $this->insideSalesCharts($user->id);

    $projectStatusCodes = $this->getProjectStatusCodes();

    return view('inside-sales/inside-sales-main')
      ->with('userDetails', $userDetails)
      ->with('insideSales', $insideSales)
      ->with('productSales', $productSales)
      ->with('projectStatusCodes', $projectStatusCodes)
      ->with('upcomingProjects', $upcomingProjects)
      ->with('allProjects', $allProjects)
      ->with('ongoingProjects', $ongoingProjects)
      ->with('chartData', $chartData);
  }


  public function showPeople(Request $request) {
    if ($this->checkLoggedIn()) {}
    else { return redirect('/'); }

    // set session key
    session(['current_section' => 'inside-sales']);

    // set user
    $user = InsideSalesUser::find(session('logged_in_user_id'));

    $userDetails = $user->userDetails();

    // get person from request
    // if empty, select first one
    if (empty($request['id'])) {
      $person = $this->getProductSalesReps()->first();
    } else {
      $person = ProductSalesUser::where('id', $request['id'])->first();
    }

    // initialize person data
    $person->ongoingProjects();
    $person->chartData();
    $person->projectsThisYear();

    // additional page info
    $productSales = $this->getProductSalesReps();
    $insideSales = $this->getInsideSalesReps();
    $projectStatusCodes = $this->getProjectStatusCodes();

    return view('/inside-sales/people')
      ->with('userDetails', $userDetails)
      ->with('productSales', $productSales)
      ->with('person', $person)
      ->with('productSales', $productSales)
      ->with('insideSales', $insideSales)
      ->with('projectStatusCodes', $projectStatusCodes);
  }

  private function checkLoggedIn() {
    if (session()->has('logged_in_user_id') && session('logged_in_user_roles')->contains('inside-sales')) {
      return true;
    }

    return false;
  }


  private function getProjectStatusCodes() {
    /*  Returns a collection of project status
        including id and code
    */

    $codes = DB::table('project_status')->get();

    return $codes;
  }


}
