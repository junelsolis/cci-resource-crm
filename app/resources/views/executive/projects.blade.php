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
      @include ('project')

      <div class='cell small-12'>
        <div class='card-top' style='margin-top:50px;background-color:white;'>
          <h5 style='color:#303952;'><strong>Other Projects</strong></h5>
        </div>
        <div class='card-middle'>
          <div class='table-scroll'>
            <table id='other-projects-table' class='unstriped'>
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
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @forelse ($otherProjects as $i)
                <tr>
                  <td><a href='/executive/projects/{{$i->id}}'><i class="fas fa-search"></i></a></td>
                  <td>{{ $i->name}}</td>
                  <td
                    <?php

                      $status = $i['status']['status'];
                      if ($status == 'New') { echo ' class=\'status-new\''; }
                      if ($status == 'Engineered') { echo ' class=\'status-engineered\''; }
                      if ($status == 'Sold') { echo ' class=\'status-sold\''; }
                      if ($status == 'Quoted') { echo ' class=\'status-quoted\''; }
                      if ($status == 'Lost') { echo ' class=\'status-lost\''; }
                    ?>
                  >{{ $i['status']['status'] }}</td>
                  <td
                    <?php
                        if ($i['bidTiming'] == 'late' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-late\'';}
                        if ($i['bidTiming'] == 'soon' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-soon\''; }
                    ?>
                  >{{ $i['formattedBidDate']}}</td>
                  <td>{{ $i->manufacturer }}</td>
                  <td>{{ $i->product }}</td>
                  <td>{{ $i->productSales->name }}</td>
                  <td>{{ $i->insideSales->name }}</td>
                  <td>{{ $i['formattedAmount']}}</td>
                  <td>{{ $i->apc_opp_id }}</td>
                  <td>
                    @if (isset($i->invoice_link))
                    <a href='{{ $i->invoice_link }}' target='_blank'><i class="fas fa-link"></i></i></a>
                    @endif
                  </td>
                  <td>{{ $i->engineer}}</td>
                  <td>{{ $i->contractor}}</td>
                  <td><a href='/executive/projects/{{$i->id}}'><i class="fas fa-search"></i></a></td>
                </tr>
                @empty
                @endforelse
              </tbody>
            </table>

            <script>
              $('#other-projects-table').DataTable( {
                "order": [[ 3, "desc" ]],
                'pageLength': 5,
              } );
            </script>
          </div>
        </div>
        <div class='card-bottom'>
          <a href='#upcoming-projects'><i class="fas fa-angle-double-up"></i>&nbsp;Back to Top</a>
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

    @include('footer')

  </body>




</html>
