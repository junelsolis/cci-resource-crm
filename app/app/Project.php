<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProjectNote;
use App\User;
use App\ProjectStatus;
use Carbon\Carbon;
// use DB;

class Project extends Model
{

    public $status;
    public $formattedBidDate;
    public $formattedAmount;
    public $bidTiming;

    public static function boot() {

      parent::boot();

      self::created(function(Project $project){
        $note = new ProjectNote([
          'project_id' => $project->id,
          'note' => 'Project created.',
          'last_updated_by_id' => session('logged_in_user_id'),
        ]);

        $note->editable = false;

        $note->save();
      });
    }


    public function status() {
      $status = ProjectStatus::find($this->status_id);
      $this->status = $status;
      return $status;
    }

    public function productSales() {

      return $this->belongsTo('App\User','product_sales_id', 'id');
    }

    public function insideSales() {
      return $this->belongsTo('App\User', 'inside_sales_id', 'id');
    }

    public function notes() {
      return $this->hasMany('App\ProjectNote', 'project_id', 'id');
    }

    public function canAddNote() {
      $user_id = session('logged_in_user_id');


      // if product sales of this project, allow
      if ($user_id == $this->product_sales_id) { return true; }


      $user = User::find($user_id);
      // if inside sales, allow
      if (in_array('inside-sales', $user->roles())) { return true; }

      // if exec allow
      if (in_array('executive', $user->roles())) { return true; }

      return false;
    }
    public function formattedBidDate() {
      $bid_date = $this->bid_date;
      $bid_date = new \Carbon\Carbon($bid_date);
      $format = $bid_date->format('m/d/Y');

      $this->formattedBidDate = $format;

      return $format;
    }

    public function formattedAmount() {
      $format = '$' . number_format($this->amount);

      $this->formattedAmount = $format;
      return $format;
    }

    public function bidTiming() {

      $now = Carbon::now();
      $bidDate = new Carbon($this->bid_date);
      $nextWeek = Carbon::now()->addWeek();

      // late project
      if ( $bidDate->lessThan($now) && (($this->status_id == 1) || ($this->status_id == 4)) ) {
        $bidTiming = 'late';
        $this->bidTiming = $bidTiming;
        return $this->bidTiming;
      }

      // soon project
      if ($bidDate->greaterThanOrEqualTo($now) && $bidDate->lessThanOrEqualTo($nextWeek)) {
        $bidTiming = 'soon';
        $this->bidTiming = $bidTiming;
        return $this->bidTiming;
      }

      $this->bidTiming = 'ontime';
      return $this->bidTiming;
    }

    protected $table = 'projects';
}
