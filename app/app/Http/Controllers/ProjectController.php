<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Project;
use App\ProjectNote;

class ProjectController extends Controller
{

    public function addProject(Request $request) {
      /*  takes in a HTTP request variable
          and uses it to create a new project
      */

      $name = $request['name'];
      $status_id = $request['status_id'];
      $bid_date = $request['bid_date'];
      $manufacturer = $request['manufacturer'];
      $product = $request['product'];


      /*  If product_sales_id is given in request, use that. Otherwise, use logged
          in user's
      */
      $product_sales_id = NULL;
      if (empty($request['product_sales_id']) == false) { $product_sales_id = $request['product_sales_id']; }
      else { $product_sales_id = session('logged_in_user_id'); }



      $inside_sales_id = $request['inside_sales_id'];
      $amount = $request['amount'];
      $apc_opp_id = $request['apc_opp_id'];
      $invoice_link = $request['invoice_link'];
      $engineer = $request['engineer'];
      $contractor = $request['contractor'];
      $note = $request['note'];


      // make sure link starts with http
      // if ((empty($invoice_link) == false) && starts_with('http://', $invoice_link) == false && starts_with('https://', $invoice_link) == false) {
      //   $invoice_link = 'http://'. $invoice_link;
      // }

      //
      // // insert project into database
      // $project_id = DB::table('projects')->insertGetId([
      //   'name' => $name,
      //   'status_id' => $status_id,
      //   'bid_date' => $bid_date,
      //   'manufacturer' => $manufacturer,
      //   'product' => $product,
      //   'product_sales_id' => $product_sales_id,
      //   'inside_sales_id' => $inside_sales_id,
      //   'amount' => $amount,
      //   'apc_opp_id' => $apc_opp_id,
      //   'invoice_link' => $invoice_link,
      //   'engineer' => $engineer,
      //   'contractor' => $contractor,
      //   'created_at' => Carbon::now(),
      //   'updated_at' => Carbon::now()
      // ]);
      //
      // // insert project creation note
      // $creationNote = 'Project created.';
      // $now = Carbon::now();
      //
      // DB::table('project_notes')->insert([
      //   'project_id' => $project_id,
      //   'last_updated_by_id' => session('logged_in_user_id'),
      //   'note' => $creationNote,
      //   'created_at' => $now
      // ]);


      $project = Project::create([
        'name' => $name,
        'status_id' => $status_id,
        'bid_date' => $bid_date,
        'manufacturer' => $manufacturer,
        'product' => $product,
        'product_sales_id' => $product_sales_id,
        'inside_sales_id' => $inside_sales_id,
        'amount' => $amount,
        'apc_opp_id' => $apc_opp_id,
        'invoice_link' => $invoice_link,
        'engineer' => $engineer,
        'contractor' => $contractor,
      ]);


      // $project->save();





      // if user placed a note, insert it
      // if (!empty($note)) {
      //   DB::table('project_notes')->insert([
      //     'project_id' => $project_id,
      //     'last_updated_by_id' => session('logged_in_user_id'),
      //     'note' => $note,
      //     'created_at' => $now->addSecond()
      //   ]);
      // }
      if (!empty($note)) {

        ProjectNote::create([
          'project_id' => $project->id,
          'last_updated_by_id' => session('logged_in_user_id'),
          'note' => $note,
        ]);
      }



      //get previous URL
      $previous = session('_previous');
      $url = $previous['url'];

      return redirect($url);

      // return response()->json([
      //   'status' => 'Project created.'
      // ]);

    }

