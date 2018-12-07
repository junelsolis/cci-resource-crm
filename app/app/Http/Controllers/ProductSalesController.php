<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class ProductSalesController extends Controller
{
    public function showDashboard() {
      if ($this->checkLoggedIn()) {}
      else { return redirect('/'); }

      $userDetails = $this->getLoggedInUserDetails();
      $insideSales = $this->getInsideSalesReps();
      $projectStatusCodes = $this->getProjectStatusCodes();

      return view('product-sales/product-sales-main')
        ->with('userDetails', $userDetails)
        ->with('insideSales', $insideSales)
        ->with('projectStatusCodes', $projectStatusCodes);
    }

    public function addProject(Request $request) {
      if ($this->checkLoggedIn()) {}
      else { return redirect('/'); }

      $request->validate([
        'name' => 'required|string',
        'status_id' => 'required|integer',
        'bid_date' => 'required|date',
        'manufacturer' => 'nullable|string',
        'product' => 'required|string',
        'inside_sales_id' => 'required|integer',
        'amount' => 'required|numeric',
        'apc_opp_id' => 'nullable|string',
        'invoice_link' => 'nullable|string',
        'engineer' => 'nullable|string',
        'contractor' => 'nullable|string',
      ]);

      $this->createProject($request);

      return redirect('/product-sales')->with('success', 'Project added');
    }

    private function checkLoggedIn() {
      if (session()->has('logged_in_user_id') && session('logged_in_user_roles')->contains('product-sales')) {
        return true;
      }

      return false;
    }

    private function getLoggedInUserDetails() {
      /*  returns the user's full name
          and role
      */

      $user_id = session()->get('logged_in_user_id');     // get user id from session
      $name = DB::table('users')->where('id', $user_id)->pluck('name')->first();

      $role = 'Product Sales';

      $collect = collect([
        'name' => $name,
        'role' => $role
      ]);

      return $collect;
    }

    private function getInsideSalesReps() {
      /*  Returns a collection of inside salespersons
      */

      $sales = DB::table('user_roles')->select('user_id','role')->where('role','inside-sales')->distinct()->get();
      $sales = $sales->pluck('user_id');

      $users = DB::table('users')
        ->whereIn('id', $sales)
        ->orderBy('name')
        ->select('id', 'name')
        ->get();

      return $users;
    }

    private function getProjectStatusCodes() {
      /*  Returns a collection of project status
          including id and code
      */

      $codes = DB::table('project_status')->get();

      return $codes;
    }

    private function createProject($request) {
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
      $creationNote = 'Project created by ' . session('logged_in_named') . ' on ' . $nowString;

      DB::table('project_notes')->insert([
        'project_id' => $project_id,
        'last_updated_by_id' => $product_sales_id,
        'note' => $creationNote,
        'created_at' => $now
      ]);

      // if user placed a note, insert it
      if (!empty($note)) {
        DB::table('project_notes')->insert([
          'project_id' => $project_id,
          'last_updated_by_id' => $product_sales_id,
          'note' => $note,
          'created_at' => $now->addSecond()
        ]);
      }

      return;

    }
}
