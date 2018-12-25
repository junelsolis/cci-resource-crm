<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;
use App\Project;
use App\Traits\ChartData;
use DB;

class ProductSalesUser extends User
{

    use ChartData;

    public $projectsThisYear;
    public $upcomingProjects;
    public $ongoingProjects;
    public $otherProjects;
    public $chartData;

    public function projectsThisYear() {
      $thisYear = Carbon::now()->subYear();
      $thisYear->format('Y-m-d');

      $projects = Project::where('product_sales_id', $this->id)
        ->where('bid_date', '>=', $thisYear)
        ->orderBy('bid_date', 'desc')
        ->get();

      $this->projectsThisYear = $projects;

      return $projects;
    }

    public function upcomingProjects() {
      $thisYear = Carbon::now()->subYear();

      $projects = Project::where('product_sales_id', $this->id)
        ->where([
          // [ 'status_id', '!=', 2],
          [ 'status_id', '!=', 3],  // Sold
          [ 'status_id', '!=', 5]   // Lost
        ])
        ->where('bid_date', '>=', $thisYear)
        ->orderBy('bid_date','desc')->get();

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

      $this->upcomingProjects = $projects;

      return $projects;
    }

    public function ongoingProjects() {
      $status_ids = [1,2,4];

      $projects = Project::where('product_sales_id', $this->id)
        ->whereIn('status_id', $status_ids)
        ->get();

      $this->ongoingProjects = $projects;

      return $projects;
    }

    public function otherProjects() {
      $thisYear = Carbon::now()->subYear();
      $thisYear->format('Y-m-d');

      $projects = Project::where('product_sales_id', '!=', $this->id)
        ->where('bid_date', '>=', $thisYear)
        ->orderBy('bid_date', 'desc')
        ->get();


      $this->ongoingProjects = $projects;
      return $projects;
    }

    public function chartData() {

      $this->chartData =  $this->productSalesCharts($this->id);

      return $this->chartData;
    }
}