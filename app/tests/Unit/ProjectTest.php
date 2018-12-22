<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

use App\Project;
use App\ProjectStatus;
use App\ProjectNote;
use App\User;
use Carbon\Carbon;

class ProjectTest extends TestCase
{

    //use DatabaseMigrations;
    use RefreshDatabase;

    private $project;
    private $status;
    private $productSalesUser;
    private $insideSalesUser;
    private $note;

    public function setUp() {
      parent::setUp();

      $this->productSalesUser = factory('App\User')->create([
        'id' => 3
      ]);

      $this->insideSalesUser = factory('App\User')->create([
        'id' => 5
      ]);

      $this->status = factory('App\ProjectStatus')->create();

      $this->project = factory('App\Project')->create([
        'status_id' => 1,
        'bid_date' => new Carbon('first day of September 2018'),
        'amount' => 6000,
        'product_sales_id' => $this->productSalesUser->id,
        'inside_sales_id' => $this->insideSalesUser->id,
      ]);

      $this->note = ProjectNote::create([
        'id' => 22,
        'project_id' => $this->project->id,
        'last_updated_by_id' => $this->productSalesUser->id,
        'note' => 'Project added. This is a note.',
      ]);


    }

    /** @test */
    public function a_project_has_a_status() {

      $this->assertSame('New', $this->project->status->status);
      $this->assertEquals($this->project->status->id, 1);
    }

    /** @test */
    public function a_project_has_product_sales() {
      $this->assertNotNull($this->project->productSales);
      $this->assertTrue(is_string($this->project->productSales->name));
    }

    /** @test */
    public function a_project_has_inside_sales() {

      $this->assertNotNull($this->project->insideSales);
      $this->assertTrue(is_string($this->project->insideSales->name));
    }

    /** @test */
    public function a_project_has_notes() {
      $this->assertNotNull($this->project->notes);
      $this->assertSame('Project added. This is a note.', $this->project->notes->first()->note);
    }

    /** @test */
    public function a_project_has_formatted_bid_date() {

      $this->assertSame('09/01/2018', $this->project->formattedBidDate());
    }

    /** @test */
    public function a_project_has_formatted_amount() {
      $this->assertSame('$6,000', $this->project->formattedAmount());
    }

    /** @test */
    public function a_project_calculates_bid_timing() {

      $soon = factory('App\Project',5)->create([
        'bid_date' => Carbon::tomorrow()
      ]);

      $nextWeek = Carbon::today();
      $nextWeek->addDays(8);

      $nextWeek = factory('App\Project')->create([
        'bid_date' => $nextWeek
      ]);

      $nextMonth = factory('App\Project')->create([
        'bid_date' => new Carbon('next month')
      ]);

      $late = factory('App\Project',2)->create([
        'bid_date' => Carbon::yesterday()

      ]);

      $ontime_quoted = factory('App\Project', 3)->create([
        'bid_date' => Carbon::yesterday(),
        'status_id' => 2
      ]);

      $ontime_engineered = factory('App\Project', 6)->create([
        'bid_date' => Carbon::yesterday(),
        'status_id' => 4
      ]);


      $this->assertTrue($nextWeek->bidTiming() == 'ontime');
      $this->assertTrue($nextMonth->bidTiming() == 'ontime');

      $this->assertTrue($soon[4]->bidTiming() == 'soon');
      $this->assertTrue($late[1]->bidTiming() == 'late');

      $this->assertTrue($ontime_quoted->first()->bidTiming() == 'ontime');
    }


}
