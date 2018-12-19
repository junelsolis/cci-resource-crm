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
  protected function getProductSalesRepUpcomingProjects($product_sales_id) {
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
  protected function getProductSalesRepLostProjects($product_sales_id) {
    $status_id = 5;
    $projects = DB::table('projects')
      ->where('product_sales_id', $product_sales_id)
      ->where('status_id', $status_id)
      ->get();

    return $projects;
  }
  protected function getProductSalesRepSoldProjects($product_sales_id) {
    $status_id = 3;
    $projects = DB::table('projects')
      ->where('product_sales_id', $product_sales_id)
      ->where('status_id', $status_id)
      ->get();

    return $projects;
  }
}
