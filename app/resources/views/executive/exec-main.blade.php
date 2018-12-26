<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Executive | CCI Tracker</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='{{ asset('css/bootstrap.css') }}'rel='stylesheet' />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/zf/dt-1.10.18/datatables.min.css"/>
    <link rel=stylesheet href="{{ asset('css/app.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/navbar.css') }}" />
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
    <div id='main' class='grid-x off-canvas-content' data-off-canvas-content>

      <!-- SALES SECTION -->
      <div id='sales' class='cell small-12'>
        <div class='card'>
          <h5><strong><i class="fas fa-dollar-sign"></i>&nbsp;Sales</strong></h5>

          <div class='grid-x'>
            <div class='cell medium-4'>
              <canvas id="sales-past-year"></canvas>
            </div>
            <div class='cell medium-4'>
              <canvas id="projected-sales"></canvas>
            </div>
            <div class='cell medium-4'>
              <canvas id='lost-bids'></canvas>
            </div>
          </div>
        </div>

        <!-- javascript for sales charts -->
        <script>
          var ctx = document.getElementById('sales-past-year').getContext('2d');
          var salesPastYear = new Chart(ctx, {
            type: 'line',
            data: {
              labels: {!! $chartData['months'] !!},
              datasets: [{
                data: {!! $chartData['sales'] !!},
                borderColor: "rgba(255,99,132,1)",
                fill: true,
                backgroundColor: "rgba(255,99,132,0.2)"
              }]
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



          var ctx = document.getElementById('projected-sales').getContext('2d');
          var projectedSales = new Chart(ctx, {
            type: 'line',
            data: {
              labels: {!! $chartData['nextSixMonths'] !!},
              datasets: [{
                data: {!! $chartData['projectedSales'] !!},
                borderColor: '#3e95cd',
                fill: true,
                backgroundColor: 'rgba(62,149,205,0.2)'
              }]
            },
            options: {
              maintainAspectRatio: false,
              title: {
                display: true,
                text: 'Projected Sales (Next 6 Months)'
              },
              legend: {
                display: false,
              }
            }
          });



          var ctx = document.getElementById('lost-bids').getContext('2d');
          var lostBids = new Chart(ctx, {
            type: 'line',
            data: {
              labels: {!! $chartData['months'] !!},
              datasets: [{
                data: {!! $chartData['lostBids'] !!},
                borderColor: "rgba(189, 195, 199,0.2)",
                fill: true,
                backgroundColor: "rgba(189, 195, 199,0.2)"
              }]
            },
            options: {
              maintainAspectRatio: false,
              title: {
                display: true,
                text: 'Lost Bids (Last 12 months)'
              },
              legend: {
                display: false,
              }
            }
          });


        </script>
      </div>
      <div class='cell small-12'>
          <div class='card'>
            <div class='grid-x'>
              <div class='cell medium-4' style='text-align:center;'>
                <span style='color:rgba(255,99,132,1);font-size:30px;font-weight:bold;'>
                  <?php
                    echo '$' . number_format($chartData['sales']->sum());
                  ?>
                </span><br />
                Sales Over Past 12 Months
              </div>
              <div class='cell medium-4' style='text-align:center;'>
                <span style='color:#3e95cd;font-size:30px;font-weight:bold;'>
                  <?php
                    echo '$' . number_format($chartData['projectedSales']->sum());
                   ?>
                </span><br />
                Projected Sales (Next 6 Months)
              </div>
              <div class='cell medium-4' style='text-align:center;'>
                <span style='color:rgba(189, 195, 199,1.0);font-size:30px;font-weight:bold;'>
                  <?php
                    echo '$' . number_format($chartData['lostBids']->sum());
                  ?>
                </span><br />
                Bids Lost (Last 12 Months)
              </div>
            </div>
        </div>

      </div>

      <!-- PROJECTS SECTIONS -->
      <div id='projects' class='cell small-12'>
        <div class='card' style='padding-bottom: 50px;'>
          <h5><strong><i class="fas fa-project-diagram"></i>&nbsp;Projects</strong></h5>
          <div class='grid-x'>
            <div class='cell medium-4'>
              <canvas id="project-counts"></canvas>
            </div>
            <div class='cell medium-4'>
              <canvas id="project-status"></canvas>
            </div>
            <div class='cell medium-4'>
              <canvas id='top-projects'></canvas>
            </div>
          </div>
        </div>

        <!-- javascript for projects charts -->
        <script>
          var ctx = document.getElementById("project-counts").getContext('2d');
          var projectCounts = new Chart(ctx, {
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



          var ctx = document.getElementById("project-status").getContext('2d');
          var projectStatus = new Chart(ctx, {
              type: 'doughnut',
              data: {
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
                  position: 'right',
                },
              }
          });


          var ctx = document.getElementById("top-projects").getContext('2d');
          var projectCounts = new Chart(ctx, {
              type: 'horizontalBar',
              data: {
                  labels: {!! $chartData['topProjects']->take(6)->pluck('name') !!},
                  datasets: [{
                      data: {!! $chartData['topProjects']->take(6)->pluck('amount') !!},
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
                  text: 'Top Projects (Last 12 months)'
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
      </div>

      <!-- more project stats -->
      <div class='cell small-12'>
        <div class='card'>
          <div class='grid-x'>
            <div class='cell medium-2'>
              <span class='stat'>{{ $upcomingProjects->count() }}</span><br />
              <spn class='stat-title'>Upcoming Projects</spn>
            </div>
            <div class='cell medium-2'>
              <span class='stat'>{{ $upcomingProjects->where('status_id',2)->count() }}</span><br />
              <span class='stat-title'>Quoted Projects</span>
            </div>
            <div class='cell medium-2'>
              <span class='stat'>{{ $projects->where('status_id',5)->count() }}</span><br />
              <span class='stat-title'>Lost Projects</span>
            </div>
            <div class='cell medium-2'>
              <span class='stat'>{{ $projects->count() }}</span><br />
              <span class='stat-title'>Total Projects (Last 12 mo)</span>
            </div>
          </div>
        </div>
      </div>
      <!-- table for projects -->
      <div class='cell small-12'>
        <div class='card'>
          <div class='table-scoll'>
            <table id='projects-table' class='unstriped display'>
              <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Bid Date</th>
                  <th>Manufacturer</th>
                  <th>Product</th>
                  <th>Product Sales</th>
                  <th>Inside Sales</th>
                  <th>Amount</th>
                  <th>APC OPP ID</th>
                  <th>Quote Link</th>
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

                      $status = $i->status()->status;
                      if ($status == 'New') { echo 'class=\'status-new\''; }
                      if ($status == 'Engineered') { echo 'class=\'status-engineered\''; }
                      if ($status == 'Sold') { echo 'class=\'status-sold\''; }
                      if ($status == 'Quoted') { echo 'class=\'status-quoted\''; }
                      if ($status == 'Lost') { echo 'class=\'status-lost\''; }
                    ?>
                  >{{ $status }}</td>
                  <td id='{{$i->id}}-bidDate'
                    <?php
                        if ($i->bidTiming() == 'late' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-late\'';}
                        if ($i->bidTiming() == 'soon' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-soon\''; }
                    ?>
                  >{{ $i->formattedBidDate() }}</td>
                  <td id='{{$i->id}}-manufacturer'>{{ $i->manufacturer }}</td>
                  <td id='{{$i->id}}-product'>{{ $i->product }}</td>
                  <td id='{{$i->id}}-productSales'>
                    <?php
                      $array = explode(' ', $i->productSales->name);
                      $name = substr($array[0],0,1) . ' ' . $array[1];
                      echo $name;
                    ?>
                  </td>
                  <td id='{{$i->id}}-insideSales'>
                    <?php
                      $array = explode(' ', $i->insideSales->name);
                      $name = substr($array[0],0,1) . ' ' . $array[1];
                      echo $name;
                    ?>
                  </td>
                  <td id='{{$i->id}}-amount'>{{ $i->formattedAmount() }}</td>
                  <td id='{{$i->id}}-apcOppId'>{{ $i->apc_opp_id }}</td>
                  <td id='{{$i->id}}-invoiceLink'>
                    @if (isset($i->invoice_link))
                    <a href='{{ $i->invoice_link }}' target='_blank'><i class="fas fa-link"></i></i></a>
                    @endif
                  </td>
                  <td id='{{$i->id}}-engineer'>{{ $i->engineer}}</td>
                  <td id='{{$i->id}}-contractor'>{{ $i->contractor }}</td>
                  <td>
                    <a class='table-note' data-toggle="{{$i->id}}-all-projects-info">{{ str_limit($i->notes->last()->note,20) }}</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

            <!-- initialize projects table js -->
            <script>
              $.fn.dataTable.moment( 'MM/DD/YYYY' );

              $('#projects-table').DataTable( {
                "order": [[ 3, 'desc']],
                'pageLength': 10,
              });
            </script>

            <!-- initialize editables -->
            <script>
              @foreach ($projects->chunk(10) as $chunk)
                @foreach ($chunk as $i)
                  $('#{{$i->id}}-name').editable(
                    {
                      container: 'body',
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
                      container: 'body',
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
                      container: 'body',
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
                      container: 'body',
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
                      container: 'body',
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
                      container: 'body',
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
                      container: 'body',
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
                      container: 'body',
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
                      container: 'body',
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
                      container: 'body',
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
                      container: 'body',
                      type: 'text',
                      pk: {{ $i->id }},
                      url: '/project/edit/contractor',
                      title: 'Enter Contractor',
                      disabled: true,
                      name: 'contractor',
                    }
                  );



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

                @endforeach
              @endforeach
            </script>
          </div>
        </div>
      </div>


      <!-- PEOPLE SECTION -->
      <div id='people' class='cell small-12'>
        <div class='card'>
          <h5><strong><i class="fas fa-users"></i>&nbsp;People</strong></h5>
          <div class='table-scroll'>
            <table id='product-sales-table' class='unstriped display'>
              <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Upcoming Projects</th>
                  <th>Projects Sold (Last 12 Months)</th>
                  <th>Sales (Last 12 Months)</th>
                  <th>Projected Sales (Next 6 Months)</th>
                  <th>Bids Lost (Last 12 Months)</th>
                </tr>
              </thead>
              <tbody>
                @if ($productSalesReps)
                @foreach ($productSalesReps->all() as $i)
                <tr>
                  <td><a data-toggle='{{ $i->id }}-person-info'><i class="fas fa-info-circle"></i></a></td>
                  <td>{{ $i->name }}</td>
                  <td>{{ $i->upcomingProjects->count() }}</td>
                  <td>{{ $i->projectsThisYear->where('status_id',3)->count() }}</td>
                  <td>${{ number_format($i->chartData['sales']->sum()) }}</td>
                  <td>${{ number_format($i->chartData['projectedSales']->sum()) }}</td>
                  <td>{{ $i->projectsThisYear->where('status_id',5)->count() }}</td>
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>

            <!-- initialize product sales table js -->
            <script>
              $('#product-sales-table').DataTable( {
                "order": [[ 2, 'desc']],
                'pageLength': 10,
              });
            </script>
          </div>
        </div>

      </div>
    </div>


    <!-- OFF-CANVAS DIVS -->
    <!-- project notes -->
    <!-- divs for off-canvas project information -->
    @foreach ($projects as $i)
      @include('project-info')
    @endforeach

    <!-- salesperson info -->
    @foreach ($productSalesReps->chunk(10) as $chunk)
      @foreach ($chunk as $i)
        <div class='off-canvas position-left person-info' id='{{$i->id}}-person-info' data-off-canvas data-auto-focus='false'>
        <div class='user-icon'>
          <i class="fas fa-user-circle"></i><br />
          <h4>{{ $i->name }}</h4>
        </div>
        <br /><br />
        <!-- sales stats -->
        <div class='grid-x'>
          <div class='cell small-12'>
            <span class='title'>Sales History</span>
          </div>
          <div class='cell small-6'>
            <span class='stat-sales'>${{ number_format($i->chartData['sales']->sum()) }}</span><br />
            <span class='stat-title'>Sales (Last 12 mo)</span>
          </div>
          <div class='cell small-6'>
            <span class='stat-projected'>${{ number_format($i->chartData['projectedSales']->sum()) }}</span><br />
            <span class='stat-title'>Projected Sales (6 mo)</span>
          </div>
          <div class='cell small-12'>
            <canvas id="{{$i->id}}-sales-chart"></canvas>
          </div>
          <div class='cell small-12'>
            <canvas id='{{$i->id}}-projected-sales-chart'></canvas>
          </div>
          <div class='cell small-12'>
            <canvas id='{{$i->id}}-project-status'></canvas>
          </div>
        </div>
      </div>
      @endforeach
    @endforeach

    <!-- charts for each salesperson -->
    @foreach ($productSalesReps->chunk(10) as $chunk)
    @foreach ($chunk as $i)
    <script>
      var personctx = document.getElementById('{{$i->id}}-sales-chart').getContext('2d');
      var salesChart = new Chart(personctx, {
        type: 'line',
        data: {
          labels: {!! $i->chartData['months'] !!},
          datasets: [{
            data: {!!  $i->chartData['sales'] !!},
            borderColor: "rgba(255,99,132,1)",
            fill: true,
            backgroundColor: "rgba(255,99,132,0.2)"
          }]
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



      var personctx = document.getElementById('{{$i->id}}-projected-sales-chart').getContext('2d');
      var projectSalesChart = new Chart(personctx, {
        type: 'line',
        data: {
          labels: {!! $i->chartData['nextSixMonths'] !!},
          datasets: [{
            data: {!!  $i->chartData['projectedSales'] !!},
            borderColor: '#3e95cd',
            fill: true,
            backgroundColor: 'rgba(62,149,205,0.2)'
          }]
        },
        options: {
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Projected Sales (Next 6 Months)'
          },
          legend: {
            display: false,
          }
        }
      });



      var personctx = document.getElementById("{{$i->id}}-project-status").getContext('2d');
      var projectStatus = new Chart(personctx, {
          type: 'doughnut',
          data: {
              labels: {!! $i->chartData['projectStatus']->pluck('name') !!},
              datasets: [{
                  data: {!! $i->chartData['projectStatus']->pluck('count') !!},
                  backgroundColor: [
                      'rgba(243,156,18,0.6)',
                      'rgba(41,128,185,0.6)',
                      'rgba(39,174,96,0.6)',
                      'rgba(142,68,173,0.6)',
                      'rgba(44,62,80,0.6)',
                  ],
                  borderColor: [
                    'rgba(243,156,18,1)',
                    'rgba(41,128,185,1)',
                    'rgba(39,174,96,1)',
                    'rgba(142,68,173,1)',
                    'rgba(44,62,80,1)',
                  ],
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
              position: 'right',
            },
          }
      });

    </script>
    @endforeach
    @endforeach



  </body>
  @include('footer')
  <script>
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }

    });

    $(document).foundation();
  </script>
</html>
