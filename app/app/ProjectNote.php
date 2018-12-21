<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectNote extends Model
{


    protected $fillable = ['project_id','last_updated_by_id','note','editable'];
    protected $table = 'project_notes';
}
