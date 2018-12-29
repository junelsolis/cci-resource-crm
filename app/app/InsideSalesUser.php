<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;
use App\Project;
use App\ProjectNote;
use DB;

class InsideSalesUser extends User
{

    public $userDetails;
    public $projectsThisYear;
    public $upcomingProjects;
    public $ongoingProjects;


    public function projectsThisYear() {
      $thisYear = Carbon::now()->subYear();
      $thisYear->format('Y-m-d');

      $projects = Project::
        where('bid_date', '>=', $thisYear)
        ->orderBy('bid_date', 'desc')
        //->with(['notes','productSales','insideSales'])
        ->get();

      return $projects;
    }

    public function upcomingProjects() {

      // if (empty($this->projectsThisYear)) {
      //   $this->projectsThisYear();
      // }

      $thisYear = Carbon::now()->subYear();

      // $projects = Project::where('inside_sales_id', $this->id)
      //   ->where([
      //     [ 'status_id', '!=', 3],  // Sold
      //     [ 'status_id', '!=', 5]   // Lost
      //   ])
      //   ->where('bid_date', '>=', $thisYear)
      //   ->orderBy('bid_date','desc')->get();

      $status_ids = [3,5];

      $projects = $this->projectsThisYear()
        ->whereNotIn('status_id', $status_ids)
        ->where('inside_sales_id', $this->id)
        //->load('productSales','insideSales')
        ->sortByDesc('bid_date');

      $now = Carbon::now();
      //$now->setTimezone('America/New_York');

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

      $thisYear = Carbon::now()->subYear()->format('Y-m-d');

      $status_ids = [1,2,4];

      // $projects = $this->projectsThisYear()
      //   ->whereIn('status_id', $status_ids)
      //   ->where('inside_sales_id',$this->id);

      $projects = Project::whereIn('status_id', $status_ids)
        ->where('inside_sales_id', $this->id)
        ->where('bid_date', '>=', $thisYear)
        ->get();


      //$this->ongoingProjects = $projects;
      return $projects;
    }

    public function userDetails() {
      // if (empty($this->userDetails)) {
      //   return $this->userDetails;
      // }

      $user = User::where('id', $this->id)->first();

      $collect = collect();

      $collect->put('name', $user->name);
      $collect->put('role', 'Inside Sales');

      $this->userDetails = $collect;
      return $this->userDetails;
    }

    public function getOngoingProjectsAttribute() {
      return $this->ongoingProjects();
    }

    public function getUpcomingProjectsAttribute() {
      return $this->upcomingProjects();
    }

    public function getUserDetailsAttribute() {
      return $this->userDetails();
    }

    public function getProjectsThisYearAttribute() {
      return $this->projectsThisYear();
    }






    protected $fillable = ['name','username'];
    protected $appends = ['userDetails','ongoingProjects','upcomingProjects','projectsThisYear'];
    protected $table = 'users';
}
