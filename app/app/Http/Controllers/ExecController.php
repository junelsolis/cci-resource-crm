<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Traits\PeopleData;
use App\Traits\ProjectData;
use App\Traits\ChartData;
use App\ExecUser;
use App\Project;

class ExecController extends Controller
{

    use PeopleData;
    use ProjectData;
    use ChartData;

    public function showDashboard() {
      if ($this->checkLoggedIn()) {}
      else { return redirect('/'); }

      $user = ExecUser::find(session('logged_in_user_id'));

      $userDetails = $user['userDetails'];
      $productSalesReps = $this->getProductSalesReps();

      // return $productSalesReps;
      $upcomingProjects = $this->getUpcomingProjects();

      $insideSalesReps = $this->getInsideSalesReps();
      $productSalesReps = $this->getProductSalesReps();

      $projectsThisYear = $this->projectsThisYear()->load([
        // 'insideSales:id,name',
        // 'productSales:id,name',
        //'notes.author:id,name',
        //'notes.project:id,name',
        // 'status'
      ]);
      $projectStatusCodes = $this->getProjectStatusCodes();
      $chartData = $this->execCharts();

      // set session key
      session(['current_section' => 'executive']);

      return view('executive/exec-main')
        ->with('userDetails', $userDetails)
        ->with('productSalesReps', $productSalesReps)
        ->with('projects', $projectsThisYear)
        ->with('chartData', $chartData)
        ->with('projectStatusCodes', $projectStatusCodes)
        ->with('insideSales', $insideSalesReps)
        ->with('productSales', $productSalesReps)
        ->with('upcomingProjects', $upcomingProjects);
    }

    private function getProjectStatusCodes() {
      /*  Returns a collection of project status
          including id and code
      */

      $codes = DB::table('project_status')->get();

      return $codes;
    }

    public function showProject(Request $request) {
      if ($this->checkLoggedIn()) {}
      else { return redirect('/'); }

      // set session key
      session(['current_section' => 'executive']);

      // set user
      $user = ExecUser::find(session('logged_in_user_id'));

      // if there is a project id in the request, use that
      $project = Project::find($request['id']);

      if (empty($project)) {
        $project = Project::whereRaw('id = (select max(`id`) from projects)')->first();
      }

      $project->load(['notes.author:id,name','productSales:id,name','insideSales:id,name']);

      // get other projects
      $otherProjects = $this->projectsThisYear()->load([
        // 'insideSales:id,name',
        // 'productSales:id,name',
        //'notes.author:id,name',
        //'notes.project:id,name',
        // 'status'
      ]);

      $projectStatusCodes = $this->getProjectStatusCodes();
      $productSalesReps = $this->getProductSalesReps();
      $insideSalesReps = $this->getInsideSalesReps();

      return view('executive.projects')
        ->with('userDetails', $user['userDetails'])
        ->with('project', $project)
        ->with('otherProjects', $otherProjects)
        ->with('projectStatusCodes', $projectStatusCodes)
        ->with('productSalesReps', $productSalesReps)
        ->with('insideSalesReps', $insideSalesReps);
    }

    public function showPeople(Request $request) {

      if ($this->checkLoggedIn()) {}
      else { return redirect('/'); }

      $user = ExecUser::find(session('logged_in_user_id'));

      $userDetails = $user['userDetails'];

      $productSalesReps = $this->getProductSalesReps();
      $insideSalesReps = $this->getInsideSalesReps();

      if (empty($request['id'])) {
        $rep = $productSalesReps->first();
      } else {
        $rep = $productSalesReps->where('id', $request['id'])->first();
      }

      $projectStatusCodes = $this->getProjectStatusCodes();


      return view('executive.people')->with([
        'userDetails' => $userDetails,
        'projectStatusCodes' => $projectStatusCodes,
        'productSalesReps' => $productSalesReps,
        'insideSalesReps' => $insideSalesReps,
        'rep' => $rep,

      ]);
    }

    private function checkLoggedIn() {
      if (session()->has('logged_in_user_id') && session('logged_in_user_roles')->contains('executive')) {
        return true;
      }

      return false;
    }
}
