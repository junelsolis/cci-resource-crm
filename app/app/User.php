<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;
use DB;


class User extends Model
{

    public function roles() {
      $roles = DB::table('user_roles')->where('user_id', $this->id)->select('user_id','role')->get();

      return $roles;
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



    protected $table = 'users';
}
