<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProjectNote;
use App\User;
use App\ProjectStatus;
use Carbon\Carbon;

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

    public function formattedBidDate() {
      $bid_date = $this->bid_date;
      $bid_date = new \Carbon\Carbon($bid_date);

      $format = $bid_date->format('m/d/Y');

      return $format;
    }

    public function formattedAmount() {
      $format = '$' . number_format($this->amount);

      return $format;
    }

    public function bidTiming() {

      $now = Carbon::today();
      $bidDate = new Carbon($this->bid_date);

      $nextWeek = Carbon::today();
      $nextWeek->addWeek();

      $bidTiming;

      if ($bidDate->lessThan($now) && ($this->status_id == 1 || $this->status_id == 4)) {
        $bidTiming = 'late';
        $this->bidTiming = $bidTiming;

        return $bidTiming;
      }

      else if (($bidDate->greaterThanOrEqualTo($now)) && ($bidDate->lessThanOrEqualto($nextWeek))) {
        $bidTiming = 'soon';
        $this->bidTiming = $bidTiming;

        return $bidTiming;

      }

      else {
        $bidTiming = 'ontime';
        $this->bidTiming = $bidTiming;

        return $bidTiming;

      }

    }

    protected $table = 'projects';
}