    public function editName(Request $request) {


      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      // $check = $this->checkAllowed($id);
      // if ($check == false) {
      //   return response('Error 2700',404);
      // }
      //
      // // modify name
      // DB::table('projects')->where('id', $id)->update([
      //   'name' => $value,
      //   'updated_at' => Carbon::now()
      // ]);
      //
      // // add note entry
      // DB::table('project_notes')->insert([
      //   'project_id' => $id,
      //   'last_updated_by_id' => session('logged_in_user_id'),
      //   'note' => 'Project name changed',
      //   'created_at' => Carbon::now()
      // ]);


      // get project
      $project = Project::find($id);

      $check = $project->canEdit();
      if ($check == false) {
        return response('Error 2700', 404);
      }

      // change name
      $project->name = $value;
      $project->save();


      return response('Name changed.', 200);
    }
    public function editStatus(Request $request) {


      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      // $check = $this->checkAllowed($id);
      // if ($check == false) {
      //   return response('Error 2700',404);
      // }
      //
      // DB::table('projects')->where('id', $id)->update([
      //   'status_id' => $value,
      //   'updated_at' => Carbon::now()
      // ]);
      //
      // // add note
      // DB::table('project_notes')->insert([
      //   'project_id' => $id,
      //   'last_updated_by_id' => session('logged_in_user_id'),
      //   'note' => 'Status changed.',
      //   'created_at' => Carbon::now()
      // ]);

      // retrieve project
      $project = Project::find($id);

      $check = $project->canEdit();
      if ($check == false) {
        return response('Error 2700', 404);
      }

      $project->status_id = $value;
      $project->save();

      return response('Project status changed',200);
    }
    public function editBidDate(Request $request) {

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      // $check = $this->checkAllowed($id);
      // if ($check == false) {
      //   return response('Error 2700',404);
      // }

      // DB::table('projects')->where('id', $id)->update([
      //   'bid_date' => $value,
      //   'updated_at' => Carbon::now()
      // ]);
      //
      // // create note
      // DB::table('project_notes')->insert([
      //   'project_id' => $id,
      //   'last_updated_by_id' => session('logged_in_user_id'),
      //   'note' => 'Bid date changed.',
      //   'created_at' => Carbon::now()
      // ]);

      // retrieve project
      $project = Project::find($id);

      $check = $project->canEdit();
      if ($check == false) {
        return response('Error 2700', 404);
      }

      $project->bid_date = $value;
      $project->save();

      return response('Bid date changed.',200);

    }
    public function editManufacturer(Request $request) {


      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      // $check = $this->checkAllowed($id);
      // if ($check == false) {
      //   return response('Error 2700',404);
      // }
      //
      // DB::table('projects')->where('id', $id)->update([
      //   'manufacturer' => $value,
      //   'updated_at' => Carbon::now()
      // ]);
      //
      // // create note
      // DB::table('project_notes')->insert([
      //   'project_id' => $id,
      //   'last_updated_by_id' => session('logged_in_user_id'),
      //   'note' => 'Manufacturer changed.',
      //   'created_at' => Carbon::now()
      // ]);

      // retrieve project
      $project = Project::find($id);

      $check = $project->canEdit();
      if ($check == false ) {
        return response('Error 2700', 404);
      }

      $project->manufacturer = $value;
      $project->save();

      return response('Manufacturer changed.',200);


    }
    public function editProduct(Request $request) {

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      // $check = $this->checkAllowed($id);
      // if ($check == false) {
      //   return response('Error 2700',404);
      // }
      //
      // DB::table('projects')->where('id', $id)->update([
      //   'product' => $value,
      //   'updated_at' => Carbon::now()
      // ]);
      //
      // // create note
      // DB::table('project_notes')->insert([
      //   'project_id' => $id,
      //   'last_updated_by_id' => session('logged_in_user_id'),
      //   'note' => 'Product changed.',
      //   'created_at' => Carbon::now()
      // ]);

      // retrieve project
      $project = Project::find($id);

      $check = $project->canEdit();
      if ($check == false) {
        return response('Error 2700', 404);
      }

      $project->product = $value;
      $project->save();

      return response('Product changed.', 200);
    }

    public function editProductSales(Request $request) {

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      // $check = $this->checkAllowed($id);
      // if ($check == false) {
      //   return response('Error 2700',404);
      // }
      //
      // // update product sales id
      // DB::table('projects')->where('id', $id)->update([
      //   'product_sales_id' => $value,
      //   'updated_at' => Carbon::now()
      // ]);
      //
      // // create note
      // DB::table('project_notes')->insert([
      //   'project_id' => $id,
      //   'last_updated_by_id' => session('logged_in_user_id'),
      //   'note' => 'Changed Product Sales Representative.',
      //   'created_at' => Carbon::now()
      // ]);

      // retrieve project
      $project = Project::find($id);

      $check = $project->canEdit();
      if ($check == false) {
        return response('Error 2700', 404);
      }

      $project->product_sales_id = $value;
      $project->save();

      return response('Product Sales Rep changed.',200);

    }


