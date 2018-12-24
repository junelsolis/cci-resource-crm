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
      $collect->put('role', 'Executive');

      $this->userDetails = $collect;
      return $collect;
    }

    protected $table = 'users';
}
