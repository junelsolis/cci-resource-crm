<?php // Code in app/Traits/MyTrait.php

namespace App\Traits;
use DB;
use Carbon\Carbon;

trait ChartData {

    protected function execCharts() {}
    protected function productSalesCharts($product_sales_id) {
      $projects = $this->getProductSalesProjects($product_sales_id);


      $months = $this->createMonths();
      $nextSixMonths = $this->createNextSixMonths();

      // sales data
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

      // projected sales
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


      // projects data over last 12 months
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


    private function getProductSalesProjects($product_sales_id) {
      /*  gets all projects belonging to a product salesperson
          within the last 12 months
      */

      $now = Carbon::now();
      $now->setTimezone('America/New_York');
      $lastYear = $now->subYear();

      $projects = DB::table('projects')
        ->where('product_sales_id', $product_sales_id)
        ->where('bid_date', '>=', $lastYear)
        ->get();

      return $projects;

    }

    private function createMonths() {
      /*  create an array of months
      */

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

      return $months;
    }

    private function createNextSixMonths() {

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

      return $nextSixMonths;
    }
}
