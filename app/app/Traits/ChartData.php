<?php // Code in app/Traits/MyTrait.php

namespace App\Traits;
use DB;
use App\Project;
use Carbon\Carbon;
use App\ProductSalesUser;

trait ChartData {

    protected function execCharts() {
      $projects = $this->allProjects();

      $months = $this->createMonths();
      $nextSixMonths = $this->createNextSixMonths();

      $sales = $this->calculateSales($projects);
      $projectedSales = $this->calculateProjectedSales($projects);
      $lostBids = $this->calculateLostBids($projects);
      $projectStatus = $this->countProjectStatus($projects);
      $projectCounts = $this->countProjectsByMonth($projects);
      $topProjects = $this->projectsByAmount($projects);


      // collect things together
      $chartData = collect();
      $chartData->put('months', $months->pluck('name'));
      $chartData->put('nextSixMonths', $nextSixMonths->pluck('name'));
      $chartData->put('sales', $sales);
      $chartData->put('projectedSales', $projectedSales);
      $chartData->put('lostBids', $lostBids);
      $chartData->put('projectStatus', $projectStatus);
      $chartData->put('projectCounts', $projectCounts);
      $chartData->put('topProjects', $topProjects);

      return $chartData;

    }
    protected function productSalesCharts($product_sales_id) {
      $projects = $this->getProductSalesProjects($product_sales_id);


      $months = $this->createMonths();
      $nextSixMonths = $this->createNextSixMonths();

      // sales data
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

    protected function insideSalesCharts($inside_sales_id) {
      $projects = $this->allProjects();
      $months = $this->createMonths();

      $projectStatus = $this->countProjectStatus($projects);
      $projectCounts = $this->countProjectsByMonth($projects);

      // collect everything
      $chartData = collect();
      $chartData->put('months', $months->pluck('name'));
      $chartData->put('projectStatus', $projectStatus);
      $chartData->put('projectCounts', $projectCounts);

      return $chartData;
    }

    protected function allProjects() {
      $now = Carbon::now();
      //$now->setTimezone('America/New_York');
      $lastYear = $now->subYear();

      // $projects = DB::table('projects')
      //   ->where('bid_date','>=', $lastYear)
      //   ->get();

      $projects = Project::where('bid_date','>=', $lastYear)->get();

      return $projects;
    }
    private function getProductSalesProjects($product_sales_id) {
      /*  gets all projects belonging to a product salesperson
          within the last 12 months
      */

      $user = ProductSalesUser::find($product_sales_id);


      $now = Carbon::now();
      $now->setTimezone('America/New_York');
      $lastYear = $now->subYear();

      // $projects = DB::table('projects')
      //   ->where('product_sales_id', $product_sales_id)
      //   ->where('bid_date', '>=', $lastYear)
      //   ->get();

      $projects = $user->projects->where('bid_date', '>=', $lastYear);

      return $projects;

    }

    private function calculateSales($projects) {
      /*  sums up sales data for every month
      */
      $months = $this->createMonths();

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

      return $sales;


    }

    private function calculateProjectedSales($projects) {

      $nextSixMonths = $this->createNextSixMonths();

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

      return $projectedSales;
    }

    private function calculateLostBids($projects) {
      $months = $this->createMonths();

      $lost = collect();

      foreach ($months as $month) {
        $sum = 0;

        foreach ($projects as $project) {
          $bidDate = new Carbon($project->bid_date);
          if ($project->status_id == 5 && $month['date']->isSameMonth($bidDate) && $month['date']->isSameYear($bidDate)) {
            $sum += $project->amount;
          }
        }

        $lost->push($sum);
      }

      return $lost;
    }

    private function countProjectsByMonth($projects) {

      $months = $this->createMonths();

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

      return $projectCounts;
    }

    private function countProjectStatus($projects) {
      $projectStatus = collect();
      $now = Carbon::now();
      $now->setTimezone('America/New_York');


      $new = collect();
      $quoted = collect();
      $sold = collect();
      $engineered = collect();
      $lost = collect();

      $newCount = 0;
      $quotedCount = 0;
      $soldCount = 0;
      $engineeredCount = 0;
      $lostCount = 0;

      foreach ($projects as $i) {


        if ($i['status']['status'] == 'New') { $newCount++; continue;}
        if ($i['status']['status'] == 'Quoted') { $quotedCount++; continue;}
        if ($i['status']['status'] == 'Sold') { $soldCount++; continue; }
        if ($i['status']['status'] == 'Engineered') { $engineeredCount++; continue; }
        if ($i['status']['status'] == 'Lost') { $lostCount++; continue; }

      }


      $collect = collect();
      $collect->put('name', 'New');
      $collect->put('count', $newCount);

      $projectStatus->push($collect);

      $collect = collect();
      $collect->put('name', 'Quoted');
      $collect->put('count', $quotedCount);

      $projectStatus->push($collect);

      $collect = collect();
      $collect->put('name', 'Sold');
      $collect->put('count', $soldCount);

      $projectStatus->push($collect);

      $collect = collect();
      $collect->put('name', 'Engineered');
      $collect->put('count', $engineeredCount);

      $projectStatus->push($collect);

      $collect = collect();
      $collect->put('name', 'Lost');
      $collect->put('count', $engineeredCount);

      $projectStatus->push($collect);

      return $projectStatus;
    }

    private function projectsByAmount($projects) {
      $projects = $projects->sortByDesc('amount');

      return $projects;
    }

    private function createMonths() {
      /*  create an array of months
      */

      // create array of months
      $months = collect();
      $index = 0;
      $monthLoop = new Carbon('first day of this month');
      //$monthLoop->setTimezone('America/New_York');

      while ($index <= 12) {

        if ($index == 0) { $index++; continue;}

        $date = new Carbon($monthLoop);
        //$date->setTimezone('America/New_York');
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
