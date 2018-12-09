<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class ProductSalesController extends Controller
{
    public function showDashboard() {
      if ($this->checkLoggedIn()) {}
      else { return redirect('/'); }

      $userDetails = $this->getLoggedInUserDetails();
      $insideSales = $this->getInsideSalesReps();
      $projectStatusCodes = $this->getProjectStatusCodes();
      $ongoingProjects = $this->getAllProjects();
      $upcomingProjects = $this->getUpcomingProjects($ongoingProjects);
      $otherProjects = $this->getOtherProjects();

      return view('product-sales/product-sales-main')
        ->with('userDetails', $userDetails)
        ->with('insideSales', $insideSales)
        ->with('projectStatusCodes', $projectStatusCodes)
        ->with('projects', $ongoingProjects)
        ->with('upcomingProjects', $upcomingProjects)
        ->with('otherProjects', $otherProjects);
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

      $user_id = session()->get('logged_in_user_id');     // get user id from session
      $name = DB::table('users')->where('id', $user_id)->pluck('name')->first();

      $role = 'Product Sales';

      $collect = collect([
        'name' => $name,
        'role' => $role
      ]);

      return $collect;
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

    private function getProductSalesReps() {
      $sales = DB::table('user_roles')->select('user_id','role')->where('role','product-sales')->distinct()->get();
      $sales = $sales->pluck('user_id');

      $users = DB::table('users')
        ->whereIn('id', $sales)
        ->orderBy('name')
        ->select('id', 'name')
        ->get();

      return $users;
    }

    private function getProjectStatusCodes() {
      /*  Returns a collection of project status
          including id and code
      */

      $codes = DB::table('project_status')->get();

      return $codes;
    }

    private function getAllProjects() {
      /*  gets all projects associated with this user
          along with associated notes for each project
      */

      $projects = DB::table('projects')
        ->where('product_sales_id', session('logged_in_user_id'))
        ->orderBy('bid_date')
        ->get();

      $projects = $this->expandProjectInfo($projects);

      return $projects;
    }

    private function expandProjectInfo($projects) {
      /*  takes a collection of projects
          adds associated data including:
          -- project status information
          -- formatted bid date
          -- name of inside sales rep
          -- formatted amount
      */

      $allNotes = DB::table('project_notes')->select('id','project_id','last_updated_by_id','note','created_at')
        ->orderBy('created_at', 'desc')->get();

      $allStatus = DB::table('project_status')->select('id','status')->get();
      $insideSalesReps = $this->getInsideSalesReps();
      $productSalesReps = $this->getProductSalesReps();

      // loop through projects
      foreach ($projects as $project) {
        // append project notes
        $notes = $allNotes->where('project_id', $project->id);

        foreach ($notes as $note) {

          // add formatted date to note
          $date = new Carbon($note->created_at);
          $date->setTimezone('America/New_York');

          $note->date = $date->format('D, m/d/Y h:i:s a');

          // add note author name
          $author = $insideSalesReps->where('id', $note->last_updated_by_id)->first();
          if (empty($author)) {
            $author = $productSalesReps->where('id', $note->last_updated_by_id)->first();
          }

          $note->author = $author->name;
        }

        $project->notes = $notes;

        // append status name
        $status = $allStatus->where('id', $project->status_id)->first();
        $project->status = $status;

        // append formatted bid date
        $bidDate = new Carbon($project->bid_date);
        $bidDate = $bidDate->format('m/d/Y');
        $project->bidDate = $bidDate;

        // append inside sales person
        $insideSales = $insideSalesReps->where('id', $project->inside_sales_id)->first();
        $project->insideSales = $insideSales;

        // append product sales rep
        $productSales = $productSalesReps->where('id', $project->product_sales_id)->first();
        $project->productSales = $productSales;

        // format amount
        $project->amount = '$' . number_format($project->amount);


      }

      return $projects;

    }
    private function getOtherProjects() {
      /*  get all other projects not associated
          with the current user
      */

      $projects = DB::table('projects')
        ->where('product_sales_id','!=', session('logged_in_user_id'))
        ->orderBy('bid_date')
        ->get();

      if ($projects->isEmpty()) { return NULL; }

      $projects = $this->expandProjectInfo($projects);

      return $projects;

    }

    private function getUpcomingProjects($projects) {
      $projects = $projects->sortBy('bid_date');
      $now = Carbon::now('America/New_York');

      foreach ($projects as $key => $item) {
        $bid_date = new Carbon($item->bid_date, 'America/New_York');

        if ($now->greaterThan($bid_date)) {
          $projects->forget($key);
        }

        $item->bid_date = date('M d, Y', strtotime($item->bid_date));
      }

      $projects = $projects->take(5);
      return $projects;
    }

}
