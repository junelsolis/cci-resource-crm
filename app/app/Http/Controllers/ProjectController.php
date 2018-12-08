<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProjectController extends Controller
{
    public function editName(Request $request) {
      $check = $this->checkAllowed();
      if ($check == false) {
        return response('Error 2700',404);
      }

      

      return response('Name changed.',200);
    }
    public function editStatus(Request $request) {}
    public function editBidDate(Request $request) {}
    public function editManufacturer(Request $request) {}
    public function editProduct(Request $request) {}
    public function editInsideSales(Request $request) {}
    public function editAmount(Request $request) {}
    public function eidtApcOppId(Request $request) {}
    public function editEngineer(Request $request) {}
    public function editContractor(Request $request) {}


    private function checkAllowed($project_id) {
      // verify logged in
      if (session()->has('logged_in_user_id')) {

      } else {
        session()->flush();
        return false;
      }

      // verify allowed to edit
      $logged_in_user_roles = session('logged_in_user_roles');

      if ($logged_in_user_roles->contains('product-sales') || $logged_in_user_roles->contains('inside-sales')) {
        return true;
      }

      session()->flush();
      return false;


    }
}
