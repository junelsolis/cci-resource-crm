<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;
use App\Project;
use DB;

class ProductSalesUser extends User
{
    public function projectsThisYear() {
      $thisYear = Carbon::now()->subYear();
      $thisYear->format('Y-m-d');

      $projects = Project::where('product_sales_id', $this->id)
        ->where('bid_date', '>=', $thisYear)
        ->orderBy('bid_date', 'desc')
        ->get();


      return $projects;
    }

    public function upcomingProjects() {
      $thisYear = Carbon::now()->subYear();

      $projects = Project::where('product_sales_id', $this->id)
        ->where([
          [ 'status_id', '!=', 3],  // Sold
          [ 'status_id', '!=', 5]   // Lost
        ])
        ->where('bid_date', '>=', $thisYear)
        ->orderBy('bid_date')->get();

      $now = Carbon::now();
      $now->setTimezone('America/New_York');

      foreach ($projects as $key => $item) {
        $bid_date = new Carbon($item->bid_date);

        $status = $item->status_id;

        if ($now->greaterThan($bid_date)) {

          if ($status == 1 || $status == 4) {

            continue;
          }

          $projects->forget($key);
        }

      }

      $projects = $projects->reverse();
      //$projects = $projects->take(5);

      return $projects;
    }
}
