<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class NoteController extends Controller
{

    public function addNote(Request $request) {
      $check = $this->checkAllowedToAdd($request['project_id']);
      if ($check == false) { return redirect('/'); }

      $project_id = $request['project_id'];
      $user_id = session('logged_in_user_id');
      $note = $request['note'];
      $editable = $request['editable'];

      if (empty($editable)) {
        DB::table('project_notes')->insert([
          'project_id' => $project_id,
          'last_updated_by_id' => $user_id,
          'note' => $note,
          'created_at' => Carbon::now()
        ]);

      }

      else if ($editable == 1) {
        DB::table('project_notes')->insert([
          'project_id' => $project_id,
          'last_updated_by_id' => $user_id,
          'note' => $note,
          'editable' => true,
          'created_at' => Carbon::now()
        ]);
      }


      return redirect(session('_previous')['url']);
    }


    public function editNote(Request $request) {
      // $check = $this->checkIsAuthorAndEditable($request['pk']);
      // if ($check == false) { return redirect('/'); }

      $note_id = $request['pk'];
      $value = $request['value'];

      // retrieve note
      $note = DB::table('project_notes')->where('id', $note_id)->first();

      // compare old and new note. Return if unchanged
      if ($value == $note->note) {
        return;
      }
      
      DB::table('project_notes')->where('id', $note_id)->update([
        'note' => $value,
        'updated_at' => Carbon::now()
      ]);

      return response('Note edited.',200);
    }


    private function checkAllowedToAdd($project_id) {

      // retrieve project
      $project = DB::table('projects')->where('id', $project_id)->first();


      // check if user is a member of product sales, inside sales, or executive
      $roles = session('logged_in_user_roles');
      $check = false;

      // if inside sales or executive, return true
      if ($roles->contains('inside-sales') || $roles->contains('executive')) {
        return true;
      }

      // if product sales rep of project, return true
      if ($roles->contains('product-sales') && $project->product_sales_id == session('logged_in_user_id')) {
        return true;
      }


      return false;
    }

    private function checkIsAuthorAndEditable($note_id) {
      $note = DB::table('project_notes')->where('id', $note_id)->first();
      $author_id = $note->last_updated_by_id;

      if (session('logged_in_user_id') == $author_id) {
        if ($note->editable == true) {
          return true;
        }
        return false;
      }

      return false;

    }
}
