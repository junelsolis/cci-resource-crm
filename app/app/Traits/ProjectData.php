<?php // Code in app/Traits/MyTrait.php

namespace App\Traits;
use DB;
use Carbon\Carbon;

trait ProjectData {
  protected function expandProjectInfo($projects) {
    /*  Take a collection of projects
        and expand their information
    */

    $allStatus = DB::table('project_status')->get();
    $allInsideSales = $this->getInsideSalesReps();
    $allProductSales = $this->getProductSalesReps();
    $allExecs = $this->getExecs();

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
      $date = $bidDate->format('m/d/Y');
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
        if ($note->updated_at) {
          $date = new Carbon($note->updated_at);
          $date->setTimezone('America/New_York');

          $note->date = $date->format('D, m/d/Y h:i a');
        } else {
          $date = new Carbon($note->created_at);
          $date->setTimezone('America/New_York');

          $note->date = $date->format('D, m/d/Y h:i a');
        }


        /*  add note author name
            look in inside sales, product sales, and execs
        */

        $author = $allInsideSales->where('id', $note->last_updated_by_id)->first();
        if (empty($author)) {
          $author = $allProductSales->where('id', $note->last_updated_by_id)->first();
          if (empty($author)) {
            $author = $allExecs->where('id', $note->last_updated_by_id)->first();
          }
        }

        $note->author = $author->name;

        // add userIsAuthor boolean
        if ($note->last_updated_by_id == session('logged_in_user_id')) {
          $note->userIsAuthor = true;
        } else {
          $note->userIsAuthor = false;
        }


      }

      $project->notes = $notes;
    }

    return $projects;
  }

  protected function getUpcomingProjects() {
    /*  gets all upcoming projects
        and adds data
    */

    // get all projects except those sold or lost
    $projects = DB::table('projects')
      ->orderBy('bid_date')
      ->where([
        ['status_id', '!=', 2],
        ['status_id', '!=', 3],
        ['status_id', '!=', 5]
      ])
      ->get();

    $projects = $this->expandProjectInfo($projects);

    return $projects;

  }

  protected function getAllProjects() {
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

}
