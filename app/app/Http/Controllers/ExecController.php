<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class ExecController extends Controller
{
    public function showDashboard() {
      if ($this->checkLoggedIn()) {}
      else { return redirect('/'); }

      $userDetails = $this->getLoggedInUserDetails();
      $productSalesReps = $this->getProductSalesReps();
      $insideSalesReps = $this->getInsideSalesReps();
      $allProjects = $this->getAllProjects();


      return view('executive/exec-main')
        ->with('userDetails', $userDetails)
        ->with('productSalesReps', $productSalesReps)
        ->with('projects', $allProjects);
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

    private function getProductSalesReps() {
      $sales = DB::table('user_roles')->select('user_id','role')->where('role','product-sales')->distinct()->get();
      $sales = $sales->pluck('user_id');

      $users = DB::table('users')
        ->whereIn('id', $sales)
        ->orderBy('name')
        ->select('id', 'name')
        ->get();


      foreach ($users as $user) {
        $lostProjects = $this->getProductSalesRepLostProjects($user->id);
        $user->lostProjects = $lostProjects;

        $soldProjects = $this->getProductSalesRepSoldProjects($user->id);
        $user->soldProjects = $soldProjects;

        $upcomingProjects = $this->getProductSalesRepUpcomingProjects($user->id);
        $user->upcomingProjects = $upcomingProjects;
      }

      return $users;
    }

    private function getInsideSalesReps() {
      /*  Returns a collection of inside salespersons
      */

      $sales = DB::table('user_roles')->select('user_id','role')->where('role','inside-sales')->distinct()->get();
      $sales = $sales->pluck('user_id');

      $users = DB::table('users')
        ->whereIn('id', $sales)
        ->orderBy('name')
        ->select('id', 'name')
        ->get();

      return $users;
    }
    
    private function getProductSalesRepUpcomingProjects($product_sales_id) {
      $now = Carbon::now();
      $now->setTimezone('America/New_York');

      $projects = DB::table('projects')
        ->where('product_sales_id', $product_sales_id)
        ->where('bid_date', '>=', $now)
        ->orderBy('bid_date')
        ->get();

      foreach ($projects as $i) {
        $date = new Carbon($i->bid_date);

        $i->bidDate = $date->format('m/d/Y');
      }

      return $projects;
    }

    private function getProductSalesRepLostProjects($product_sales_id) {
      $status_id = 5;
      $projects = DB::table('projects')
        ->where('product_sales_id', $product_sales_id)
        ->where('status_id', $status_id)
        ->get();

      return $projects;
    }

    private function getProductSalesRepSoldProjects($product_sales_id) {
      $status_id = 3;
      $projects = DB::table('projects')
        ->where('product_sales_id', $product_sales_id)
        ->where('status_id', $status_id)
        ->get();

      return $projects;
    }

    private function getAllProjects() {
      /*  Get all projects
          in the last twelve months
      */

      $now = Carbon::today();
      $now->setTimezone('America/New_York');
      $now->subYear();

      $projects = DB::table('projects')
        ->orderBy('bid_date')
        ->where('bid_date', '>=', $now)
        ->get();

      $projects = $this->expandProjectInfo($projects);

      return $projects;
    }

    private function expandProjectInfo($projects) {
      /*  Take a collection of projects
          and expand their information
      */

      $allStatus = DB::table('project_status')->get();
      $allInsideSales = $this->getInsideSalesReps();
      $allProductSales = $this->getProductSalesReps();
      $allNotes = DB::table('project_notes')->orderBy('created_at','desc')->get();


      $now = Carbon::today();
      $now->setTimezone('America/New_York');

      $nextDay = Carbon::today();
      $nextDay->setTimezone('America/New_York');
      $nextDay->addDay();

      $nextWeek = Carbon::today();
      $nextWeek->setTimezone('America/New_York');
      $nextWeek->addWeek();

      foreach ($projects as $project) {

        // assign status
        $status = $allStatus->where('id', $project->status_id)->first();
        $project->status = $status;

        // format bid date
        $bidDate = new Carbon($project->bid_date);
        $date = $bidDate->format('Y-m-d');
        $project->bidDate = $date;

        // add bid timing
        if ($bidDate->lessThan($now)) {
          $bidTiming = 'late';
          $project->bidTiming = $bidTiming;
        }

        else if (($bidDate->greaterThanOrEqualTo($now)) && ($bidDate->lessThanOrEqualto($nextWeek))) {
          $bidTiming = 'soon';
          $project->bidTiming = $bidTiming;
        }

        else {
          $bidTiming = 'ontime';
          $project->bidTiming = $bidTiming;
        }

        // add product sales person
        $productSales = $allProductSales->where('id', $project->product_sales_id)->first();

        $project->productSales = $productSales;

        // add inside sales person
        $insideSales = $allInsideSales->where('id', $project->inside_sales_id)->first();
        $project->insideSales = $insideSales;

        // format amount
        $project->amount = '$' . number_format($project->amount);

        // append project notes
        $notes = $allNotes->where('project_id', $project->id);

        foreach ($notes as $note) {

          // add formatted date to note
          $date = new Carbon($note->created_at);
          $date->setTimezone('America/New_York');

          $note->date = $date->format('D, m/d/Y h:i:s a');

          // add note author name
          $author = $allInsideSales->where('id', $note->last_updated_by_id)->first();
          if (empty($author)) {
            $author = $allProductSales->where('id', $note->last_updated_by_id)->first();
          }

          $note->author = $author->name;
        }

        $project->notes = $notes;
      }

      return $projects;
    }

    private function checkLoggedIn() {
      if (session()->has('logged_in_user_id') && session('logged_in_user_roles')->contains('executive')) {
        return true;
      }

      return false;
    }
}
