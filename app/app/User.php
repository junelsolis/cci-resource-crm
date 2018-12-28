<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;
use App\ProjectNote;
use DB;

use Carbon\Carbon;


class User extends Model
{

    public $roles;


    public function roles() {

      $array = array();
      $roles = DB::table('user_roles')->where('user_id', $this->id)->select('role')->get();

      foreach ($roles as $i) {
        $array[] = $i->role;
      }
      return $array;
    }

    public function notes() {
      return $this->hasMany('App\ProjectNote','last_updated_by_id', 'id');
    }


    public function getRolesAttribute() {
      return $this->roles();
    }


    protected $appends = ['roles'];
    protected $table = 'users';
}