    public function editInsideSales(Request $request) {


      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      // $check = $this->checkAllowed($id);
      // if ($check == false) {
      //   return response('Error 2700',404);
      // }
      //
      // DB::table('projects')->where('id', $id)->update([
      //   'inside_sales_id' => $value,
      //   'updated_at' => Carbon::now()
      // ]);
      //
      // // create note
      // DB::table('project_notes')->insert([
      //   'project_id' => $id,
      //   'last_updated_by_id' => session('logged_in_user_id'),
      //   'note' => 'Changed Inside Sales Representative.',
      //   'created_at' => Carbon::now()
      // ]);

      // retrieve project
      $project = Project::find($id);

      $check = $project->canEdit();
      if ($check == false) {
        return response('Error 2700',404);
      }


      $project->inside_sales_id = $value;
      $project->save();

      return response('Inside Sales Rep changed.',200);

    }
    public function editAmount(Request $request) {


      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      // $check = $this->checkAllowed($id);
      // if ($check == false) {
      //   return response('Error 2700',404);
      // }
      //
      // DB::table('projects')->where('id', $id)->update([
      //   'amount' => $value,
      //   'updated_at' => Carbon::now()
      // ]);
      //
      // // create note
      // DB::table('project_notes')->insert([
      //   'project_id' => $id,
      //   'last_updated_by_id' => session('logged_in_user_id'),
      //   'note' => 'Amount changed.',
      //   'created_at' => Carbon::now()
      // ]);


      // retrieve project
      $project = Project::find($id);

      $check = $project->canEdit();
      if ($check == false) {
        return response('Error 2700', 404);
      }

      $project->amount = $value;
      $project->save();

      return response('Amount changed.',200);


    }
    public function editApcOppId(Request $request) {

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      // $check = $this->checkAllowed($id);
      // if ($check == false) {
      //   return response('Error 2700',404);
      // }
      //
      // DB::table('projects')->where('id', $id)->update([
      //   'apc_opp_id' => $value,
      //   'updated_at' => Carbon::now()
      // ]);
      //
      // DB::table('project_notes')->insert([
      //   'project_id' => $id,
      //   'last_updated_by_id' => session('logged_in_user_id'),
      //   'note' => 'APC OPP ID changed.',
      // ]);

      // retrieve project
      $project = Project::find($id);

      $check = $project->canEdit();
      if ($check == false) {
        return response('Error 2700', 404);
      }

      $project->apc_opp_id = $value;
      $project->save();

      return response('APC OPP ID changed.',200);

    }

    public function editQuote(Request $request) {

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      // $check = $this->checkAllowed($id);
      // if ($check == false) {
      //   return response('Error 2700',404);
      // }
      //
      // // make sure link starts with http
      // if (starts_with('http://', $value) == false && starts_with('https://', $value) == false) {
      //   $value = 'http://'. $value;
      // }
      //
      // DB::table('projects')->where('id', $id)->update([
      //   'invoice_link' => $value,
      //   'updated_at' => Carbon::now()
      // ]);
      //
      // DB::table('project_notes')->insert([
      //   'project_id' => $id,
      //   'last_updated_by_id' => session('logged_in_user_id'),
      //   'note' => 'Quote link changed.',
      //   'created_at' => Carbon::now()
      // ]);

      // retrieve project
      $project = Project::find($id);

      $check = $project->canEdit();
      if ($check == false) {
        return response('Error 2700', 404);
      }

      $project->invoice_link = $value;
      $project->save();

      return response('Quote link changed.', 200);


    }

    public function editEngineer(Request $request) {

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      // $check = $this->checkAllowed($id);
      // if ($check == false) {
      //   return response('Error 2700',404);
      // }
      //
      // DB::table('projects')->where('id', $id)->update([
      //   'engineer' => $value,
      //   'updated_at' => Carbon::now()
      // ]);
      //
      // // create note
      // DB::table('project_notes')->insert([
      //   'project_id' => $id,
      //   'last_updated_by_id' => session('logged_in_user_id'),
      //   'note' => 'Engineer changed.',
      //   'created_at' => Carbon::now()
      // ]);

      // retrieve project
      $project = Project::find($id);

      $check = $project->canEdit();
      if ($check == false) {
        return response('Error 2700', 404);
      }


      $project->engineer = $value;
      $project->save();

      return response('Engineer changed.',200);

    }
    public function editContractor(Request $request) {

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      // $check = $this->checkAllowed($id);
      // if ($check == false) {
      //   return response('Error 2700',404);
      // }
      //
      // DB::table('projects')->where('id',$id)->update([
      //   'contractor' => $value,
      //   'updated_at' => Carbon::now()
      // ]);
      //
      // DB::table('project_notes')->insert([
      //   'project_id' => $id,
      //   'last_updated_by_id' => session('logged_in_user_id'),
      //   'note' => 'Contractor changed.',
      //   'created_at' => Carbon::now()
      // ]);

      // retrieve project
      $project = Project::find($id);

      $check = $project->canEdit();
      if ($check == false) {
        return response('Error 2700', 404);
      }

      $project->contractor = $value;
      $project->save();

      return response('Contractor changed.',200);
    }


    // private function checkAllowed($project_id) {
    //   // verify logged in
    //   if (session()->has('logged_in_user_id')) {}
    //     else {
    //     session()->flush();
    //     return false;
    //   }
    //
    //   // get project
    //   $project = DB::table('projects')->where('id', $project_id)->first();
    //
    //   // verify allowed to edit
    //   $logged_in_user_roles = session('logged_in_user_roles');
    //
    //   if ($logged_in_user_roles->contains('inside-sales')) { return true; }
    //   if ($logged_in_user_roles->contains('executive')) { return true; }
    //
    //   if ($logged_in_user_roles->contains('product-sales') && $project->product_sales_id == session('logged_in_user_id')) { return true; }
    //
    //   session()->flush();
    //   return false;
    //
    //
    // }
}
