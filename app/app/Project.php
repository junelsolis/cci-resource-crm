<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProjectNote;
use App\User;
use App\ProjectStatus;

class Project extends Model
{

    public function status() {
      return $this->hasOne('App\ProjectStatus','id','status_id');
    }

    public function productSales() {
      return $this->hasOne('App\User','id','product_sales_id');
    }

    public function insideSales() {
      return $this->hasMany('App\User', 'id', 'inside_sales_id');
    }

    public function notes() {
      return $this->hasMany('App\ProjectNote', 'project_id');
    }


    protected $table = 'projects';
}
