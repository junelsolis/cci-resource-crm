<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Inside Sales | Critical Components</title>
    <link rel=stylesheet href="{{ asset('css/foundation.min.css')}}" />
    <link rel='stylesheet' href="{{ asset('css/navbar.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/default.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/inside-sales/inside-sales-main.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/foundation.min.js')}}"></script>
    <script src="{{ asset('js/Chart.min.js')}}"></script>
    <script src="{{ asset('js/list.min.js') }}"></script>

  </head>
  @include('navbar')
  <body>
    <div id='main' class='grid-x'>
      <div class='cell small-12'>
        <div class='card'>
          <div class='grid-x align-middle'>
            <div class='cell medium-6 large-2'>
              <h5><strong><i class="fas fa-exclamation-circle"></i>&nbsp;Upcoming Projects</strong></h5>
            </div>
            <div class='cell medium-6 large-10'>
              <ul class='menu align-right'>
                <li><input type='text' class='search'  placeholder='Search Project' /></li>
              </ul>
            </div>
          </div>
          <br />
          <div class='table-scroll'>
            <table class='unstriped'>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Status</th>
                  <th >Bid Date</th>
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
                @foreach ($upcomingProjects as $project)
                <tr>
                  <td>{{ $project->name}}</td>
                  <td style='<?php
                      if ($project->status->status == 'New') { echo 'background-color:rgba(243, 156, 18,0.2);color:rgb(243,156,18)';}
                      if ($project->status->status == 'Engineered') { echo 'background-color:rgba(155, 89, 182, 0.2);color:rgb(155,89,182);'; }
                    ?>'>{{ $project->status->status }}</td>
                  <td style='<?php
                      if ($project->bidTiming == 'late') { echo 'color:red;font-weight:bolder;';}
                      if ($project->bidTiming == 'soon') { echo 'color:#ffbf00;font-weight:bolder'; }
                    ?>'>
                    {{ $project->bidDate }}
                  </td>
                  <td>{{ $project->manufacturer }}</td>
                  <td>{{ $project->product }}</td>
                  <td>{{ $project->productSales->name }}</td>
                  <td>{{ $project->insideSales->name }}</td>
                  <td>{{ $project->amount }}</td>
                  <td>{{ $project->apc_opp_id }}</td>
                  <td></td>
                  <td>{{ $project->engineer }}</td>
                  <td>{{ $project->contractor }}</td>
                  <td>{{ $project->notes->first()->note }}</td>
                </tr>
                @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div>



      <div class='cell small-12'>
        <div class='card'>
          <h5><strong><i class="fas fa-user-tie"></i>&nbsp;Product Salespersons</strong></h5>
          <br />
          <div class='table-scroll'>
            <table class='unstriped'>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Upcoming Projects</th>
                  <th>Next Project Bid Date</th>
                  <th>Lost Projects</th>
                  <th>Projects Sold</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
        <br />

      </div>



      <div class='cell small-12'>
        <div class='card'>
          <div class='grid-x align-middle'>
            <div class='cell medium-6 large-2'>
              <h5><strong><i class="fas fa-exclamation-circle"></i>&nbsp;All Projects</strong></h5>
            </div>
            <div class='cell medium-6 large-10'>
              <ul class='menu align-right'>
                <li><input type='text' class='search'  placeholder='Search Project' /></li>
              </ul>
            </div>
          </div>
          <br />
          <div class='table-scroll'>
            <table class='unstriped'>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Status</th>
                  <th >Bid Date</th>
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
                @foreach ($allProjects as $project)
                <tr>
                  <td>{{ $project->name}}</td>
                  <td style='<?php
                      if ($project->status->status == 'New') { echo 'color:#f39c12;';}
                      if ($project->status->status == 'Engineered') { echo 'color:#8e44ad;'; }
                    ?>'>{{ $project->status->status }}</td>
                  <td style='<?php
                      if ($project->bidTiming == 'late') { echo 'color:red;font-weight:bolder;';}
                      if ($project->bidTiming == 'soon') { echo 'color:#ffbf00;font-weight:bolder'; }
                    ?>'>
                    {{ $project->bidDate }}
                  </td>
                  <td>{{ $project->manufacturer }}</td>
                  <td>{{ $project->product }}</td>
                  <td>{{ $project->productSales->name }}</td>
                  <td>{{ $project->insideSales->name }}</td>
                  <td>{{ $project->amount }}</td>
                  <td>{{ $project->apc_opp_id }}</td>
                  <td></td>
                  <td>{{ $project->engineer }}</td>
                  <td>{{ $project->contractor }}</td>
                  <td>{{ $project->notes->first()->note }}</td>
                </tr>
                @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </body>
  @include('footer')
  <script>
    $(document).foundation();
  </script>

</html>
