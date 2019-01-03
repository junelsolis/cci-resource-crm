<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Project;
use App\ProjectNote;
use App\User;

class ProjectController extends Controller
{

    public function addProject(Request $request) {
      /*  takes in a HTTP request variable
          and uses it to create a new project
      */

      // check if user is allowed to add a project
      $user = User::find(session('logged_in_user_id'));

      if (in_array('product-sales', $user->roles())) {}
      elseif (in_array('inside_sales', $user->roles())) {}
      elseif (in_array('executive',$user->roles())) {}
      else {
        return redirect()->back();
      }

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


      // clean up bid date
      $bid_date = new Carbon($bid_date);
      $bid_date->format('Y-m-d');

      $inside_sales_id = $request['inside_sales_id'];
      $amount = $request['amount'];
      $apc_opp_id = $request['apc_opp_id'];
      $invoice_link = $request['invoice_link'];
      $engineer = $request['engineer'];
      $contractor = $request['contractor'];
      $note = $request['note'];


      // make sure link starts with http
      if (!empty($invoice_link)) {
        if ( (starts_with($invoice_link, 'http://')) || (starts_with($invoice_link, 'https://')) || (starts_with($invoice_link,'//')) ) { }

        else {
          $invoice_link = 'http://'.$invoice_link;
        }
      }


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



    }

    public function editName(Request $request) {


      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];



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

      // make sure link starts with http
      if (!empty($value)) {
        if (starts_with('http://',$value) || starts_with('https://',$value) || starts_with('//',$value)) {}

        else {
          $value = 'http://'.$value;
        }
      }

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

    public function delete(Request $request) {

      $id = $request['id'];

      // retrieve project
      $project = Project::find($id);

      $check = $project->canEdit();
      if ($check == false) {
        return response('Error 2700', 404);
      }

      // delete all project notes
      DB::table('project_notes')->where('project_id', $project->id)->delete();

      // delete project
      $project->delete();

      return redirect()->back()->with('success', 'Project <strong>' . $project->name . '</strong> has been deleted.');
    }


}
