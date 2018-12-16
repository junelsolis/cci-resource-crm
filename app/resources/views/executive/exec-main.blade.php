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
    <!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script> -->
    <!-- <script src='{{ asset('js/bootstrap.min.js')}}'></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/zf/dt-1.10.18/datatables.min.js"></script> -->

  </head>
  @include('navbar')
  <body>
    <div id='main' class='grid-x'>

      <!-- SALES SECTION -->
      <div class='cell small-12'>
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



          var ctx = document.getElementById('projected-sales').getContext('2d');
          var projectedSales = new Chart(ctx, {
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



          var ctx = document.getElementById('lost-bids').getContext('2d');
          var lostBids = new Chart(ctx, {
            type: 'line',
            data: {
              labels: [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Aug','Sep','Oct','Nov','Dec'
              ],
              datasets: [{
                data: [
                  40000, 35000, 20000, 80000, 65000, 44000, 38000, 24000, 75000, 60000, 28000, 74000
                ],
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
                <span style='color:rgba(255,99,132,1);font-size:30px;font-weight:bold;'>$1,750,300</span><br />
                Sales Over Past 12 Months
              </div>
              <div class='cell medium-4' style='text-align:center;'>
                <span style='color:#3e95cd;font-size:30px;font-weight:bold;'>$2,350,300</span><br />
                Projected Sales (Next 6 Months)
              </div>
              <div class='cell medium-4' style='text-align:center;'>
                <span style='color:rgba(189, 195, 199,1.0);font-size:30px;font-weight:bold;'>$175,000</span><br />
                Bids Lost (Last 12 Months)
              </div>
            </div>
        </div>

      </div>

      <!-- PROJECTS SECTIONS -->
      <div class='cell small-12'>
        <div class='card'>
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
                  labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                  datasets: [{
                      data: [33,21,32,18,25,43,33,21,28,35,29,14],
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
              type: 'bar',
              data: {
                  labels: ['Microsoft','Acme','Massive Dynamics','Hersheys','AMD'],
                  datasets: [{
                      data: [60000,45000,42300,29000,26000],
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


      <!-- PEOPLE SECTION -->
      <div class='cell small-12'>
        <div class='card'>
          <h5><strong><i class="fas fa-users"></i>&nbsp;People</strong></h5>
        </div>
      </div>
    </div>
  </body>
  @include('footer')
  <script>
    $(document).foundation();
  </script>
</html>
