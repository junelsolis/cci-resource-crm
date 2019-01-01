<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    public $userDetails;

    public function userDetails() {
    
      $user = User::where('id', $this->id)->first();

      $collect = collect();

      $collect->put('name', $user->name);
      $collect->put('role', 'administrator');

      return $collect;
    }


    public function getUserDetailsAttribute() {
      return $this->userDetails();
    }

    protected $appends = ['userDetails'];
    protected $table = 'users';
}
