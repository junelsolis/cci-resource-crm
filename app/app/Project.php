<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProjectNote;
use App\User;
use App\ProjectStatus;
use Carbon\Carbon;
use DB;

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

      self::updated(function(Project $project) {

        $original = $project->getOriginal();

        // if name changed, create note
        if ($project->name != $original['name']) {
          ProjectNote::create([
            'project_id' => $project->id,
            'last_updated_by_id' => session('logged_in_user_id'),
            'note' => 'Project name changed.',
            'editable' => false
          ]);
        }

        // if status changed, create note
        if ($project->status_id != $original['status_id']) {
          ProjectNote::create([
            'project_id' => $project->id,
            'last_updated_by_id' => session('logged_in_user_id'),
            'note' => 'Status changed.',
            'editable' => false
          ]);
        }

        // if bid date changed, create note
        if ($project->bid_date != $original['bid_date']) {
          ProjectNote::create([
            'project_id' => $project->id,
            'last_updated_by_id' => session('logged_in_user_id'),
            'note' => 'Bid date changed.',
            'editable' => false,
          ]);
        }

        // if manufacturer changed
        if ($project->manufacturer != $original['manufacturer']) {
          ProjectNote::create([
            'project_id' => $project->id,
            'last_updated_by_id' => session('logged_in_user_id'),
            'note' => 'Manufacturer changed.',
            'editable' => false,
          ]);
        }

        // if product changed
        if ($project->product != $original['product']) {
          ProjectNote::create([
            'project_id' => $project->id,
            'last_updated_by_id' => session('logged_in_user_id'),
            'note' => 'Product changed.',
            'editable' => false
          ]);
        }

        // if product sales changed
        if ($project->product_sales_id != $original['product_sales_id']) {
          ProjectNote::create([
            'project_id' => $project->id,
            'last_updated_by_id' => session('logged_in_user_id'),
            'note' => 'Product Sales Rep changed.',
            'editable' => false,
          ]);
        }

        // if inside sales changed
        if ($project->inside_sales_id != $original['inside_sales_id']) {
          ProjectNote::create([
            'project_id' => $project->id,
            'last_updated_by_id' => session('logged_in_user_id'),
            'note' => 'Inside Sales Rep changed.',
            'editable' => false,
          ]);
        }

        // if amount changed, create note
        if ($project->amount != $original['amount']) {
          ProjectNote::create([
            'project_id' => $project->id,
            'last_updated_by_id' => session('logged_in_user_id'),
            'note' => 'Amount changed.',
            'editable' => false
          ]);
        }

        // if apc opp id changed
        if ($project->apc_opp_id != $original['apc_opp_id']) {
          ProjectNote::create([
            'project_id' => $project->id,
            'last_updated_by_id' => session('logged_in_user_id'),
            'note' => 'APC OPP ID changed.',
            'editable' => false
          ]);
        }

        // if invoice link changed
        if ($project->invoice_link != $original['invoice_link']) {
          ProjectNote::create([
            'project_id' => $project->id,
            'last_updated_by_id' => session('logged_in_user_id'),
            'note' => 'Quote link changed.',
            'editable' => false
          ]);
        }

        // if engineer changed
        if ($project->engineer != $original['engineer']) {
          ProjectNote::create([
            'project_id' => $project->id,
            'last_updated_by_id' => session('logged_in_user_id'),
            'note' => 'Engineer changed.',
            'editable' => false
          ]);
        }

        // if contractor changed
        if ($project->contractor != $original['contractor']) {
          ProjectNote::create([
            'project_id' => $project->id,
            'last_updated_by_id' => session('logged_in_user_id'),
            'note' => 'Contractor changed.',
            'editable' => false
          ]);
        }



      });
    }


    public function status() {
      // $status = ProjectStatus::find($this->status_id);
      // $this->status = $status;
      // return $status;

      // $status = DB::table('project_status')->where('id', $this->status_id)->first();
      //
      // $this->status = $status;
      // return $status;

      return $this->hasOne('App\ProjectStatus','id', 'status_id');

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
      // if ($user_id == $this->product_sales_id) { return true; }


      $user = User::find($user_id);

      // if product sales, allow
      if (in_array('product-sales', $user->roles())) { return true; }

      // if inside sales, allow
      if (in_array('inside-sales', $user->roles())) { return true; }

      // if exec allow
      if (in_array('executive', $user->roles())) { return true; }

      return false;
    }

    public function canEdit() {
      $user_id = session('logged_in_user_id');

      // if product sales of this project, allow
      if ($user_id == $this->product_sales_id) { return true; }

      $user = User::find($user_id);

      // if inside sales, allow
      if (in_array('inside-sales', $user->roles())) { return true; }

      // if exec allow
      if (in_array('inside_sales', $user->roles())) { return true; }

      // if admin allow
      if (in_array('administrator', $user->roles())) { return true; }

      return false;
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

    public function getBidTimingAttribute() {
      return $this->bidTiming();
    }

    public function getFormattedAmountAttribute() {
      return $this->formattedAmount();
    }

    public function getFormattedBidDateAttribute() {
      return $this->formattedBidDate();
    }

    protected $table = 'projects';
    protected $appends = ['formattedBidDate','bidTiming','formattedAmount'];
    protected $with = ['insideSales','productSales','status'];
    protected $fillable = [
      'name',
      'status_id',
      'bid_date',
      'manufacturer',
      'product',
      'product_sales_id',
      'inside_sales_id',
      'amount',
      'apc_opp_id',
      'invoice_link',
      'engineer',
      'contractor'
    ];
}
