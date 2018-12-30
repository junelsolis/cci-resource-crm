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
    public $formattedName;

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

    public function formattedName() {
      $fullname = $this->name;

      $array = explode(' ', $fullname);

      $firstname = $array[0];
      $lastname = end($array);

      $initials = substr($firstname,0,1) . substr($lastname,0,1);

      $items = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'initials' => $initials,
      ];

      return $items;
    }




    public function getRolesAttribute() {
      return $this->roles();
    }

    public function getFormattedNameAttribute() {
      return $this->formattedName();
    }


    protected $appends = ['roles', 'formattedName'];
    protected $table = 'users';
}
