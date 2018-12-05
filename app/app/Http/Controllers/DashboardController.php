<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function selectUserRole() {

      $user_roles = session()->get('logged_in_user_roles');     // get user roles array stored in session

      if ($user_roles->contains('sales')) {
        return redirect('/sales');
      }

      if ($user_roles->contains('service')) {
        return redirect('/service');
      }

      if ($user_roles->contains('executive')) {
        return redirect('/exec');
      }

      if ($user_roles->contains('administrator')) {
        return redirect('admin');
      }

      return redirect('/');

    }
}
