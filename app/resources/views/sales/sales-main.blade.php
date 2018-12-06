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
              <canvas id="myChart2"></canvas>
            </div>
            <div class='cell large-4'>
              <canvas id="myChart3"></canvas>
            </div>
            <div class='cell large-4'>
              <canvas id='quote-status'></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class='cell small-12'>
        <div class='card'>
          <div class='grid-x align-middle'>
            <div class='cell medium-6 large-2'>
              <h5><strong><i class="fas fa-project-diagram"></i>&nbsp;Active Projects</strong></h5>
            </div>
            <div class='cell medium-6 large-10'>
              <ul class='menu align-right'>
                <li><a href='#' data-open="add-project-modal"><i class="fas fa-plus"></i>&nbsp;Add Project</a></li>
                <li><a href='#'><i class="fas fa-search"></i>&nbsp;Search</a></li>
              </ul>
            </div>


            <div class='reveal' id='add-project-modal' data-reveal>
              <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
              </button>

              <span><i class="fas fa-clipboard-list"></i>&nbsp;Add Project</span>
              <form method='post' action='/sales/project/add'>
                {{ csrf_field() }}
                <fieldset class='fieldset'>
                  <legend>
                    Product Details
                  </legend>
                  <div class='grid-x grid-padding-x'>
                    <div class='cell auto'>
                      <label>Product</label>
                      <input type='text' name='product' required />
                    </div>
                    <div class='cell auto'>
                      <label>Manufacturer</label>
                      <input type='text' name='manufacturer' required />
                    </div>
                  </div>

                </fieldset>
              </form>

            </div>


          </div>
          <br />
          <div class='table-scroll'>
            <table class="unstriped">
              <thead>
                <tr>
                  <th>Ship Date</th>
                  <th>Status</th>
                  <th>Manufacturer</th>
                  <th>Product</th>
                  <th>Amount</th>
                  <th>APC ID</th>
                  <th>Inside Sales</th>
                  <th>Engineer</th>
                  <th>Contractor</th>
                  <th>Notes</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Jan 3, 2019</td>
                  <td>Engineered</td>
                  <td>Metallurgy Inc.</td>
                  <td>Right-angle clamps</td>
                  <td>$6,000.00</td>
                  <td>09874928</td>
                  <td>SV</td>
                  <td>Peter Barnes</td>
                  <td>Jason Hayes</td>
                  <td>This is a note</td>
                </tr>
                <tr>
                  <td>Jan 15, 2019</td>
                  <td>Engineered</td>
                  <td>Metallurgy Inc.</td>
                  <td>Right-angle clamps</td>
                  <td>$3,000.00</td>
                  <td>09874928</td>
                  <td>SV</td>
                  <td>Peter Barnes</td>
                  <td>Jason Hayes</td>
                  <td>This is a note</td>
                </tr>
                <tr>
                  <td>Jan 20, 2019</td>
                  <td>Engineered</td>
                  <td>Metallurgy Inc.</td>
                  <td>Right-angle clamps</td>
                  <td>$4,000.00</td>
                  <td>09874928</td>
                  <td>SV</td>
                  <td>Peter Barnes</td>
                  <td>Jason Hayes</td>
                  <td>This is a note</td>
                </tr>
                <tr>
                  <td>Jan 15, 2019</td>
                  <td>Engineered</td>
                  <td>Metallurgy Inc.</td>
                  <td>Right-angle clamps</td>
                  <td>$7,000.00</td>
                  <td>09874928</td>
                  <td>SV</td>
                  <td>Peter Barnes</td>
                  <td>Jason Hayes</td>
                  <td>This is a note</td>
                </tr>
                <tr>
                  <td>Jan 15, 2019</td>
                  <td>Engineered</td>
                  <td>Metallurgy Inc.</td>
                  <td>Right-angle clamps</td>
                  <td>$7,000.00</td>
                  <td>09874928</td>
                  <td>SV</td>
                  <td>Peter Barnes</td>
                  <td>Jason Hayes</td>
                  <td>This is a note</td>
                </tr>
                <tr>
                  <td>Jan 15, 2019</td>
                  <td>Engineered</td>
                  <td>Metallurgy Inc.</td>
                  <td>Right-angle clamps</td>
                  <td>$7,000.00</td>
                  <td>09874928</td>
                  <td>SV</td>
                  <td>Peter Barnes</td>
                  <td>Jason Hayes</td>
                  <td>This is a note</td>
                </tr>
                <tr>
                  <td>Jan 15, 2019</td>
                  <td>Engineered</td>
                  <td>Metallurgy Inc.</td>
                  <td>Right-angle clamps</td>
                  <td>$7,000.00</td>
                  <td>09874928</td>
                  <td>SV</td>
                  <td>Peter Barnes</td>
                  <td>Jason Hayes</td>
                  <td>This is a note</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class='grid-x align-middle'>
            <div class='cell medium-6 large-2'>
              <a href='#top'><i class="fas fa-angle-double-up"></i>&nbsp;Back to Top</a>
            </div>
            <div class='cell medium-6 large-10'>
              <ul class='menu align-right'>
                <li><a href='#' data-open="add-project-modal"><i class="fas fa-plus"></i>&nbsp;Add Project</a></li>
                <li><a href='#'><i class="fas fa-search"></i>&nbsp;Search</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script>
    $(document).foundation();
  </script>
  <script>
    var ctx = document.getElementById("myChart2").getContext('2d');
    var myChart2 = new Chart(document.getElementById("myChart2"), {
      type: 'line',
      data: {
        labels: ['Dec','Jan','Feb','Mar','Apr','May','Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov'],
        datasets: [{
            data: [2500,9000,18000,7000,5000,15000,3500,8000,10000,29000,9500,11000],
            label: "",
            borderColor: "#3e95cd",
            fill: false
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


    var ctx = document.getElementById("myChart3").getContext('2d');
    var myChart3 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                data: [50000,29000,15000,13500,12000],
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
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Top 5 Clients'
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

    var ctx = document.getElementById('quote-status').getContext('2d');
    var quoteStatus = new Chart(document.getElementById("quote-status"), {
    type: 'bar',
    data: {
      labels: ["Engineered", "Quoted", "Lost", "Sold",],
      datasets: [
        {
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
          data: [80,106,3,180,6]
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      legend: {
        display: false,
      },
      title: {
        display: true,
        text: 'Project Status'
      }
    }
});
</script>
</html>
