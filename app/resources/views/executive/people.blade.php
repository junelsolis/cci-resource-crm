<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Executive | CCI POST</title>
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

    <div id='main' class='grid-x off-canvas-content' data-equalizer data-equalize-on="medium" data-off-canvas-content>
      <div class='cell medium-2'>
        <div class='card' style='padding:0;'>
          <ul class='vertical menu people-menu'>
            <li style='background-color:#303952;'><a style='color:white;'><strong>Product Sales</strong></a></li>
            <li class='selected'><a>Test Selected</a></li>
            @foreach ($productSalesReps as $i)
            <li><a href=''>{{ $i->name }}</a></li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class='cell medium-7'>
        <div class='card-top'>
          <h5><strong><i class="fas fa-user-tie"></i>&nbsp;{{ $rep->name }}</strong></h5>
        </div>
        <div class='card-middle'>
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
        <div class='card-bottom'>

        </div>
      </div>
      <div class='cell medium-3'>
        <div class='card-top'>
          <h5><strong><i class="fas fa-chart-bar"></i>&nbsp;User Stats</strong></h5>
        </div>
        <div class='card-middle'>

        </div>
        <div class='card-bottom'>

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


  </body>
  @include('footer')




</html>
