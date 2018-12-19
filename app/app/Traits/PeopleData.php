<?php // Code in app/Traits/MyTrait.php

namespace App\Traits;
use DB;
use Carbon\Carbon;

trait PeopleData {
  protected function getInsideSalesReps() {
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
  protected function getProductSalesReps() {
    $sales = DB::table('user_roles')->select('user_id','role')->where('role','product-sales')->distinct()->get();
    $sales = $sales->pluck('user_id');

    $users = DB::table('users')
      ->whereIn('id', $sales)
      ->orderBy('name')
      ->select('id', 'name')
      ->get();


    $now = Carbon::now();
    $now->setTimezone('America/New_York');
    $lastYear = $now->subYear();

    $projects = DB::table('projects')
      ->where('bid_date', '>=', $lastYear)
      ->orderBy('bid_date')
      ->get();

    foreach ($users as $user) {
      $lostProjects = $this->getProductSalesRepLostProjects($user->id, $projects);
      $user->lostProjects = $lostProjects;

      $soldProjects = $this->getProductSalesRepSoldProjects($user->id, $projects);
      $user->soldProjects = $soldProjects;

      $upcomingProjects = $this->getProductSalesRepUpcomingProjects($user->id, $projects);
      $user->upcomingProjects = $upcomingProjects;

      $chartData = $this->productSalesCharts($user->id);
      $user->chartData = $chartData;
    }

    return $users;
  }
  protected function getExecs() {
    $execs = DB::table('user_roles')->select('user_id','role')->where('role','executive')->distinct()->get();
    $execs = $execs->pluck('user_id');

    $execs = DB::table('users')
      ->whereIn('id', $execs)
      ->orderBy('name')
      ->select('id', 'name')
      ->get();

    return $execs;
  }

  private function getProductSalesRepUpcomingProjects($product_sales_id, $projects) {
    $now = Carbon::now();
    $now->setTimezone('America/New_York');

    $projects = $projects
      ->where('product_sales_id', $product_sales_id)
      ->where('bid_date', '>=', $now)
      ->sortBy('bid_date');

    foreach ($projects as $i) {
      $date = new Carbon($i->bid_date);

      $i->bidDate = $date->format('m/d/Y');
    }

    return $projects;
  }

  private function getProductSalesRepLostProjects($product_sales_id, $projects) {
    $status_id = 5;
    $projects = $projects
      ->where('product_sales_id', $product_sales_id)
      ->where('status_id', $status_id);

    return $projects;
  }

  private function getProductSalesRepSoldProjects($product_sales_id, $projects) {
    $status_id = 3;
    $projects = $projects
      ->where('product_sales_id', $product_sales_id)
      ->where('status_id', $status_id);

    return $projects;
  }

  // private function productSalesRepSales($product_sales_id, $projects) {
  //   $projects = $projects
  //     ->where('product_sales_id', $product_sales_id)
  //     ->where('status_id', 3);
  //
  //   $sum = 0;
  //
  //   foreach ($projects as $i) {
  //     $sum += $i->amount;
  //   }
  //
  //   return $sum;
  // }

}
