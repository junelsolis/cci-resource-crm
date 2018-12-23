<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;

class ProjectNote extends Model
{



    protected $fillable = ['project_id','last_updated_by_id','note'];
    protected $table = 'project_notes';
}
