<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;
use App\User;
use Carbon\Carbon;

class ProjectNote extends Model
{

    public $formattedDate;
    public $userIsAuthor;
    public $author;

    public function project() {
      return $this->belongsTo('App\Project','project_id','id')->first();
    }

    public function author() {
      return $this->hasOne('App\User','id', 'last_updated_by_id')->first();

    }

    public function formattedDate() {
      if (empty($this->updated_at)) {
        $date = new Carbon($this->updated_at);
        $date->setTimezone('America/New_York');
        // $date->format('m/d/Y ');

        $this->formattedDate = $date->format('m/d/Y h:i a');
        return $this->formattedDate;

      }

      else {
        $date = new Carbon($this->created_at);
        $date->setTimezone('America/New_York');
        // $date->format('m/d/Y');

        $this->formattedDate = $date->format('m/d/Y h:i a');
        return $this->formattedDate;
      }
    }

    public function userIsAuthor() {
      $logged_in_user = session('logged_in_user_id');

      if ($this->last_updated_by_id == $logged_in_user) {
        $this->userIsAuthor = true;
        return $this->userIsAuthor;
      }

      else {
        $this->userIsAuthor = false;
        return $this->userIsAuthor;
      }
    }

    protected $fillable = ['project_id','last_updated_by_id','note','editable'];
    protected $table = 'project_notes';
}
