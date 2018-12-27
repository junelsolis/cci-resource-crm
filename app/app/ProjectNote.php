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
    public $isEditor;
    // public $author;

    public function project() {
      // return $this->belongsTo('App\Project','project_id','id')->first();
      return $this->belongsTo('App\Project','project_id','id');

    }

    public function author() {
      return $this->belongsTo('App\User','last_updated_by_id','id');

    }

    public function isEditor() {
      $user_id = session('logged_in_user_id');
      // $product_sales_id = $this->project->product_sales_id;
      // $inside_sales_id = $this->project->inside_sales_id;

      // if user is author of note, allow
      if ($user_id == $this->author->id) { $this->isEditor = true; return true; }

      //  if user is product sales of project, return true
      if ($user_id == $this->project->product_sales_id) { $this->isEditor = true; return true; }

      // if ($user_id == $inside_sales_id) { return true; }

      // if user is inside sales, return true
      if (session('logged_in_user_roles')->contains('inside-sales')) { $this->isEditor = true; return true; }

      // if user is exec, return true
      // $user = User::find($user_id);
      if (session('logged_in_user_roles')->contains('executive')) { $this->isEditor = true; return true; }



      $this->isEditor = false;
      return false;


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

    public function getIsEditorAttribute() {
      return $this->isEditor();
    }

    protected $appends = ['isEditor'];
    protected $fillable = ['project_id','last_updated_by_id','note','editable'];
    protected $table = 'project_notes';

}
