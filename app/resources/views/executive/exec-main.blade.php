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
          <h5><strong><i class="fas fa-users"></i>&nbsp;Sales</strong></h5>

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
          <h5><strong><i class="fas fa-users"></i>&nbsp;Projects</strong></h5>
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
                  <td></td>
                  <td>{{ $i->name }}</td>
                  <td
                    <?php
                      if ($i->status->status == 'New') { echo 'class=\'status-new\''; }
                      if ($i->status->status == 'Engineered') { echo 'class=\'status-engineered\''; }
                      if ($i->status->status == 'Sold') { echo 'class=\'status-sold\''; }
                      if ($i->status->status == 'Quoted') { echo 'class=\'status-quoted\''; }
                      if ($i->status->status == 'Lost') { echo 'class=\'status-lost\''; }
                    ?>
                  >{{ $i->status->status }}</td>
                  <td
                    <?php
                        if ($i->bidTiming == 'late' && ($i->status->status != 'Quoted') && ($i->status->status != 'Sold') && ($i->status->status != 'Lost')) { echo 'class=\'bidTiming-late\'';}
                        if ($i->bidTiming == 'soon' && ($i->status->status != 'Quoted') && ($i->status->status != 'Sold') && ($i->status->status != 'Lost')) { echo 'class=\'bidTiming-soon\''; }
                    ?>
                  >{{ $i->bidDate }}</td>
                  <td>{{ $i->manufacturer }}</td>
                  <td>{{ $i->product }}</td>
                  <td>
                    <?php
                      $array = explode(' ', $i->productSales->name);
                      $name = substr($array[0],0,1) . ' ' . $array[1];
                      echo $name;
                    ?>
                  </td>
                  <td>
                    <?php
                      $array = explode(' ', $i->insideSales->name);
                      $name = substr($array[0],0,1) . ' ' . $array[1];
                      echo $name;
                    ?>
                  </td>
                  <td>{{ $i->amount }}</td>
                  <td>{{ $i->apc_opp_id }}</td>
                  <td>
                    @if (isset($i->invoice_link))
                    <a href='{{ $i->invoice_link }}' target='_blank'><i class="fas fa-link"></i></i></a>
                    @endif
                  </td>
                  <td>{{ $i->engineer}}</td>
                  <td>{{ $i->contractor }}</td>
                  <td>
                    <a class='table-note' data-toggle="{{$i->id}}-info">{{ str_limit($i->notes->first()->note,20) }}</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

            <!-- initialize projects table js -->
            <script>
              $(document).ready(function() {

                $.fn.dataTable.moment( 'MM/DD/YYYY' );

                $('#projects-table').DataTable( {
                  "order": [[ 3, 'desc']],
                  'pageLength': 10,
                });
              });
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
                  <th>Sold Projects (Last 12 Months)</th>
                  <th>Lost Projects (Last 12 Months)</th>
                </tr>
              </thead>
              <tbody>
                @if ($productSalesReps)
                @foreach ($productSalesReps as $i)
                <tr>
                  <td><a data-toggle='{{ $i->id }}-person-info'><i class="fas fa-exclamation-circle"></i></a></td>
                  <td>{{ $i->name }}</td>
                  <td>{{ $i->upcomingProjects->count() }}</td>
                  <td>{{ $i->soldProjects->count() }}</td>
                  <td>{{ $i->lostProjects->count() }}</td>
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>

            <!-- initialize product sales table js -->
            <script>
              $(document).ready(function() {
                $('#product-sales-table').DataTable( {
                  "order": [[ 1, 'asc']],
                  'pageLength': 10,
                });
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
    <div class="off-canvas position-right project-info" id="{{$i->id}}-info" data-off-canvas data-auto-focus="false">
      <h4><span>{{ $i->name }}</span>&nbsp;</h4>
      <br /><br />

      <form method='post' action='/note/add/{{ $i->id }}'>
        {{ csrf_field() }}
        <input type='hidden' name='editable' value='1' />
        <textarea name='note' required placeholder='Type note here...'></textarea>
        <button type='submit' class='primary button'><i class="fas fa-check"></i>&nbsp;Save</button>
      </form>
      <br />

      @foreach ($i->notes as $note)
      <div class="note-card">
        @if ($note->userIsAuthor == true && $note->editable == true)
        <script>

          $(document).ready(function() {
            $('#note-{{$note->id}}').editable({
              type: 'textarea',
              url: '/note/edit/{{$note->id}}',
              title: 'Edit Note',
              rows: 10,
              pk: {{$note->id}},
              disabled: true
            });

            $('#{{$note->id}}-note-edit-toggle').click(function(e) {
              e.stopPropagation();
              $('#note-{{$note->id}}').editable('toggleDisabled');
            });

          });
        </script>
        <a id='{{$note->id}}-note-edit-toggle' ><i class="fas fa-pen"></i></a>&nbsp;
        @endif
        <span id='note-{{$note->id}}'>{!! nl2br($note->note) !!}</span><br /><br />
        <p>
          <strong>{{ $note->author }}</strong> on {{ $note->date }}
        </p>

        <!-- javascript for note editing -->

      </div>
      @endforeach
      <span style='color:lightgrey;font-style:italic;text-align:center'>---- End ----</span>
    </div>
    @endforeach

    <!-- salesperson info -->
    @if ($productSalesReps)
    @foreach ($productSalesReps as $i)
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
          <span class='stat-sales'>$85,000</span><br />
          <span class='stat-title'>Sales (Last 12 Months)</span>
        </div>
        <div class='cell small-6'>
          <span class='stat-projected'>$65,500</span><br />
          <span class='stat-title'>Project Sales (Next 6 Months)</span>
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

    <!-- charts for each salesperson -->
    <script>
      var personctx = document.getElementById('{{$i->id}}-sales-chart').getContext('2d');
      var salesChart = new Chart(personctx, {
        type: 'line',
        data: {
          labels: [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Aug','Sep','Oct','Nov','Dec'
          ],
          datasets: [{
            data: [
              40000, 35000, 20000, 80000, 65000, 44000, 38000, 24000, 75000, 60000, 28000, 74000
            ],
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
          labels: [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'
          ],
          datasets: [{
            data: [
              68000, 47000, 33000, 70000, 65000, 44000
            ],
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
              // labels: ["New","Quoted","Sold","Engineered","Lost"],
              labels: ['New','Quoted','Engineered','Sold','Lost'],
              datasets: [{
                  data: [32,57,24,72,28],
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
    @endif

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
