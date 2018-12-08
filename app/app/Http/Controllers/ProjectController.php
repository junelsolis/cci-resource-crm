<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class ProjectController extends Controller
{
    public function editName(Request $request) {
      $check = $this->checkAllowed();
      if ($check == false) {
        return response('Error 2700',404);
      }

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      // modify name
      DB::table('projects')->where('id', $id)->update([
        'name' => $value,
        'updated_at' => Carbon::now()
      ]);

      // add note entry
      DB::table('project_notes')->insert([
        'project_id' => $id,
        'last_updated_by_id' => session('logged_in_user_id'),
        'note' => 'Project name changed by ' . session('logged_in_name'),
        'created_at' => Carbon::now()
      ]);

      return response('Name changed.', 200);
    }
    public function editStatus(Request $request) {
      $check = $this->checkAllowed();
      if ($check == false) {
        return response('Error 2700',404);
      }

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      DB::table('projects')->where('id', $id)->update([
        'status_id' => $value,
        'updated_at' => Carbon::now()
      ]);

      // add note
      DB::table('project_notes')->insert([
        'project_id' => $id,
        'last_updated_by_id' => session('logged_in_user_id'),
        'note' => 'Status changed by ' . session('logged_in_name'),
        'created_at' => Carbon::now()
      ]);

      return response('Project status changed',200);
    }
    public function editBidDate(Request $request) {}
    public function editManufacturer(Request $request) {}
    public function editProduct(Request $request) {}
    public function editInsideSales(Request $request) {}
    public function editAmount(Request $request) {}
    public function eidtApcOppId(Request $request) {}
    public function editEngineer(Request $request) {}
    public function editContractor(Request $request) {}


    private function checkAllowed() {
      // verify logged in
      if (session()->has('logged_in_user_id')) {}
        else {
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
