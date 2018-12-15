<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Inside Sales | Critical Components</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href='{{ asset('css/bootstrap.css') }}'rel='stylesheet' />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/zf/dt-1.10.18/datatables.min.css"/>
    <link rel=stylesheet href="{{ asset('css/app.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/navbar.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/default.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/inside-sales/inside-sales-main.css') }}" />

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/foundation.min.js')}}"></script>
    <script src="{{ asset('js/Chart.min.js')}}"></script>
    <!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script> -->
    <script src='{{ asset('js/bootstrap.min.js')}}'></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/zf/dt-1.10.18/datatables.min.js"></script>

  </head>
  @include('navbar')
  <body>
    <!-- Off-canvas content -->
    <!-- add project div -->
    <div class='off-canvas position-left add-project' id='add-project' data-off-canvas>
      add project here
    </div>

    <!-- divs for off-canvas project information -->
    @foreach ($upcomingProjects as $i)
    <div class="off-canvas position-right project-info" id="{{$i->id}}-info" data-off-canvas>
      <button class="close-button" aria-label="Close menu" type="button" data-close>
        <span aria-hidden="true">&times;</span>
      </button>
      <h4><span>Project:</span>&nbsp;{{ $i->name }}</h4>
      <br /><br />

      <form method='post' action='/note/add/{{ $i->id }}'>
        {{ csrf_field() }}
        <!-- <i class="fas fa-plus"></i>&nbsp;Add Note<br /> -->
        <textarea name='note' required placeholder='Type note here...'></textarea>
        <button type='submit' class='primary button'><i class="fas fa-check"></i>&nbsp;Save Note</button>
      </form>
      <br />
      <?php
        $colorSwitcher = 0;
        $color = '';
      ?>
      @foreach ($i->notes as $note)
      <?php
        if ($colorSwitcher >= 2) { $colorSwitcher = 0; }

        if ($colorSwitcher <= 1) {
          if ($colorSwitcher == 0) {
            $color = 'style=\'background-color:rgba(46,204,113,0.4)\';';
          }

          if ($colorSwitcher == 1) {
            $color = 'style=\'background-color:rgba(241,196,15,0.4)\';';
          }

          // if ($colorSwitcher == 2) {
          //   $color = 'style=\'background-color:rgba(155,89,182,0.1)\';';
          // }
          //
          // if ($colorSwitcher == 3) {
          //   $color = 'style=\'background-color:rgba(231,76,60,0.1)\';';
          // }
          //
          // if ($colorSwitcher == 4) {
          //   $color = 'style=\'background-color:rgba(241, 196, 15,0.1)\';';
          // }

          $colorSwitcher++;
        }
      ?>
      <div class="note-card" <?php echo $color; ?>>
        <span>{!! nl2br($note->note) !!}</span>
        <br /><br />
        <p style='color:grey;'>
          <strong>{{ $note->author }}</strong> on {{ $note->date }}
        </p>
      </div>
      @endforeach
      <span style='color:lightgrey;font-style:italic;text-align:center'>---- End ----</span>
    </div>
    @endforeach


    <!-- divs for off-canvas project information -->
    @foreach ($allProjects as $i)
    <div class="off-canvas position-right project-info" id="{{$i->id}}-info" data-off-canvas>
      <h4><span>Project:</span>&nbsp;{{ $i->name }}</h4>
      <br /><br />

      <form method='post' action='/note/add/{{ $i->id }}'>
        {{ csrf_field() }}
        <!-- <i class="fas fa-plus"></i>&nbsp;Add Note<br /> -->
        <textarea name='note' required placeholder='Type note here...'></textarea>
        <button type='submit' class='primary button'><i class="fas fa-check"></i>&nbsp;Save</button>
      </form>
      <br />
      <?php
        $colorSwitcher = 0;
        $color = '';
      ?>
      @foreach ($i->notes as $note)
      <?php
        if ($colorSwitcher >= 2) { $colorSwitcher = 0; }

        if ($colorSwitcher <= 1) {
          if ($colorSwitcher == 0) {
            $color = 'style=\'background-color:rgba(46,204,113,0.4)\';';
          }

          if ($colorSwitcher == 1) {
            $color = 'style=\'background-color:rgba(241,196,15,0.4)\';';
          }

          // if ($colorSwitcher == 2) {
          //   $color = 'style=\'background-color:rgba(155,89,182,0.1)\';';
          // }
          //
          // if ($colorSwitcher == 3) {
          //   $color = 'style=\'background-color:rgba(231,76,60,0.1)\';';
          // }
          //
          // if ($colorSwitcher == 4) {
          //   $color = 'style=\'background-color:rgba(241, 196, 15,0.1)\';';
          // }

          $colorSwitcher++;
        }
      ?>
      <div class="note-card" <?php echo $color; ?>>
        <span>{!! nl2br($note->note) !!}</span>
        <br /><br />
        <p style='color:grey;'>
          <strong>{{ $note->author }}</strong> on {{ $note->date }}
        </p>
      </div>
      @endforeach
      <span style='color:lightgrey;font-style:italic;text-align:center'>---- End ----</span>
    </div>
    @endforeach



    <div id='main' class='grid-x off-canvas-content' data-off-canvas-content>
      <div class='cell small-12'>
        <div class='card'>
          <ul class='menu'>
            <li><a href='#' data-toggle="add-project"><i class="fas fa-plus"></i>&nbsp;Add Project</a></li>
          </ul>
        </div>


      </div>
      <div class='cell small-12'>
        <div id='upcoming-projects' class='card'>
          <div class='grid-x align-middle'>
            <div class='cell medium-6 large-2'>
              <h5><strong><i class="fas fa-exclamation-circle"></i>&nbsp;Upcoming Projects</strong></h5>
            </div>
            <div class='cell medium-6 large-10'>
              <!-- <ul class='menu align-right'>
                <li><input type='text' class='search'  placeholder='Search Project' /></li>
              </ul> -->
            </div>
          </div>
          <br />
          <div class='table-scroll'>
              <table id='upcoming-projects-table' class='unstriped'>
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
                    <th>Note</th>
                  </tr>
                </thead>
                <tbody class='list'>
                  @foreach ($upcomingProjects as $i)
                  <tr>
                    <td><a id='{{$i->id}}-toggle' title='Click to Edit'><i class="fas fa-edit"></i></a></td>
                    <td id='{{ $i->id}}-name'>{{ $i->name}}</td>
                    <td id='{{ $i->id}}-status'
                      <?php
                        if ($i->status->status == 'New') { echo 'class=\'status-new\''; }
                        if ($i->status->status == 'Engineered') { echo 'class=\'status-engineered\''; }
                        if ($i->status->status == 'Sold') { echo 'class=\'status-sold\''; }
                        if ($i->status->status == 'Quoted') { echo 'class=\'status-quoted\''; }
                        if ($i->status->status == 'Lost') { echo 'class=\'status-lost\''; }
                      ?>
                    >{{ $i->status->status }}</td>
                    <td id='{{ $i->id}}-bidDate'
                      <?php
                          if ($i->bidTiming == 'late' && ($i->status->status != 'Quoted') && ($i->status->status != 'Sold') && ($i->status->status != 'Lost')) { echo 'class=\'bidTiming-late\'';}
                          if ($i->bidTiming == 'soon' && ($i->status->status != 'Quoted') && ($i->status->status != 'Sold') && ($i->status->status != 'Lost')) { echo 'class=\'bidTiming-soon\''; }
                      ?>
                    >{{ $i->bidDate }}
                    </td>
                    <td id='{{ $i->id}}-manufacturer'>{{ $i->manufacturer }}</td>
                    <td id='{{ $i->id}}-product'>{{ $i->product }}</td>
                    <td id='{{ $i->id}}-productSales'>
                      <?php
                        $array = explode(' ', $i->productSales->name);
                        $name = substr($array[0],0,1) . ' ' . $array[1];
                        echo $name;
                      ?>
                    </td>
                    <td id='{{ $i->id}}-insideSales'>
                      <?php
                        $array = explode(' ', $i->insideSales->name);
                        $name = substr($array[0],0,1) . ' ' . $array[1];
                        echo $name;
                      ?>
                    </td>
                    <td id='{{ $i->id}}-amount'>{{ $i->amount }}</td>
                    <td id='{{ $i->id}}-apcOppId'>{{ $i->apc_opp_id }}</td>
                    <td id='{{ $i->id}}-invoiceLink'>
                      @if (isset($i->invoice_link))
                      <a href='{{ $i->invoice_link }}' target='_blank'><i class="fas fa-link"></i></i></a>
                      @endif
                    </td>
                    <td id='{{ $i->id}}-engineer'>{{ $i->engineer }}</td>
                    <td id='{{ $i->id}}-contractor'>{{ $i->contractor }}</td>
                    <td><a class='table-note' data-toggle="{{$i->id}}-info">{{ str_limit($i->notes->first()->note,20) }}</a></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <script>
                $.fn.editable.defaults.mode = 'inline';

                @foreach ($upcomingProjects as $i)
                // setup editables
                $(document).ready(function() {


                  $('#{{$i->id}}-name').editable(
                    {
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
                      type: 'text',
                      pk: {{ $i->id }},
                      url: '/project/edit/product',
                      title: 'Enter Product Name',
                      disabled: true,
                      name: 'product',
                    }
                  );

                  $('#{{$i->id}}-productSales').editable(
                    {
                      type: 'select',
                      pk: {{ $i->id }},
                      url: '/project/edit/product-sales',
                      title: 'Select Product Sales Rep',
                      value: {{ $i->product_sales_id }},
                      disabled: true,
                      name: 'productSales',
                      source: [
                        @foreach ($productSales as $item)
                        { value: {{ $item->id }}, text: '{{ $item->name }}'},
                        @endforeach
                      ]
                    }
                  );

                  $('#{{$i->id}}-insideSales').editable(
                    {
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
                      type: 'text',
                      pk: {{ $i->id }},
                      url: '/project/edit/contractor',
                      title: 'Enter Contractor',
                      disabled: true,
                      name: 'contractor',
                    }
                  );

                });

                //enable editing of row on click of toggle link
                $('#{{$i->id}}-toggle').click(function(e) {
                  e.stopPropagation();
                  $('#{{$i->id}}-name').editable('toggleDisabled');
                  $('#{{$i->id}}-status').editable('toggleDisabled');
                  $('#{{$i->id}}-bidDate').editable('toggleDisabled');
                  $('#{{$i->id}}-manufacturer').editable('toggleDisabled');
                  $('#{{$i->id}}-product').editable('toggleDisabled');
                  $('#{{$i->id}}-productSales').editable('toggleDisabled');
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
                  $('#{{$i->id}}-productSales').toggleClass('edit-enabled');
                  $('#{{$i->id}}-insideSales').toggleClass('edit-enabled');
                  $('#{{$i->id}}-amount').toggleClass('edit-enabled');
                  $('#{{$i->id}}-apcOppId').toggleClass('edit-enabled');
                  $('#{{$i->id}}-invoiceLink').toggleClass('edit-enabled');
                  $('#{{$i->id}}-engineer').toggleClass('edit-enabled');
                  $('#{{$i->id}}-contractor').toggleClass('edit-enabled');
                });


                @endforeach



              </script>

            </div>

        </div>


      </div>



      <div class='cell small-12'>
        <div class='card'>
          <h5><strong><i class="fas fa-user-tie"></i>&nbsp;Product Salespersons</strong></h5>
          <br />
          <div class='table-scroll'>
            <table id='product-salespersons' class='unstriped'>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Upcoming Projects</th>
                  <th>Next Project Bid Date</th>
                  <th>Lost Projects</th>
                  <th>Projects Sold</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($productSales as $i)
                <tr>
                  <td>{{ $i->name }}</td>
                  <td>{{ $i->upcomingProjects->count() }}</td>
                  <td>
                    @if ($i->upcomingProjects->first())
                    {{ $i->upcomingProjects->first()->bidDate}}
                    @endif
                  </td>
                  <td>{{ $i->lostProjects->count() }}</td>
                  <td>{{ $i->soldProjects->count() }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <br />

      </div>



      <div class='cell small-12'>
        <div id='all-projects' class='card'>
          <div class='grid-x align-middle'>
            <div class='cell medium-6 large-2'>
              <h5><strong><i class="fas fa-project-diagram"></i>&nbsp;All Projects</strong></h5>
            </div>
            <div class='cell medium-6 large-10'>

            </div>
          </div>
          <br />
          <div class='table-scroll'>
            <table id='all-projects-table' class='unstriped'>
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
                  <th>Note</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($allProjects as $i)
                <tr>
                  <td><a id='{{$i->id}}-all-toggle' title='Click to Edit'><i class="fas fa-edit"></i></a>
                  </td>
                  <td id='{{$i->id}}-all-name'>{{ $i->name}}</td>
                  <td id='{{$i->id}}-all-status'
                    <?php
                      if ($i->status->status == 'New') { echo 'class=\'status-new\''; }
                      if ($i->status->status == 'Engineered') { echo 'class=\'status-engineered\''; }
                      if ($i->status->status == 'Sold') { echo 'class=\'status-sold\''; }
                      if ($i->status->status == 'Quoted') { echo 'class=\'status-quoted\''; }
                      if ($i->status->status == 'Lost') { echo 'class=\'status-lost\''; }
                    ?>
                  >{{ $i->status->status }}</td>
                  <td id='{{$i->id}}-all-bidDate'
                    <?php
                        if ($i->bidTiming == 'late' && ($i->status->status != 'Quoted') && ($i->status->status != 'Sold') && ($i->status->status != 'Lost')) { echo 'class=\'bidTiming-late\'';}
                        if ($i->bidTiming == 'soon' && ($i->status->status != 'Quoted') && ($i->status->status != 'Sold') && ($i->status->status != 'Lost')) { echo 'class=\'bidTiming-soon\''; }
                    ?>
                  >{{ $i->bidDate }}
                  </td>
                  <td id='{{$i->id}}-all-manufacturer'>{{ $i->manufacturer }}</td>
                  <td id='{{$i->id}}-all-product'>{{ $i->product }}</td>
                  <td id='{{$i->id}}-all-productSales'>
                    <?php
                      $array = explode(' ', $i->productSales->name);
                      $name = substr($array[0],0,1) . ' ' . $array[1];
                      echo $name;
                    ?>
                  </td>
                  <td id='{{$i->id}}-all-insideSales'>
                    <?php
                      $array = explode(' ', $i->insideSales->name);
                      $name = substr($array[0],0,1) . ' ' . $array[1];
                      echo $name;
                    ?>
                  </td>
                  <td id='{{$i->id}}-all-amount'>{{ $i->amount }}</td>
                  <td id='{{$i->id}}-all-apcOppId'>{{ $i->apc_opp_id }}</td>
                  <td></td>
                  <td id='{{$i->id}}-all-engineer'>{{ $i->engineer }}</td>
                  <td id='{{$i->id}}-all-contractor'>{{ $i->contractor }}</td>
                  <td><a class='table-note' data-toggle="{{$i->id}}-info">{{ str_limit($i->notes->first()->note,20) }}</a></td>
                </tr>

                @endforeach

              </tbody>
            </table>

            <script>
              @foreach ($allProjects as $i)
              // setup editables
              $(document).ready(function() {


                $('#{{$i->id}}-all-name').editable(
                  {
                    type: 'text',
                    pk: {{ $i->id }},
                    url: '/project/edit/name',
                    title: 'Enter Project Name',
                    disabled: true,
                    name: 'name',
                  }
                );

                $('#{{$i->id}}-all-status').editable(
                  {
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

                $('#{{$i->id}}-all-bidDate').editable(
                  {
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


                $('#{{$i->id}}-all-manufacturer').editable(
                  {
                    type: 'text',
                    pk: {{ $i->id }},
                    url: '/project/edit/manufacturer',
                    title: 'Enter Manufacturer',
                    disabled: true,
                    name: 'manufacturer',
                  }
                );

                $('#{{$i->id}}-all-product').editable(
                  {
                    type: 'text',
                    pk: {{ $i->id }},
                    url: '/project/edit/product',
                    title: 'Enter Product Name',
                    disabled: true,
                    name: 'product',
                  }
                );

                $('#{{$i->id}}-all-productSales').editable(
                  {
                    type: 'select',
                    pk: {{ $i->id }},
                    url: '/project/edit/product-sales',
                    title: 'Select Product Sales Rep',
                    value: {{ $i->product_sales_id }},
                    disabled: true,
                    name: 'productSales',
                    source: [
                      @foreach ($productSales as $item)
                      { value: {{ $item->id }}, text: '{{ $item->name }}'},
                      @endforeach
                    ]
                  }
                );

                $('#{{$i->id}}-all-insideSales').editable(
                  {
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

                $('#{{$i->id}}-all-amount').editable(
                  {
                    type: 'number',
                    pk: {{ $i->id }},
                    url: '/project/edit/amount',
                    title: 'Enter Amount',
                    disabled: true,
                    name: 'amount',
                  }
                );

                $('#{{$i->id}}-all-apcOppId').editable(
                  {
                    type: 'text',
                    pk: {{ $i->id }},
                    url: '/project/edit/apc-opp-id',
                    title: 'Enter APC OPP ID',
                    disabled: true,
                    name: 'apcOppId',
                  }
                );

                $('#{{$i->id}}-all-invoiceLink').editable(
                  {
                    type: 'text',
                    pk: {{ $i->id }},
                    url: '/project/edit/quote',
                    title: 'Edit Quote',
                    disabled: true,
                    name: 'quote'
                  }
                );

                $('#{{$i->id}}-all-engineer').editable(
                  {
                    type: 'text',
                    pk: {{ $i->id }},
                    url: '/project/edit/engineer',
                    title: 'Enter Engineer',
                    disabled: true,
                    name: 'engineer',
                  }
                );

                $('#{{$i->id}}-all-contractor').editable(
                  {
                    type: 'text',
                    pk: {{ $i->id }},
                    url: '/project/edit/contractor',
                    title: 'Enter Contractor',
                    disabled: true,
                    name: 'contractor',
                  }
                );

              });

              //enable editing of row on click of toggle link
              $('#{{$i->id}}-all-toggle').click(function(e) {
                e.stopPropagation();
                $('#{{$i->id}}-all-name').editable('toggleDisabled');
                $('#{{$i->id}}-all-status').editable('toggleDisabled');
                $('#{{$i->id}}-all-bidDate').editable('toggleDisabled');
                $('#{{$i->id}}-all-manufacturer').editable('toggleDisabled');
                $('#{{$i->id}}-all-product').editable('toggleDisabled');
                $('#{{$i->id}}-all-productSales').editable('toggleDisabled');
                $('#{{$i->id}}-all-insideSales').editable('toggleDisabled');
                $('#{{$i->id}}-all-amount').editable('toggleDisabled');
                $('#{{$i->id}}-all-apcOppId').editable('toggleDisabled');
                $('#{{$i->id}}-all-invoiceLink').editable('toggleDisabled');
                $('#{{$i->id}}-all-engineer').editable('toggleDisabled');
                $('#{{$i->id}}-all-contractor').editable('toggleDisabled');


                $('#{{$i->id}}-all-name').toggleClass('edit-enabled');
                $('#{{$i->id}}-all-status').toggleClass('edit-enabled');
                $('#{{$i->id}}-all-bidDate').toggleClass('edit-enabled');
                $('#{{$i->id}}-all-manufacturer').toggleClass('edit-enabled');
                $('#{{$i->id}}-all-product').toggleClass('edit-enabled');
                $('#{{$i->id}}-all-productSales').toggleClass('edit-enabled');
                $('#{{$i->id}}-all-insideSales').toggleClass('edit-enabled');
                $('#{{$i->id}}-all-amount').toggleClass('edit-enabled');
                $('#{{$i->id}}-all-apcOppId').toggleClass('edit-enabled');
                $('#{{$i->id}}-all-engineer').toggleClass('edit-enabled');
                $('#{{$i->id}}-all-contractor').toggleClass('edit-enabled');
              });


              @endforeach

            </script>
          </div>
        </div>


      </div>
    </div>
  </body>
  @include('footer')
  <script>

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }

    });

    $(document).foundation();

    $(document).ready(function() {

      $('#upcoming-projects-table').DataTable( {
        "order": [[ 3, 'asc']],
        'pageLength': 10,
      });


      $('#all-projects-table').DataTable( {
        "order": [[ 3, "desc" ]],
        'pageLength': 25,
      } );
    } );
  </script>



</html>
