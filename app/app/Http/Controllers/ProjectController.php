<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

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
      $product_sales_id = session('logged_in_user_id');
      $inside_sales_id = $request['inside_sales_id'];
      $amount = $request['amount'];
      $apc_opp_id = $request['apc_opp_id'];
      $invoice_link = $request['invoice_link'];
      $engineer = $request['engineer'];
      $contractor = $request['contractor'];
      $note = $request['note'];

      // insert project into database
      $project_id = DB::table('projects')->insertGetId([
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
        'created_at' => Carbon::now(),
      ]);

      // insert project creation note
      $now = Carbon::now();
      $nowString = $now->format('D, M d, Y g:i:s a');
      $creationNote = 'Project created by ' . session('logged_in_name') . ' on ' . $nowString;

      DB::table('project_notes')->insert([
        'project_id' => $project_id,
        'last_updated_by_id' => $product_sales_id,
        'note' => $creationNote,
        'created_at' => $now
      ]);

      // if user placed a note, insert it
      if (!empty($note)) {
        DB::table('project_notes')->where('id', $id)->insert([
          'project_id' => $project_id,
          'last_updated_by_id' => $product_sales_id,
          'note' => $note,
          'created_at' => $now->addSecond()
        ]);
      }

      // get previous URL
      $previous = session('_previous');
      $url = $previous['url'];

      return redirect($url);

    }

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
    public function editBidDate(Request $request) {
      $check = $this->checkAllowed();
      if ($check == false) {
        return response('Error 2700',404);
      }

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      DB::table('projects')->where('id', $id)->update([
        'bid_date' => $value,
        'updated_at' => Carbon::now()
      ]);

      // create note
      DB::table('project_notes')->insert([
        'project_id' => $id,
        'last_updated_by_id' => session('logged_in_user_id'),
        'note' => 'Bid date changed by ' . session('logged_in_name'),
        'created_at' => Carbon::now()
      ]);

    }
    public function editManufacturer(Request $request) {
      $check = $this->checkAllowed();
      if ($check == false) {
        return response('Error 2700',404);
      }

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      DB::table('projects')->where('id', $id)->update([
        'manufacturer' => $value,
        'updated_at' => Carbon::now()
      ]);

      // create note
      DB::table('project_notes')->insert([
        'project_id' => $id,
        'last_updated_by_id' => session('logged_in_user_id'),
        'note' => 'Manufacturer changed by ' . session('logged_in_name'),
        'created_at' => Carbon::now()
      ]);


    }
    public function editProduct(Request $request) {
      $check = $this->checkAllowed();
      if ($check == false) {
        return response('Error 2700',404);
      }

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      DB::table('projects')->where('id', $id)->update([
        'product' => $value,
        'updated_at' => Carbon::now()
      ]);

      // create note
      DB::table('project_notes')->insert([
        'project_id' => $id,
        'last_updated_by_id' => session('logged_in_user_id'),
        'note' => 'Product changed by ' . session('logged_in_name'),
        'created_at' => Carbon::now()
      ]);
    }
    public function editInsideSales(Request $request) {
      $check = $this->checkAllowed();
      if ($check == false) {
        return response('Error 2700',404);
      }

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      DB::table('projects')->where('id', $id)->update([
        'inside_sales_id' => $value,
        'updated_at' => Carbon::now()
      ]);

      // create note
      DB::table('project_notes')->insert([
        'project_id' => $id,
        'last_updated_by_id' => session('logged_in_user_id'),
        'note' => 'Inside Sales Representative changed by ' . session('logged_in_name'),
        'created_at' => Carbon::now()
      ]);
    }
    public function editAmount(Request $request) {
      $check = $this->checkAllowed();
      if ($check == false) {
        return response('Error 2700',404);
      }

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      DB::table('projects')->where('id', $id)->update([
        'amount' => $value,
        'updated_at' => Carbon::now()
      ]);

      // create note
      DB::table('project_notes')->insert([
        'project_id' => $id,
        'last_updated_by_id' => session('logged_in_user_id'),
        'note' => 'Amount changed by ' . session('logged_in_name'),
        'created_at' => Carbon::now()
      ]);
    }
    public function editApcOppId(Request $request) {
      $check = $this->checkAllowed();
      if ($check == false) {
        return response('Error 2700',404);
      }

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      DB::table('projects')->where('id', $id)->update([
        'apc_opp_id' => $value,
        'updated_at' => Carbon::now()
      ]);

      DB::table('project_notes')->insert([
        'project_id' => $id,
        'last_updated_by_id' => session('logged_in_user_id'),
        'note' => 'APC OPP ID changed by ' . session('logged_in_name')
      ]);

    }

    public function editQuote(Request $request) {
      $check = $this->checkAllowed();
      if ($check == false) {
        return response('Error 2700',404);
      }

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      DB::table('projects')->where('id', $id)->update([
        'invoice_link' => $value,
        'updated_at' => Carbon::now()
      ]);

      DB::table('project_notes')->insert([
        'project_id' => $id,
        'last_updated_by_id' => session('logged_in_user_id'),
        'note' => 'Quote link changed by ' . session('logged_in_name'),
        'created_at' => Carbon::now()
      ]);

    }

    public function editEngineer(Request $request) {
      $check = $this->checkAllowed();
      if ($check == false) {
        return response('Error 2700',404);
      }

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      DB::table('projects')->where('id', $id)->update([
        'engineer' => $value,
        'updated_at' => Carbon::now()
      ]);

      // create note
      DB::table('project_notes')->insert([
        'project_id' => $id,
        'last_updated_by_id' => session('logged_in_user_id'),
        'note' => 'Engineer changed by ' . session('logged_in_name'),
        'created_at' => Carbon::now()
      ]);
    }
    public function editContractor(Request $request) {
      $check = $this->checkAllowed();
      if ($check == false) {
        return response('Error 2700',404);
      }

      $name = $request['name'];
      $id = $request['pk'];
      $value = $request['value'];

      DB::table('projects')->where('id',$id)->update([
        'contractor' => $value,
        'updated_at' => Carbon::now()
      ]);

      DB::table('project_notes')->insert([
        'project_id' => $id,
        'last_updated_by_id' => session('logged_in_user_id'),
        'note' => 'Contractor changed by ' . session('logged_in_name'),
        'created_at' => Carbon::now()
      ]);
    }


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
