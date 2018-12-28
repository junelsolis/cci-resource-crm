<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Inside Sales | CCI POST</title>
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


    <div id='' class='grid-x off-canvas-content' data-off-canvas-content >
      <div class='cell medium-3 large-2 people-menu' data-sticky-container>
          <ul class='vertical menu align-right'>
            @foreach ($productSales as $i)
            <li
              <?php
                if ($i->id == $person->id) {
                  echo ' class=\'current-person\';';
                }
              ?>
            ><a href='/inside-sales/people/{{$i->id}}'>{{ $i->name }}</a></li>
            @endforeach
          </ul>
      </div>
      <div id='main' class='cell medium-9 large-10 people-info'>

        <div class='card people-info'>
          <div class='person-title'>
            <h4><strong><i class="fas fa-user-tie"></i>&nbsp;{{ $person->name }}</strong></h4>
            <span>Product Sales</span>
          </div>

          <div class='stats'>
            <h5><strong><i class="fas fa-chart-line"></i>&nbsp;Stats</strong></h5>
            <div class='grid-x'>
              <div class='cell medium-4'>
                <div>
                  <br /><br />
                  <span class='stat'>{{ $person->ongoingProjects->count() }}</span>
                  <span class='stat-title'>Ongoing Projects</span><br />

                  <span class='stat'>{{ $person->projectsThisYear->where('status_id', 3)->count() }}</span>
                  <span class='stat-title'>Projects Sold</span><br />

                  <span class='stat'>{{ $person->projectsThisYear->count() }}</span>
                  <span class='stat-title'>Total Projects</span>
                </div>
              </div>
              <div class='cell medium-4'>
                <canvas id='project-counts'></canvas>
              </div>
              <div class='cell medium-4'>
                <canvas id='project-status'></canvas>
              </div>

              <!-- javascript for projects charts -->
              <script>
                var ctx = document.getElementById("project-counts").getContext('2d');
                var projectCounts = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! $person->chartData['months'] !!},
                        datasets: [{
                            data: {!! $person->chartData['projectCounts'] !!},
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
                        labels: {!! $person->chartData['projectStatus']->pluck('name') !!},
                        datasets: [{
                            data: {!! $person->chartData['projectStatus']->pluck('count') !!},
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
            </div>
          </div>

          <div class='table'>
            <h5><strong><i class="fas fa-project-diagram"></i>&nbsp;Ongoing Projects</strong></h5>
            <div class='table-scroll'>
              <table id='ongoing-projects-table' class='unstriped'>
                <thead>
                  <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Product</th>
                    <th>Status</th>
                    <th>Bid Date</th>
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
                  @foreach ($person->ongoingProjects() as $i)
                  <tr>
                    <td><a id='{{$i->id}}-toggle' title='Click to Edit'><i class='fas fa-edit'></i></a></td>
                    <td id='{{$i->id}}-name'>{{ $i->name }}</td>
                    <td id='{{$i->id}}-product'>{{ $i->product }}</td>
                    <td id='{{$i->id}}->status'
                      <?php

                        $status = $i->status['status'];
                        $bidTiming = $i['bidTiming'];

                        if ($status == 'New') { echo 'class=\'status-new\''; }
                        if ($status == 'Engineered') { echo 'class=\'status-engineered\''; }
                        if ($status == 'Sold') { echo 'class=\'status-sold\''; }
                        if ($status == 'Quoted') { echo 'class=\'status-quoted\''; }
                        if ($status == 'Lost') { echo 'class=\'status-lost\''; }
                      ?>
                    >{{ $status }}</td>
                    <td id='{{$i->id}}-bidDate'
                    <?php


                      if ($bidTiming == 'late' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-late\'';}
                      if ($bidTiming == 'soon' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-soon\''; }
                    ?>
                    >{{ $i['formattedBidDate'] }}</td>
                    <td id='{{$i->id}}-insideSales'>{{ $i->insideSales->name }}</td>
                    <td id='{{$i->id}}-amount'>{{ $i['formattedAmount'] }}</td>
                    <td id='{{$i->id}}-apcOppId'>{{ $i->apc_opp_id }}</td>
                    <td id='{{$i->id}}-invoiceLink'>
                      @if (isset($i->invoice_link))
                      <a href='{{ $i->invoice_link }}' target='_blank'><i class="fas fa-link"></i></i></a>
                      @endif
                    </td>
                    <td id='{{$i->id}}-engineer'>{{ $i->engineer }}</td>
                    <td id='{{$i->id}}-contractor'>{{ $i->contractor }}</td>
                    <td><a class='table-note' data-toggle="{{$i->id}}-all-projects-info">{{ str_limit($i->notes->last()->note,20) }}</a></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

              <!-- initialize editables -->
              <script>
                @foreach($person->ongoingProjects()->chunk(10) as $chunk)
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
                    $('#{{$i->id}}-engineer').toggleClass('edit-enabled');
                    $('#{{$i->id}}-contractor').toggleClass('edit-enabled');
                  });
                  @endforeach
                @endforeach

              </script>

              <!-- initialize projects table js -->
              <script>
                $(document).ready(function() {

                  $.fn.dataTable.moment( 'MM/DD/YYYY' );

                  $('#ongoing-projects-table').DataTable( {
                    "order": [[ 3, 'asc']],
                    'pageLength': 10,
                  });
                });
              </script>
            </div>
          </div>

        </div>
      </div>

    </div>



    <!-- OFF-CANVAS DIVS -->
    <!-- add project div -->
    <div class='off-canvas position-left add-project' id='add-project' data-off-canvas data-auto-focus="false">
      <h4><i class="fas fa-plus"></i>&nbsp;New Project</h4>
      <br />
      <form method='post' action='/project/add'>
        {{ csrf_field() }}
        <fieldset class='fieldset'>
          <legend>
            Project Details
          </legend>

          <label>Project Name<span><i class="fas fa-star-of-life"></i></span></label>
          <input type='text' name='name' required />

          <label>Product<span><i class="fas fa-star-of-life"></i></span></label>
          <input type='text' name='product' required />

          <label>Manufacturer</label>
          <input type='text' name='manufacturer' />
        </fieldset>

        <fieldset class='fieldset'>
          <legend>
            Bid Information
          </legend>

          <label>Bid Date<span><i class="fas fa-star-of-life"></i></span></label>
          <input type='date' name='bid_date' required />

          <label>Status<span><i class="fas fa-star-of-life"></i></span></label>
          <select name='status_id' required>
            <option value="" selected disabled hidden>Select One</option>
            @foreach ($projectStatusCodes as $code)
            <option value='{{ $code->id }}'>{{ $code->status }}</option>
            @endforeach
          </select>

          <label>Amount<span><i class="fas fa-star-of-life"></i></span></label>
          <input type='number' name='amount' required placeholder='$' />

          <label>Product Sales<span><i class="fas fa-star-of-life"></i></span></label>
          <select name='product_sales_id' required>
            <option value='' selected disabled hidden>Select One</option>
            @foreach ($productSales as $item)
            <option value='{{ $item->id }}'>{{ $item->name }}</option>
            @endforeach
          </select>

          <label>Inside Sales<span><i class="fas fa-star-of-life"></i></span></label>
          <select name='inside_sales_id' required>
            <option value="" selected disabled hidden>Select One</option>
            @foreach ($insideSales as $item)
            <option value='{{ $item->id }}'>{{ $item->name }}</option>
            @endforeach
          </select>
        </fieldset>

        <fieldset class='fieldset'>
          <legend>
            External Information
          </legend>
            <label>APC OPP ID</label>
            <input type='text' name='apc_opp_id' />

            <label>Quote Link</label>
            <input type='text' name='invoice_link' />
        </fieldset>

        <fieldset class='fieldset'>
          <legend>
            Additional Information
          </legend>
            <label>Engineer</label>
            <input type='text' name='engineer' />

            <label>Contractor</label>
            <input type='text' name='contractor' />
        </fieldset>

        <fieldset class='fieldset'>
          <legend>
            Note
          </legend>
          <textarea name='note' width='100%' placeholder='Optional note...'></textarea>
        </fieldset>

        <button type='submit' class='primary button align-right'><i class="fas fa-check"></i>&nbsp;Save</button>
      </form>
    </div>

    @foreach ($person->ongoingProjects as $i)
      @include('project-info')
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
