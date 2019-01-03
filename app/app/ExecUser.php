<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ExecUser extends User
{
    public $userDetails;

    public function details() {

      $collect = collect();
      $collect->put('name', $this->name);
      $collect->put('role', 'System Administrator');

      $this->userDetails = $collect;
      return $collect;
    }

    public function getUserDetailsAttribute() {
      return $this->details();
    }

    protected $appends = ['userDetails'];
    protected $table = 'users';
}
