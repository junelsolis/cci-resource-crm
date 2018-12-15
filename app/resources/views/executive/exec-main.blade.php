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
          <h5><strong>Sales</strong></h5>

          <div class='grid-x'>
            <div class='cell medium-6 large-4'>
              <canvas id="sales-past-year"></canvas>
            </div>
            <div class='cell medium-6 large-3'>
              <canvas id="projected-sales"></canvas>
            </div>
            <div class='cell medium-6 large-2' style='text-align:center;'>
              <span style='color:rgba(255,99,132,1);font-size:40px;font-weight:bold;'>$1,750,300</span>
              <h5>Total Sales<br />Last 12 Months</h5>
            </div>
            <div class='cell medium-6 large-2' style='text-align:center;'>
              <span style='color:#3e95cd;font-size:40px;font-weight:bold;'>$2,350,300</span>
              <h5>Projected Sales<br />Next 6 Months</h5>
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


        </script>
      </div>

      <!-- PROJECTS SECTIONS -->
      <div class='cell small-12'>
        <div class='card'>
          <h5><strong>Projects</strong></h5>
          <div class='grid-x'>
            <div class='cell medium-4'>
              Project Counts (Last 12 months)
            </div>
            <div class='cell medium-4'>
              Project status
            </div>
            <div class='cell medium-4'>
              Top Grossing Projects (Last 12 months)
            </div>
          </div>
        </div>
      </div>


      <!-- PEOPLE SECTION -->
      <div class='cell small-12'>
        <div class='card'>
          <h5><strong>People</strong></h5>
        </div>
      </div>
    </div>
  </body>
  @include('footer')
  <script>
    $(document).foundation();
  </script>
</html>
