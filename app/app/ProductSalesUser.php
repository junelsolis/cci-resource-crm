<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;
use App\Project;
use App\Traits\ChartData;
use App\ProjectNote;
use DB;

class ProductSalesUser extends User
{

    use ChartData;

    public $projectsThisYear;
    public $upcomingProjects;
    public $ongoingProjects;
    public $otherProjects;
    public $chartData;


    public function projects() {
      return $this->hasMany('App\Project','product_sales_id','id');
    }


    public function projectsThisYear() {
      $thisYear = Carbon::now()->subYear();
      $thisYear->format('Y-m-d');

      // $projects = Project::where('product_sales_id', $this->id)
      //   ->where('bid_date', '>=', $thisYear)
      //   ->orderBy('bid_date', 'desc')
      //   ->get();

      $projects = $this->projects
        ->where('bid_date', '>=', $thisYear)
        ->sortByDesc('bid_date');

      // $this->projectsThisYear = $projects;

      return $projects;
    }

    public function upcomingProjects() {
      // $thisYear = Carbon::now()->subYear();
      //
      // $projects = Project::where('product_sales_id', $this->id)
      //   ->where([
      //     // [ 'status_id', '!=', 2],
      //     [ 'status_id', '!=', 3],  // Sold
      //     [ 'status_id', '!=', 5]   // Lost
      //   ])
      //   ->where('bid_date', '>=', $thisYear)
      //   ->orderBy('bid_date','desc')->get();

      // if (empty($this->projectsThisYear)) {
      //   $this->projectsThisYear();
      // }

      $status_ids = [3,5];

      // $projects = $this->projectsThisYear
      //   ->whereNotIn('status_id', $status_ids)
      //   ->sortByDesc('bid_date');

      $projects = $this->projects->whereNotIn('status_id', $status_ids)->sortByDesc('bid_date');


      $now = Carbon::now();
      $now->setTimezone('America/New_York');

      foreach ($projects as $key => $item) {
        $bid_date = new Carbon($item->bid_date);

        $status = $item->status_id;

        if ($now->greaterThan($bid_date)) {

          if ($status == 1 || $status == 4) {

            continue;
          }

          else { $projects->forget($key); }
        }

      }

      $projects = $projects->reverse();
      //$projects = $projects->take(5);

       // $this->upcomingProjects = $projects;

      return $projects;
    }

    public function ongoingProjects() {

      if (empty($this->projectsThisYear)) {
        $this->projectsThisYear();
      }
      $status_ids = [1,2,4];

      // $projects = Project::where('product_sales_id', $this->id)
      //   ->whereIn('status_id', $status_ids)
      //   ->get();

      $projects = $this->projects->whereIn('status_id', $status_ids);

      // $this->ongoingProjects = $projects;

      return $projects;
    }

    public function otherProjects() {
      $thisYear = Carbon::now()->subYear();
      $thisYear->format('Y-m-d');

      $projects = Project::where('product_sales_id', '!=', $this->id)
        ->where('bid_date', '>=', $thisYear)
        ->orderBy('bid_date', 'desc')
        ->get();


      // $this->ongoingProjects = $projects;
      return $projects;
    }

    public function chartData() {

      $projects = $this->projectsThisYear();

      $months = $this->createMonths();
      $nextSixMonths = $this->createNextSixMonths();

      // calculate sales
      $sales = $this->calculateSales($projects);

      // projected sales
      $projectedSales = $this->calculateProjectedSales($projects);

      // project status counts
      $projectStatus = $this->countProjectStatus($projects);

      // project counts last 12 months
      $projectCounts = $this->countProjectsByMonth($projects);

      // gather everything up
      $chartData = collect();
      $chartData->put('months', $months->pluck('name'));
      $chartData->put('nextSixMonths', $nextSixMonths->pluck('name'));
      $chartData->put('sales', $sales);
      $chartData->put('projectedSales', $projectedSales);
      $chartData->put('projectStatus', $projectStatus);
      $chartData->put('projectCounts', $projectCounts);


      return $chartData;
    }

    public function getProjectsThisYearAttribute() {
      return $this->projectsThisYear();
    }

    public function getUpcomingProjectsAttribute() {
      return $this->upcomingProjects();
    }

    public function getOngoingProjectsAttribute() {
      return $this->ongoingProjects();
    }

    public function getOtherProjectsAttribute() {
      return $this->otherProjects();
    }

    public function getChartDataAttribute() {
      return $this->chartData();
    }

    protected $appends = ['projectsThisYear','upcomingProjects','ongoingProjects','otherProjects','chartData'];
}
