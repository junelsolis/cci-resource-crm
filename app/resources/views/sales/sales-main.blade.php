<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sales | Critical Components</title>
    <link rel=stylesheet href="{{ asset('css/foundation.min.css')}}" />
    <link rel='stylesheet' href="{{ asset('css/navbar.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/default.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/sales/sales-main.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/foundation.min.js')}}"></script>
    <script src="{{ asset('js/Chart.min.js')}}"></script>
  </head>
  @include('navbar')
  <body>
    <div id='main' class='grid-x'>
      <div class='cell medium-6 large-4'>
        <div id='upcoming-projects' class='card'>
          <h5><strong><i class="fas fa-clock"></i>&nbsp;Upcoming Projects</strong></h5>
          <br />
          <p>
            <i class="fas fa-eye"></i>&nbsp;<span>January 28, 2018</span>&nbsp;&mdash;&nbsp;Microsoft Corporation<br />
            <i class="fas fa-eye"></i>&nbsp;<span>January 28, 2018</span>&nbsp;&mdash;&nbsp;Microsoft Corporation<br />
            <i class="fas fa-eye"></i>&nbsp;<span>January 28, 2018</span>&nbsp;&mdash;&nbsp;Microsoft Corporation<br />
            <i class="fas fa-eye"></i>&nbsp;<span>January 28, 2018</span>&nbsp;&mdash;&nbsp;Microsoft Corporation<br />
            <i class="fas fa-eye"></i>&nbsp;<span>January 28, 2018</span>&nbsp;&mdash;&nbsp;Microsoft Corporation<br />
          </p>
        </div>
      </div>
      <div class='cell medium-6 large-8'>
        <div class='card'>
          <h5><strong><i class="fas fa-chart-bar"></i>&nbsp;Statistics</strong></h5>
          <div class='grid-x'>
            <div class='cell large-4'>
              <canvas id="line-chart"></canvas>
            </div>
            <div class='cell large-4'>
              <canvas id="myChart2"></canvas>
            </div>
            <div class='cell large-4'>
              <canvas id="myChart3"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class='cell small-12'>
        <div class='card'>
          <h5><strong><i class="fas fa-project-diagram"></i>&nbsp;Active Projects</strong></h5>
        </div>
      </div>
    </div>
  </body>
  <script>
    $(document).foundation();
  </script>
  <script>
    var ctx = document.getElementById("line-chart").getContext('2d');
    var linechart = new Chart(document.getElementById("line-chart"), {
      type: 'line',
      data: {
        labels: [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],
        datasets: [{
            data: [86,114,106,106,107,111,133,221,783,2478],
            label: "",
            borderColor: "#3e95cd",
            fill: false
          }
        ]
      },
      options: {
        title: {
          display: true,
          text: 'Sales (Last 6 months)'
        },
        legend: {
          display: false,
        }
      }
    });

    var ctx = document.getElementById("myChart2").getContext('2d');
    var myChart2 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
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
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });


    var ctx = document.getElementById("myChart3").getContext('2d');
    var myChart3 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
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
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
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
