<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Product Sales | Critical Components</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='{{ asset('css/bootstrap.css') }}'rel='stylesheet' />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/zf/dt-1.10.18/datatables.min.css"/>
    <link rel=stylesheet href="{{ asset('css/app.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/foundation.min.js')}}"></script>
    <script src="{{ asset('js/Chart.min.js')}}"></script>
    <script src='{{ asset('js/bootstrap.min.js')}}'></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js'></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/zf/dt-1.10.18/datatables.min.js"></script>
    <script src='//cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js'></script>

  </head>
  @include('navbar')
  <body>
    @if ($errors->any())
    <div data-closable class="callout alert-callout-subtle warning radius">
      <strong>Error</strong><br />
      @foreach ($errors->all() as $error)
      {{ $error }}<br />;
      @endforeach
      <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
        <span aria-hidden="true">⊗</span>
      </button>
    </div>
    @endif

    @if (session('error'))
    <div data-closable class="callout alert-callout-subtle warning radius">
      <strong>Error</strong><br />{{ session('error') }}
      <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
        <span aria-hidden="true">⊗</span>
      </button>
    </div>
    @endif

    @if (session('change-password-error'))
    <div data-closable class="callout alert-callout-subtle warning radius">
      <strong>Error</strong><br />{{ session('change-password-error') }}
      <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
        <span aria-hidden="true">⊗</span>
      </button>
    </div>
    @endif

    @if (session('success'))
    <div data-closable class="callout alert-callout-subtle success radius">
      <strong>Success</strong><br />{!! session('success') !!}
      <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
        <span aria-hidden="true">⊗</span>
      </button>
    </div>

    @endif


    <!-- Off-canvas content -->
    <!-- add project div -->
    <div class='off-canvas position-left add-project' id='add-project' data-off-canvas data-auto-focus="false">
      <h4><i class="fas fa-plus"></i>&nbsp;New Project</h4>
      <br />
      <form method='post' action='/project/add'>
        {{ csrf_field() }}
        <fieldset class='fieldset'>
          <legend>
            Project Details
          </legend>

          <label>Project Name<span><i class="fas fa-star-of-life"></i></span></label>
          <input type='text' name='name' required />

          <label>Product<span><i class="fas fa-star-of-life"></i></span></label>
          <input type='text' name='product' required />

          <label>Manufacturer</label>
          <input type='text' name='manufacturer' />
        </fieldset>

        <fieldset class='fieldset'>
          <legend>
            Bid Information
          </legend>

          <label>Bid Date<span><i class="fas fa-star-of-life"></i></span></label>
          <input type='date' name='bid_date' required />

          <label>Status<span><i class="fas fa-star-of-life"></i></span></label>
          <select name='status_id' required>
            <option value="" selected disabled hidden>Select One</option>
            @foreach ($projectStatusCodes as $code)
            <option value='{{ $code->id }}'>{{ $code->status }}</option>
            @endforeach
          </select>

          <label>Amount<span><i class="fas fa-star-of-life"></i></span></label>
          <input type='number' name='amount' required placeholder='$' />

          <label>Inside Sales<span><i class="fas fa-star-of-life"></i></span></label>
          <select name='inside_sales_id' required>
            <option value="" selected disabled hidden>Select One</option>
            @foreach ($insideSales as $item)
            <option value='{{ $item->id }}'>{{ $item->name }}</option>
            @endforeach
          </select>
        </fieldset>

        <fieldset class='fieldset'>
          <legend>
            External Information
          </legend>
            <label>APC OPP ID</label>
            <input type='text' name='apc_opp_id' />

            <label>Quote Link</label>
            <input type='text' name='invoice_link' />
        </fieldset>

        <fieldset class='fieldset'>
          <legend>
            Additional Information
          </legend>
            <label>Engineer</label>
            <input type='text' name='engineer' />

            <label>Contractor</label>
            <input type='text' name='contractor' />
        </fieldset>

        <fieldset class='fieldset'>
          <legend>
            Note
          </legend>
          <textarea name='note' width='100%' placeholder='Optional note...'></textarea>
        </fieldset>

        <button type='submit' class='primary button align-right'><i class="fas fa-check"></i>&nbsp;Save</button>
      </form>
    </div>

    <!-- divs for off-canvas project information -->
    @foreach ($projects as $i)
      @include('project-info')
    @endforeach



    <div id='main' class='grid-x off-canvas-content' data-off-canvas-content data-equalizer>

      <div class='cell medium-6 large-4'>
        <div id='upcoming-projects' class='card' data-equalizer-watch>
          <h5><strong><i class="fas fa-clock"></i>&nbsp;Upcoming Projects</strong></h5>
          <br />
          <table class='unstriped'>
            <tbody>
              @foreach ($upcomingProjects as $item)
              <tr>
                <td
                  <?php
                    if ($item->bidTiming == 'late' && ($item->status->status != 'Quoted') && ($item->status->status != 'Sold') && ($item->status->status != 'Lost')) { echo 'class=\'bidTiming-late\'';}
                    if ($item->bidTiming == 'soon' && ($item->status->status != 'Quoted') && ($item->status->status != 'Sold') && ($item->status->status != 'Lost')) { echo 'class=\'bidTiming-soon\''; }
                  ?>><strong>{{ $item->bidDate }}</strong></td>
                <td
                  <?php
                    if ($item->status->status == 'New') { echo 'class=\'status-new\''; }
                    if ($item->status->status == 'Engineered') { echo 'class=\'status-engineered\''; }
                    if ($item->status->status == 'Sold') { echo 'class=\'status-sold\''; }
                    if ($item->status->status == 'Quoted') { echo 'class=\'status-quoted\''; }
                    if ($item->status->status == 'Lost') { echo 'class=\'status-lost\''; }
                  ?>
                >
                  {{ $item->status->status}}
                </td>

                <td>{{ $item->name}}</td>
                <td>{{ $item->amount }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class='cell medium-6 large-4'>
        <div class='card'  data-equalizer-watch>
          <h5><strong><i class="fas fa-chart-bar"></i>&nbsp;Sales</strong></h5>
          <div class='grid-x'>
            <div class='cell large-6'>
              <canvas id="chart2" height="180px"></canvas>
            </div>
            <div class='cell large-6'>
              <canvas id='projected-sales' height='180px'></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class='cell medium-12 large-4'>
        <div class='card' data-equalizer-watch>
          <h5><strong><i class="fas fa-chart-bar"></i>&nbsp;Projects</strong></h5>
          <div class='grid-x'>
            <div class='cell large-6'>
              <canvas id="projectStatus" height="180px"></canvas>
            </div>
            <div class='cell large-6'>
              <canvas id="projectCounts" height="180px"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- some project-related stats here -->
      <div class='cell small-12'>
        <div class='card'>
          <div class='grid-x'>

            <div class='cell medium-3'>
              <span class='stat' style='color:rgba(243,156,18,0.6);'>{{ $ongoingProjects->count() }}</span><br />
              <span class='stat-title'>Ongoing Projects</span>
            </div>
            <div class='cell medium-3'>
              <span class='stat' style='color:rgba(39,174,96,0.6);'>{{ $projects->count() }}</span><br />
              <span class='stat-title'>Total Projects (Last 12 mo)</span>
            </div>
            <div class='cell medium-3'>
              <span class='stat' style='color:rgba(255,99,132,1);'>${{ number_format($chartData['sales']->sum()) }}</span><br />
              <span class='stat-title'>Sales (Last 12 mo)</span>
            </div>
            <div class='cell medium-3'>
              <span class='stat' style='color:#3e95cd;'>${{ number_format($chartData['projectedSales']->sum()) }}</span><br />
              <span class='stat-title'>Projected Sales (Next 6 mo)</span>
            </div>
          </div>
        </div>
      </div>

      <div class='cell small-12'>
        <div id='projects' class='card'>
          <div class='grid-x align-middle'>
            <div class='cell small-6'>
              <h5><strong><i class="fas fa-project-diagram"></i>&nbsp;My Projects</strong></h5>
            </div>
            <div class='cell small-6' style='text-align:right;'>
              <a href='#' data-toggle="add-project"><i class="fas fa-plus"></i>&nbsp;Add Project</a>
            </div>
          </div>
          <br />
          <div class='table-scroll'>
            <table id='my-projects-table' class="unstriped">
              <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Bid Date</th>
                  <th>Manufacturer</th>
                  <th>Product</th>
                  <th>Inside Sales</th>
                  <th>Amount</th>
                  <th>APC OPP ID</th>
                  <th>Quote</th>
                  <th>Engineer</th>
                  <th>Contractor</th>
                  <th>Note</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($projects as $i)
                <tr>
                  <td><a id='{{$i->id}}-toggle' title='Click to Edit'><i class="fas fa-edit"></i></a></td>
                  <td id='{{$i->id}}-name'>{{ $i->name }}</td>
                  <td id='{{$i->id}}-status'
                    <?php
                      if ($i->status->status == 'New') { echo 'class=\'status-new\''; }
                      if ($i->status->status == 'Engineered') { echo 'class=\'status-engineered\''; }
                      if ($i->status->status == 'Sold') { echo 'class=\'status-sold\''; }
                      if ($i->status->status == 'Quoted') { echo 'class=\'status-quoted\''; }
                      if ($i->status->status == 'Lost') { echo 'class=\'status-lost\''; }
                    ?>
                  >{{ $i->status->status }}</td>
                  <td id='{{$i->id}}-bidDate'
                    <?php
                        if ($i->bidTiming == 'late' && ($i->status->status != 'Quoted') && ($i->status->status != 'Sold') && ($i->status->status != 'Lost')) { echo 'class=\'bidTiming-late\'';}
                        if ($i->bidTiming == 'soon' && ($i->status->status != 'Quoted') && ($i->status->status != 'Sold') && ($i->status->status != 'Lost')) { echo 'class=\'bidTiming-soon\''; }
                    ?>
                  >{{ $i->bidDate}}</td>
                  <td id='{{$i->id}}-manufacturer'>{{ $i->manufacturer}}</td>
                  <td id='{{$i->id}}-product'>{{ $i->product }}</td>
                  <td id='{{$i->id}}-insideSales'>{{ $i->insideSales->name }}</td>
                  <td id='{{$i->id}}-amount'>{{ $i->amount }}</td>
                  <td id='{{$i->id}}-apcOppId'>{{ $i->apc_opp_id }}</td>
                  <td id='{{$i->id}}-invoiceLink' >
                    @if (isset($i->invoice_link))
                    <a href='{{ $i->invoice_link }}' target='_blank'><i class="fas fa-link"></i></a>
                    @endif
                  </td>
                  <td id='{{$i->id}}-engineer'>{{ $i->engineer}}</td>
                  <td id='{{$i->id}}-contractor'>{{ $i->contractor }}</td>
                  <td><a class='table-note' data-toggle="{{$i->id}}-projects-info">{{ str_limit($i->notes->first()->note,20) }}</a></td>
                </tr>



                <div class='reveal' id='{{$i->id}}-notes-modal' data-reveal>
                  <button class="close-button" data-close aria-label="Close modal" type="button">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h4><strong>Project Notes</strong> &mdash; {{ $i->name }}</h4>
                  <br />
                  <!-- <i class="fas fa-plus"></i>&nbsp;Add Note -->
                  <form method='post' action='/note/add/{{ $i->id }}'>
                    {{ csrf_field() }}
                    <textarea name='note' placeholder="Add Note"></textarea>
                    <button type='submit' class='button button-primary' style='margin-top:10px;'><i class="fas fa-plus"></i>&nbsp;Add Note</button>
                  </form>
                  <br />
                  @foreach ($i->notes as $note)
                  <div class="note-card">
                    <span>{!! nl2br($note->note) !!}</span>
                    <br /><br />
                    <p style='color:grey;'>
                      <strong>{{ $note->author }}</strong> on {{ $note->date }}
                    </p>
                  </div>
                  @endforeach
                </div>

                <script>


                  // setup editables
                  $(document).ready(function() {
                    $('#{{$i->id}}-name').editable(
                      {
                        type: 'text',
                        pk: {{ $i->id }},
                        url: '/project/edit/name',
                        title: 'Enter Project Name',
                        disabled: true,
                        name: 'name',
                      }
                    );

                    $('#{{$i->id}}-status').editable(
                      {
                        type: 'select',
                        pk: {{ $i->id }},
                        url: '/project/edit/status',
                        title: 'Choose Status',
                        disabled: true,
                        name: 'status',
                        value: {{ $i->status_id}},
                          source: [
                            @foreach ($projectStatusCodes as $code)
                            { value: {{ $code->id }}, text: '{{ $code->status }}'},
                            @endforeach
                          ]
                      }
                    );

                    $('#{{$i->id}}-bidDate').editable(
                      {
                        type: 'date',
                        pk: {{ $i->id }},
                        url: '/project/edit/bid-date',
                        title: 'Select Bid Date',
                        disabled: true,
                        name: 'bidDate',
                        format: 'yyyy-mm-dd',
                        viewformat: 'mm/dd/yy',
                        datepicker: {
                          weekStart: 1
                        }
                      }
                    );


                    $('#{{$i->id}}-manufacturer').editable(
                      {
                        type: 'text',
                        pk: {{ $i->id }},
                        url: '/project/edit/manufacturer',
                        title: 'Enter Manufacturer',
                        disabled: true,
                        name: 'manufacturer',
                      }
                    );

                    $('#{{$i->id}}-product').editable(
                      {
                        type: 'text',
                        pk: {{ $i->id }},
                        url: '/project/edit/product',
                        title: 'Enter Product Name',
                        disabled: true,
                        name: 'product',
                      }
                    );

                    $('#{{$i->id}}-insideSales').editable(
                      {
                        type: 'select',
                        pk: {{ $i->id }},
                        url: '/project/edit/inside-sales',
                        title: 'Select Inside Sales Rep',
                        value: {{ $i->inside_sales_id }},
                        disabled: true,
                        name: 'insideSales',
                        source: [
                          @foreach ($insideSales as $item)
                          { value: {{ $item->id }}, text: '{{ $item->name }}'},
                          @endforeach
                        ]
                      }
                    );

                    $('#{{$i->id}}-amount').editable(
                      {
                        type: 'number',
                        pk: {{ $i->id }},
                        url: '/project/edit/amount',
                        title: 'Enter Amount',
                        disabled: true,
                        name: 'amount',
                      }
                    );

                    $('#{{$i->id}}-apcOppId').editable(
                      {
                        type: 'text',
                        pk: {{ $i->id }},
                        url: '/project/edit/apc-opp-id',
                        title: 'Enter APC OPP ID',
                        disabled: true,
                        name: 'apcOppId',
                      }
                    );

                    $('#{{$i->id}}-invoiceLink').editable(
                      {
                        type: 'text',
                        pk: {{ $i->id }},
                        url: '/project/edit/quote',
                        title: 'Edit Quote',
                        disabled: true,
                        name: 'quote'
                      }
                    );

                    $('#{{$i->id}}-engineer').editable(
                      {
                        type: 'text',
                        pk: {{ $i->id }},
                        url: '/project/edit/engineer',
                        title: 'Enter Engineer',
                        disabled: true,
                        name: 'engineer',
                      }
                    );

                    $('#{{$i->id}}-contractor').editable(
                      {
                        type: 'text',
                        pk: {{ $i->id }},
                        url: '/project/edit/contractor',
                        title: 'Enter Contractor',
                        disabled: true,
                        name: 'contractor',
                      }
                    );

                  });

                  // enable editing of row on click of toggle link
                  $('#{{$i->id}}-toggle').click(function(e) {
                    e.stopPropagation();
                    $('#{{$i->id}}-name').editable('toggleDisabled');
                    $('#{{$i->id}}-status').editable('toggleDisabled');
                    $('#{{$i->id}}-bidDate').editable('toggleDisabled');
                    $('#{{$i->id}}-manufacturer').editable('toggleDisabled');
                    $('#{{$i->id}}-product').editable('toggleDisabled');
                    $('#{{$i->id}}-insideSales').editable('toggleDisabled');
                    $('#{{$i->id}}-amount').editable('toggleDisabled');
                    $('#{{$i->id}}-apcOppId').editable('toggleDisabled');
                    $('#{{$i->id}}-invoiceLink').editable('toggleDisabled');
                    $('#{{$i->id}}-engineer').editable('toggleDisabled');
                    $('#{{$i->id}}-contractor').editable('toggleDisabled');


                    $('#{{$i->id}}-name').toggleClass('edit-enabled');
                    $('#{{$i->id}}-status').toggleClass('edit-enabled');
                    $('#{{$i->id}}-bidDate').toggleClass('edit-enabled');
                    $('#{{$i->id}}-manufacturer').toggleClass('edit-enabled');
                    $('#{{$i->id}}-product').toggleClass('edit-enabled');
                    $('#{{$i->id}}-insideSales').toggleClass('edit-enabled');
                    $('#{{$i->id}}-amount').toggleClass('edit-enabled');
                    $('#{{$i->id}}-apcOppId').toggleClass('edit-enabled');
                    $('#{{$i->id}}-invoiceLink').toggleClass('edit-enabled');
                    $('#{{$i->id}}-contractor').toggleClass('edit-enabled');
                  });


                </script>


                @endforeach
              </tbody>

            </table>

          </div>
          <div class='grid-x align-middle'>
            <div class='cell medium-6 large-2'>
              <a href='#upcoming-projects'><i class="fas fa-angle-double-up"></i>&nbsp;Back to Top</a>
            </div>
            <!-- <div class='cell medium-6 large-10'>
              <ul class='menu align-right'>
                <li><a href='#' data-open="add-project-modal"><i class="fas fa-plus"></i>&nbsp;Add Project</a></li>
                <li><input type='text' placeholder='Search for Project'/></li>
              </ul>
            </div> -->
          </div>
        </div>
      </div>


      <div class='cell small-12'>
        <div id='other-projects' class='card'>
          <div class='grid-x align-middle'>
            <div class='cell medium-6 large-2'>
              <h5><strong><i class="fas fa-users-cog"></i>&nbsp;Other Projects</strong></h5>
            </div>
            <div class='cell medium-6 large-10'>
              <!-- <ul class='menu align-right'>
                <li><input type='text' class='search' placeholder='Search Other Projects' /></li>
              </ul> -->

            </div>
          </div>
          <br />
          <div class='table-scroll'>
            <table id='other-projects-table' class='unstriped'>
              <thead>
                <tr>
                  <th>Sales Rep</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Bid Date</th>
                  <th>Manufacturer</th>
                  <th>Product</th>
                  <th>Inside Sales</th>
                  <th>Amount</th>
                  <th>APC OPP ID</th>
                  <th>Engineer</th>
                  <th>Contractor</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($otherProjects as $i)
                <tr>
                  <td>{{ $i->productSales->name }}</td>
                  <td>{{ $i->name }}</td>
                  <td>{{ $i->status->status }}</td>
                  <td>{{ $i->bidDate }}</td>
                  <td>{{ $i->manufacturer}}</td>
                  <td>{{ $i->product }}</td>
                  <td>{{ $i->insideSales->name }}</td>
                  <td>{{ $i->amount }}</td>
                  <td>{{ $i->apc_opp_id }}</td>
                  <td>{{ $i->engineer}}</td>
                  <td>{{ $i->contractor}}</td>
                </tr>
                @endforeach
              </tbody>

            </table>
          </div>
          <div class='grid-x align-middle'>
            <div class='cell medium-6 large-2'>
              <a href='#upcoming-projects'><i class="fas fa-angle-double-up"></i>&nbsp;Back to Top</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  @include('footer')
  <script>
    $(document).foundation();
    //$.fn.editable.defaults.mode = 'inline';

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }

    });

    $(document).ready(function() {

      $.fn.dataTable.moment( 'MM/DD/YYYY' );

      $('#my-projects-table').DataTable( {
        "order": [[ 3, 'desc']],
        'pageLength': 25,
      });

      $('#other-projects-table').DataTable( {
        "order": [[ 3, 'desc']],
        'pageLength': 10,
      });

    });

  </script>

  <!-- charts -->
  <script>
    var ctx = document.getElementById("chart2").getContext('2d');
    var chart2 = new Chart(document.getElementById("chart2"), {
      type: 'line',
      data: {
        labels: {!! $chartData['months'] !!},
        datasets: [{
            data: {!! $chartData['sales'] !!},
            label: "",
            borderColor: "rgba(255,99,132,1)",
            fill: true,
            backgroundColor: "rgba(255,99,132,0.2)"
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        title: {
          display: true,
          text: 'Sales (Last 12 months)'
        },
        legend: {
          display: false,
        }
      }
    });


    var ctx = document.getElementById("projected-sales").getContext('2d');
    var myChart2 = new Chart(document.getElementById("projected-sales"), {
      type: 'line',
      data: {
        labels: {!! $chartData['nextSixMonths'] !!},
        datasets: [{
            data: {!! $chartData['projectedSales'] !!},
            label: "",
            borderColor: "#3e95cd",
            fill: true,
            backgroundColor: 'rgba(62,149,205,0.2)'
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        title: {
          display: true,
          text: 'Projected Sales (Next 6 months)'
        },
        legend: {
          display: false,
        }
      }
    });


    var ctx = document.getElementById("projectStatus").getContext('2d');
    var projectStatus = new Chart(ctx, {
        type: 'doughnut',
        data: {
            // labels: ["New","Quoted","Sold","Engineered","Lost"],
            labels: {!! $chartData['projectStatus']->pluck('name') !!},
            datasets: [{
                data: {!! $chartData['projectStatus']->pluck('count') !!},
                backgroundColor: [
                    'rgba(243,156,18,0.6)',
                    'rgba(41,128,185,0.6)',
                    'rgba(39,174,96,0.6)',
                    'rgba(142,68,173,0.6)',
                    'rgba(44,62,80,0.6)',
                ],
                // borderColor: [
                //   'rgba(243,156,18,1)',
                //   'rgba(41,128,185,1)',
                //   'rgba(39,174,96,1)',
                //   'rgba(142,68,173,1)',
                //   'rgba(44,62,80,1)',
                // ],
                borderWidth: 1
            }]

        },
        options: {
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Project Status (Up to last 12 months)'
          },
          legend: {
            display: true,
            position: 'left',
          },
        }
    });





    var ctx = document.getElementById("projectCounts").getContext('2d');
    var myChart3 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! $chartData['months'] !!},
            datasets: [{
                data: {!! $chartData['projectCounts'] !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Project Counts (Last 12 months)'
          },
          legend: {
            display: false,
          },
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
              }]
          }
        }
    });


</script>
</html>
