<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectStatus extends Model
{

    public function projects() {
      $this->hasMany('App\Project','id', 'status_id');
    }
    protected $table = 'project_status';

    protected $fillable = ['status'];
}
