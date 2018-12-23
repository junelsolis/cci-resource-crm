<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\ProductSalesUser;

use App\Traits\ProjectData;
use App\Traits\PeopleData;
use App\Traits\ChartData;

class ProductSalesController extends Controller
{

    use ProjectData;
    use PeopleData;
    use ChartData;


    public function showDashboard() {
      if ($this->checkLoggedIn()) {}
      else { return redirect('/'); }

      $user = ProductSalesUser::where('id',session('logged_in_user_id'))->first();

      $userDetails = $this->getLoggedInUserDetails();
      $insideSales = $this->getInsideSalesReps();
      $projectStatusCodes = $this->getProjectStatusCodes();

      $projectsThisYear = $user->projectsThisYear();
      foreach ($projectsThisYear as $i) {


      }

      $ongoingProjects = $this->getOngoingProjects();
      $upcomingProjects = $user->upcomingProjects();

      $otherProjects = $this->getOtherProjects();
      $chartData = $this->productSalesCharts(session('logged_in_user_id'));


      // set session key
      session(['current_section' => 'product-sales']);

      return view('product-sales/product-sales-main')
        ->with('user', $user)
        ->with('userDetails', $userDetails)
        ->with('insideSales', $insideSales)
        ->with('projectStatusCodes', $projectStatusCodes)
        ->with('projects', $projectsThisYear)
        ->with('ongoingProjects', $ongoingProjects)
        ->with('upcomingProjects', $upcomingProjects)
        ->with('otherProjects', $otherProjects)
        ->with('chartData', $chartData);
    }

    private function checkLoggedIn() {
      if (session()->has('logged_in_user_id') && session('logged_in_user_roles')->contains('product-sales')) {
        return true;
      }

      return false;
    }

    private function getLoggedInUserDetails() {
      /*  returns the user's full name
          and role
      */

      // $user_id = session()->get('logged_in_user_id');     // get user id from session
      $this->user = ProductSalesUser::find(session('logged_in_user_id'));

      $role = 'Product Sales';

      $collect = collect([
        'name' => $this->user->name,
        'role' => $role
      ]);

      return $collect;
    }


    private function getProjectStatusCodes() {
      /*  Returns a collection of project status
          including id and code
      */

      $codes = DB::table('project_status')->get();

      return $codes;
    }

    private function getUserProjects() {
      /*  gets all projects associated with this user
          along with associated notes for each project
      */

      $projects = DB::table('projects')
        ->where('product_sales_id', session('logged_in_user_id'))
        ->orderBy('bid_date', 'desc')
        ->get();

      $projects = $this->expandProjectInfo($projects);

      return $projects;
    }


    private function getOtherProjects() {
      /*  get all other projects not associated
          with the current user
      */

      $projects = DB::table('projects')
        ->where('product_sales_id','!=', session('logged_in_user_id'))
        ->orderBy('bid_date','desc')
        ->get();

      if ($projects->isEmpty()) { return NULL; }

      $projects = $this->expandProjectInfo($projects);

      return $projects;

    }

    private function getUserUpcomingProjects() {
      $projects = DB::table('projects')
        ->where('product_sales_id', session('logged_in_user_id'))
        ->orderBy('bid_date','desc')->get();

      $now = Carbon::now('America/New_York');

      $allStatus = DB::table('project_status')->get();

      $projects = $this->expandProjectInfo($projects);

      foreach ($projects as $key => $item) {
        $bid_date = new Carbon($item->bid_date, 'America/New_York');

        $status = $item->status_id;

        if ($now->greaterThan($bid_date)) {

          if ($status == 1 || $status == 4) {

            $item->bidDate = date('M d, Y', strtotime($item->bid_date));

            // assign status
            $status = $allStatus->where('id', $item->status_id)->first();
            $item->status = $status;

            continue;
          }

          $projects->forget($key);
        }


        $item->bidDate = date('M d, Y', strtotime($item->bid_date));

        // assign status
        $status = $allStatus->where('id', $item->status_id)->first();
        $item->status = $status;
      }

      $projects = $projects->reverse();
      $projects = $projects->take(5);

      return $projects;


    }

    private function getOngoingProjects() {

      $status_ids = [1,2,4];

      $projects = DB::table('projects')
        ->where('product_sales_id', session('logged_in_user_id'))
        ->whereIn('status_id', $status_ids)
        ->get();

      return $projects;
    }

}
