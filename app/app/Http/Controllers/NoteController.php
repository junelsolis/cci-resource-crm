<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use DB;
use Carbon\Carbon;
use App\ProjectNote;
use App\Project;

class NoteController extends Controller
{

    public function addNote(Request $request) {


      $project_id = $request['project_id'];
      if (empty($project_id)) {
        $project_id = $request['pk'];
      }

      $note = $request['note'];
      if (empty($note)) {
        $note = $request['value'];
      }

      if (empty($project_id) || empty($note)) {
        return redirect('/');
      }

      // retrieve project
      $project = Project::find($project_id);

      // check if allowed to add note
      if ($project->canAddNote() == false) {
        return redirect('/');
      }


      ProjectNote::create([
        'project_id' => $project->id,
        'last_updated_by_id' => session('logged_in_user_id'),
        'note' => $note
      ]);

      if ($request['pk']) {
        // return response('Note added.',200);
        return redirect()->back();
      }

      return redirect()->back();
    }


    public function editNote(Request $request) {


      $note_id = $request['pk'];
      $value = $request['value'];

      // check for null values
      if (empty($note_id) || empty($value)) {
        return redirect('/');
      }

      // retrieve note
      $note = ProjectNote::find($note_id);

      // if note not found return
      if (empty($note)) {
        return redirect('/');
      }

      // check allowed to edit
      if ($note->isEditor() == false) {
        return redirect('/');
      }

      $note->note = $value;
      $note->last_updated_by_id = session('logged_in_user_id');
      $note->save();


      return response('Note edited.',200);
    }

    public function deleteNote(Request $request) {
  

      // retrieve note
      $note = ProjectNote::find($request['id']);

      // check allowed to delete
      if ($note->isEditor() == false) {
        return redirect('/');
      }

      $note->delete();

      // return to previous view
      return redirect(session('_previous')['url']);
    }

    private function checkAllowedToDelete($note_id) {

      // retrieve note
      $note = DB::table('project_notes')->where('id', $note_id)->first();

      // get current user
      $user = session('logged_in_user_id');

      // check
      if ($user !== $note->last_updated_by_id) {
        return $false;
      }

      return true;

    }
    private function checkAllowedToAddOrDelete($project_id) {

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
