<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProjectNote;
use App\User;
use App\ProjectStatus;

class Project extends Model
{

    public function status() {
      return $this->belongsTo('App\ProjectStatus','status_id', 'id');
    }

    public function productSales() {
      return $this->belongsTo('App\User','product_sales_id', 'id');
    }

    public function insideSales() {
      return $this->belongsTo('App\User', 'inside_sales_id', 'id');
    }

    public function notes() {
      return $this->hasMany('App\ProjectNote', 'project_id');
    }


    protected $table = 'projects';
}
