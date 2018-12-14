<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class NoteController extends Controller
{

    public function addNote(Request $request) {
      $check = $this->checkAllowed($request['project_id']);
      if ($check == false) { return redirect('/'); }

      $project_id = $request['project_id'];
      $user_id = session('logged_in_user_id');
      $note = $request['note'];

      DB::table('project_notes')->insert([
        'project_id' => $project_id,
        'last_updated_by_id' => $user_id,
        'note' => $note,
        'created_at' => Carbon::now()
      ]);

      return redirect(session('_previous')['url']);
    }


    private function checkAllowed($project_id) {
      $user_id = session('logged_in_user_id');

      // retrieve project
      $project = DB::table('projects')->where('id', $project_id)->first();

      // check if user is member of inside sales
      $checkInsideSales = DB::table('user_roles')->where('user_id', $user_id)->where('role', 'inside-sales')->first();
      $isInsideSales = false;
      if (empty($checkInsideSales)) {}
      else { $isInsideSales = true; }

      // check if allowed to add note for project
      if (($project->product_sales_id != $user_id) && ($isInsideSales == false)) {
        return false;
      }

      return true;
    }
}
