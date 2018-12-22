<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;
use DB;

use Carbon\Carbon;


class User extends Model
{

    public function roles() {

      $array = array();
      $roles = DB::table('user_roles')->where('user_id', $this->id)->select('role')->get();

      foreach ($roles as $i) {
        $array[] = $i->role;
      }
      return $array;
    }

    public function productSalesProjects() {
      // $this->hasMany('App\Project','id','product_sales_id');

      $projects = DB::table('projects')->where('product_sales_id', $this->id)->get();

      return $projects;
    }

    public function insideSalesProjects() {

      $projects = DB::table('projects')->where('inside_sales_id', $this->id)->get();

      return $projects;

    }


    public function upcomingProjects() {

      $projects = DB::table('projects')
        ->where('product_sales_id', $this->id)
        ->orderBy('bid_date','desc')->get();

      $now = Carbon::now();

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

    public function projectsLastYear() {
      $now = Carbon::today();
      // $now->setTimezone('America/New_York');
      $now->subYear();

      $projects = DB::table('projects')
        ->orderBy('bid_date')
        ->where('bid_date', '>=', $now)
        ->get();

      return $projects;
    }



    protected $table = 'users';
}
