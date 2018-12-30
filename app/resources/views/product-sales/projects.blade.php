<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Product Sales | CCI POST</title>
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
      @include ('/project')

      <!-- My Projects -->
      <div class='cell small-12'>
        <div class='card-top'>
          <h5><strong><i class="fas fa-project-diagram"></i>&nbsp;My Projects</strong></h5>
        </div>
        <div id='projects' class='card-middle'>
          <!-- <div class='grid-x align-middle'>
            <div class='cell small-6' style='text-align:right;'>
              <a href='#' data-toggle="add-project"><i class="fas fa-plus"></i>&nbsp;Add Project</a>
            </div>
          </div>
          <br /> -->
          <div class='table-scroll'>
            <table id='my-projects-table' class="unstriped">
              <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Bid Date</th>
                  <th>Manufacturer</th>
                  <th>Product</th>
                  <th>Inside Sales</th>
                  <th>Amount</th>
                  <th>APC OPP ID</th>
                  <th>Quote</th>
                  <th>Engineer</th>
                  <th>Contractor</th>
                  <th>Note</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($projects->chunk(10) as $chunk)
                  @foreach ($chunk as $i)
                  <tr>
                    <td><a id='{{$i->id}}-toggle' title='Click to Edit'><i class="fas fa-edit"></i></a></td>
                    <td id='{{$i->id}}-name'>{{ $i->name }}</td>
                    <td id='{{$i->id}}-status'
                      <?php

                        $status = $i['status']['status'];

                        if ($status == 'New') { echo 'class=\'status-new\''; }
                        if ($status == 'Engineered') { echo 'class=\'status-engineered\''; }
                        if ($status == 'Sold') { echo 'class=\'status-sold\''; }
                        if ($status == 'Quoted') { echo 'class=\'status-quoted\''; }
                        if ($status == 'Lost') { echo 'class=\'status-lost\''; }
                      ?>
                    >{{ $status }}</td>
                    <td id='{{$i->id}}-bidDate'
                      <?php
                          if ($i['bidTiming'] == 'late' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-late\'';}
                          if ($i['bidTiming'] == 'soon' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-soon\''; }
                      ?>
                    >{{ $i['formattedBidDate'] }}</td>
                    <td id='{{$i->id}}-manufacturer'>{{ $i->manufacturer}}</td>
                    <td id='{{$i->id}}-product'>{{ $i->product }}</td>
                    <td id='{{$i->id}}-insideSales'>{{ $i->insideSales['formattedName']['initials'] }}</td>
                    <td id='{{$i->id}}-amount'>{{ $i['formattedAmount'] }}</td>
                    <td id='{{$i->id}}-apcOppId'>{{ $i->apc_opp_id }}</td>
                    <td id='{{$i->id}}-invoiceLink' >
                      @if (isset($i->invoice_link))
                      <a href='{{ $i->invoice_link }}' target='_blank'><i class="fas fa-link"></i></a>
                      @endif
                    </td>
                    <td id='{{$i->id}}-engineer'>{{ $i->engineer}}</td>
                    <td id='{{$i->id}}-contractor'>{{ $i->contractor }}</td>
                    <td>
                      <a href='/product-sales/project/{{$i->id}}'><i class="fas fa-search"></i></a>
                    </td>
                  </tr>
                  @endforeach
                @endforeach
              </tbody>

            </table>



            <!-- init editables -->
            <script>

              @foreach ($projects->chunk(10) as $chunk)
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


            <!-- init datatable -->
            <script>
              $.fn.dataTable.moment( 'MM/DD/YYYY' );

              $('#my-projects-table').DataTable( {
                "order": [[ 3, 'desc']],
                'pageLength': 10,
              });
            </script>
          </div>
          <div class='grid-x align-middle'>
            <div class='cell medium-6 large-2'>

            </div>
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


  </body>
  @include('footer')




</html>
