<div id='main' class='grid-x off-canvas-content' data-equalizer data-equalize-on="medium" data-off-canvas-content>

  <!-- list of product sales reps -->
  <div class='cell medium-2'>
    <div class='info-card'>
      <div class='title'>
        <strong>Product Sales</strong>
      </div>
      <ul class='vertical menu people-menu'>
        @foreach ($productSalesReps as $i)
        <li
          <?php
            if ($rep->id == $i->id) {
              echo ' class=\'selected\'';
            }
          ?>
        ><a href='/{{session('current_section')}}/people/{{$i->id}}'>{{ $i->name }}</a></li>
        @endforeach
      </ul>
    </div>
  </div>

  <!-- info for product sales rep -->
  <div class='cell medium-7'>
    <div class='info-card' data-equalizer-watch>
      <div class='title-muted'>
        <h5><strong><i class="fas fa-user-tie"></i>&nbsp;{{ $rep->name }}</strong></h5>
      </div>
      <div class='content'>
        <div class='table-scroll'>
          <table id='user-projects-table' class='unstriped'>
            <thead>
              <tr>
                <th></th>
                <th>Name</th>
                <th>Product</th>
                <th>Status</th>
                <th>Bid Date</th>
                <th>Inside Sales</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($rep['projectsThisYear'] as $i)
              <tr>
                <td></td>
                <td>{{ $i->name }}</td>
                <td>{{ $i->product }}</td>
                <td
                  <?php

                    $status = $i['status']['status'];
                    if ($status == 'New') { echo 'class=\'status-new\''; }
                    if ($status == 'Engineered') { echo 'class=\'status-engineered\''; }
                    if ($status == 'Sold') { echo 'class=\'status-sold\''; }
                    if ($status == 'Quoted') { echo 'class=\'status-quoted\''; }
                    if ($status == 'Lost') { echo 'class=\'status-lost\''; }
                  ?>
                >{{ $status }}</td>
                <td
                  <?php
                    $bidTiming = $i['bidTiming'];
                      if ($bidTiming== 'late' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-late\'';}
                      if ($bidTiming == 'soon' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-soon\''; }
                  ?>
                >{{ $i['formattedBidDate'] }}</td>
                <td>{{ $i['insideSales']['formattedName']['initials'] }}</td>
                <td>{{ $i['formattedAmount'] }}</td>
              </tr>
              @empty
              @endforelse
            </tbody>
          </table>

          <!-- initialize data table -->
          <script>
            $.fn.dataTable.moment( 'MM/DD/YYYY' );

            $('#user-projects-table').DataTable( {
              "order": [[ 4, 'desc']],
              'pageLength': 10,
            });
          </script>
        </div>
      </div>
    </div>
  </div>

  <!-- stats for user -->
  <div class='cell medium-3'>
    <div class='info-card' data-equalizer-watch>
      <div class='title-muted'>
        <h5><strong><i class="fas fa-chart-bar"></i>&nbsp;User Stats</strong></h5>
      </div>
      <div class='content'>
        <div class='grid-x'>
          <div class='cell small-12'>
            <canvas id="sales-past-year"></canvas>
          </div>
          <div class='cell small-12'>
            <canvas id="projected-sales"></canvas>
          </div>
          <div class='cell small-12'>
            <canvas id="project-counts"></canvas>
          </div>
          <div class='cell small-12'>
            <canvas id="project-status"></canvas>
          </div>
        </div>
      </div>
    </div>

  </div>



</div>
<!-- some initialization scripts -->
<script>

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

  });

  $(document).foundation();


</script>


<!-- sales charts for user -->
<script>
  var ctx = document.getElementById('sales-past-year').getContext('2d');
  var salesPastYear = new Chart(ctx, {
    type: 'line',
    data: {
      labels: {!! $rep['chartData']['months'] !!},
      datasets: [{
        data: {!! $rep['chartData']['sales'] !!},
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
      labels: {!! $rep['chartData']['nextSixMonths'] !!},
      datasets: [{
        data: {!! $rep['chartData']['projectedSales'] !!},
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


</script>

<!-- project charts for user -->
<script>
  var ctx = document.getElementById("project-counts").getContext('2d');
  var projectCounts = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: {!! $rep['chartData']['months'] !!},
          datasets: [{
              data: {!! $rep['chartData']['projectCounts'] !!},
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
          labels: {!! $rep['chartData']['projectStatus']->pluck('name') !!},
          datasets: [{
              data: {!! $rep['chartData']['projectStatus']->pluck('count') !!},
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


</script>
