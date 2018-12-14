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
      $chartData = $this->getChartData();


      return view('product-sales/product-sales-main')
        ->with('userDetails', $userDetails)
        ->with('insideSales', $insideSales)
        ->with('projectStatusCodes', $projectStatusCodes)
        ->with('projects', $ongoingProjects)
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
        ->orderBy('bid_date', 'desc')
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

    private function getUpcomingProjects($projects) {
      $projects = $projects->sortBy('bid_date');
      $now = Carbon::now('America/New_York');

      $allStatus = DB::table('project_status')->get();

      foreach ($projects as $key => $item) {
        $bid_date = new Carbon($item->bid_date, 'America/New_York');

        if ($now->greaterThan($bid_date)) {
          $projects->forget($key);
        }

        $item->bidDate = date('M d, Y', strtotime($item->bid_date));

        // assign status
        $status = $allStatus->where('id', $item->status_id)->first();
        $item->status = $status;
      }

      $projects = $projects->take(5);


      return $projects;
    }
    private function getChartData() {
      /*  gathers all the data needed for charts
      */

      // get all projects over the last year
      $now = Carbon::now();
      $now->setTimezone('America/New_York');
      $lastYear = $now->subYear();

      $projects = DB::table('projects')
        ->where('product_sales_id', session('logged_in_user_id'))
        ->where('bid_date', '>=', $lastYear)
        ->get();


      // create array of months
      $months = collect();
      $index = 0;
      $monthLoop = new Carbon('first day of this month');
      $monthLoop->setTimezone('America/New_York');

      while ($index <= 12) {

        if ($index == 0) { $index++; continue;}

        $date = new Carbon($monthLoop);
        $date->setTimezone('America/New_York');
        $date->subMonths($index);
        $name = new Carbon($date);
        $name = $name->format('M');

        $collect = collect([ 'date' => $date, 'name' => $name]);
        $months->push($collect);

        $index++;
      }

      $months = $months->reverse();


      // create sales data
      $sales = collect();
      foreach ($months as $month) {
        $sum = 0;

        foreach ($projects as $project) {
          $bidDate = new Carbon($project->bid_date);
          if ($project->status_id == 3 && $month['date']->isSameMonth($bidDate) && $month['date']->isSameYear($bidDate)) {
            $sum += $project->amount;
          }
        }

        $sales->push($sum);
      }


      // create next six months
      $nextSixMonths = collect();
      $index = 0;
      $monthLoop = new Carbon('first day of this month');
      $monthLoop->setTimezone('America/New_York');

      while ($index <= 6) {

        if ($index == 0) { $index++; continue;}

        $date = new Carbon($monthLoop);
        $date->setTimezone('America/New_York');
        $date->addMonths($index);
        $name = new Carbon($date);
        $name = $name->format('M');

        $collect = collect([ 'date' => $date, 'name' => $name]);
        $nextSixMonths->push($collect);

        $index++;
      }


      // create projected sales
      $projectedSales = collect();
      foreach ($nextSixMonths as $month) {
        $sum = 0;

        foreach ($projects as $project) {
          if ($project->status_id != 5) {
            $bidDate = new Carbon($project->bid_date);
            if (($month['date'])->isSameMonth($bidDate) && $month['date']->isSameYear($bidDate)) {
              $sum += $project->amount;
            }
          }
        }

        $projectedSales->push($sum);
      }

      // create projects data over last 12 months
      $projectStatus = collect();
      $now = Carbon::now();
      $now->setTimezone('America/New_York');

      // count new projects
      $count = 0;

      foreach ($projects as $project) {
        $bidDate = new Carbon($project->bid_date);
        if ($project->status_id == 1) {
          $count++;
        }
      }

      $collect = collect();
      $collect->put('name', 'New');
      $collect->put('count', $count);
      $projectStatus->push($collect);

      // count Quoted projects
      $count = 0;

      foreach ($projects as $project) {
        $bidDate = new Carbon($project->bid_date);
        if ($project->status_id == 2) {
          $count++;
        }
      }

      $collect = collect();
      $collect->put('name', 'Quoted');
      $collect->put('count', $count);
      $projectStatus->push($collect);

      // count Sold projects
      $count = 0;

      foreach ($projects as $project) {
        $bidDate = new Carbon($project->bid_date);
        if ($project->status_id == 3) {
          $count++;
        }
      }

      $collect = collect();
      $collect->put('name', 'Sold');
      $collect->put('count', $count);
      $projectStatus->push($collect);

      // count Engineered projects
      $count = 0;

      foreach ($projects as $project) {
        $bidDate = new Carbon($project->bid_date);
        if ($project->status_id == 4) {
          $count++;
        }
      }

      $collect = collect();
      $collect->put('name', 'Engineered');
      $collect->put('count', $count);
      $projectStatus->push($collect);

      // count Lost projects
      $count = 0;

      foreach ($projects as $project) {
        $bidDate = new Carbon($project->bid_date);
        if ($project->status_id == 5) {
          $count++;
        }
      }

      $collect = collect();
      $collect->put('name', 'Lost');
      $collect->put('count', $count);
      $projectStatus->push($collect);


      // create project counts
      $projectCounts = collect();
      foreach ($months as $month) {
        $count = 0;

        foreach ($projects as $project) {
          $bidDate = new Carbon($project->bid_date);
          if ($month['date']->isSameMonth($bidDate) && $month['date']->isSameYear($bidDate)) {
            $count++;
          }
        }

        $projectCounts->push($count);
      }

      $chartData = collect();
      $chartData->put('months', $months->pluck('name'));
      $chartData->put('nextSixMonths', $nextSixMonths->pluck('name'));
      $chartData->put('sales', $sales);
      $chartData->put('projectedSales', $projectedSales);
      $chartData->put('projectStatus', $projectStatus);
      $chartData->put('projectCounts', $projectCounts);

      return $chartData;
    }

}
