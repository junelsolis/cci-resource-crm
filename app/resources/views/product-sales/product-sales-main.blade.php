<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Product Sales | Critical Components</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel=stylesheet href="{{ asset('css/foundation.min.css')}}" />
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">

    <link rel='stylesheet' href="{{ asset('css/navbar.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/default.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/product-sales/product-sales-main.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/foundation.min.js')}}"></script>
    <script src="{{ asset('js/Chart.min.js')}}"></script>
    <script src="{{ asset('js/list.min.js') }}"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

  </head>
  @include('navbar')
  <body>
    @if ($errors->any())
    <div data-closable class="callout alert-callout-subtle warning radius">
      <strong>Error</strong><br />
      @foreach ($errors->all() as $error)
      {{ $error }}<br />;
      @endforeach
      <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
        <span aria-hidden="true">⊗</span>
      </button>
    </div>
    @endif

    @if (session('error'))
    <div data-closable class="callout alert-callout-subtle warning radius">
      <strong>Error</strong><br />{{ session('error') }}
      <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
        <span aria-hidden="true">⊗</span>
      </button>
    </div>
    @endif

    @if (session('change-password-error'))
    <div data-closable class="callout alert-callout-subtle warning radius">
      <strong>Error</strong><br />{{ session('change-password-error') }}
      <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
        <span aria-hidden="true">⊗</span>
      </button>
    </div>
    @endif

    @if (session('success'))
    <div data-closable class="callout alert-callout-subtle success radius">
      <strong>Success</strong><br />{!! session('success') !!}
      <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
        <span aria-hidden="true">⊗</span>
      </button>
    </div>

    @endif
    <div id='main' class='grid-x' data-equalizer>

      <div class='cell medium-6 large-4'>
        <div id='upcoming-projects' class='card' data-equalizer-watch>
          <h5><strong><i class="fas fa-clock"></i>&nbsp;Upcoming Projects</strong></h5>
          <br />
          <table class='unstriped'>
            <tbody>
              @foreach ($upcomingProjects as $item)
              <tr>
                <td><strong>{{ $item->bid_date }}</strong></td>
                <td>{{ $item->name}}</td>
                <td>{{ $item->amount }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class='cell medium-6 large-4'>
        <div class='card'  data-equalizer-watch>
          <h5><strong><i class="fas fa-chart-bar"></i>&nbsp;Sales</strong></h5>
          <div class='grid-x'>
            <div class='cell large-6'>
              <canvas id="myChart2" height="180px"></canvas>
            </div>
            <div class='cell large-6'>
              <canvas id='projected-sales' height='180px'></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class='cell medium-12 large-4'>
        <div class='card' data-equalizer-watch>
          <h5><strong><i class="fas fa-chart-bar"></i>&nbsp;Projects</strong></h5>
          <div class='grid-x'>
            <div class='cell large-6'>
              <canvas id="projectStatus" height="180px"></canvas>
            </div>
            <div class='cell large-6'>
              <canvas id="myChart3" height="180px"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class='cell small-12'>
        <div id='projects' class='card'>
          <div class='grid-x align-middle'>
            <div class='cell medium-6 large-2'>
              <h5><strong><i class="fas fa-project-diagram"></i>&nbsp;My Projects</strong></h5>
            </div>
            <div class='cell medium-6 large-10'>
              <ul class='menu align-right'>
                <li><a href='#' data-open="add-project-modal"><i class="fas fa-plus"></i>&nbsp;Add Project</a></li>
                <li><input type='text' class='search' placeholder='Search Projects' /></li>
              </ul>

            </div>


            <div class='reveal large' id='add-project-modal' data-reveal>
              <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
              </button>

              <span><i class="fas fa-clipboard-list"></i>&nbsp;Add Project</span>
              <form method='post' action='/project/add'>
                {{ csrf_field() }}
                <fieldset class='fieldset'>
                  <legend>
                    Product Details
                  </legend>
                  <div class='grid-x grid-padding-x'>
                    <div class='cell medium-4'>
                      <label><span><i class="fas fa-star-of-life"></i>&nbsp;</span>Project Name</label>
                      <input type='text' name='name' required />
                    </div>
                    <div class='cell medium-4'>
                      <label><span><i class="fas fa-star-of-life"></i>&nbsp;</span>Product</label>
                      <input type='text' name='product' required />
                    </div>
                    <div class='cell medium-4'>
                      <label>Manufacturer</label>
                      <input type='text' name='manufacturer' />
                    </div>
                  </div>
                </fieldset>

                <fieldset class='fieldset'>
                  <legend>
                    Bid Information
                  </legend>
                  <div class='grid-x grid-padding-x'>
                    <div class='cell medium-4'>
                      <label><span><i class="fas fa-star-of-life"></i>&nbsp;</span>Bid Date</label>
                      <input type='date' name='bid_date' required />
                    </div>
                    <div class='cell medium-4'>
                      <label><span><i class="fas fa-star-of-life"></i>&nbsp;</span>Status</label>
                      <select name='status_id' required>
                        <option value="" selected disabled hidden>Select One</option>
                        @foreach ($projectStatusCodes as $code)
                        <option value='{{ $code->id }}'>{{ $code->status }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class='cell medium-4'>
                      <label><span><i class="fas fa-star-of-life"></i>&nbsp;</span>Amount</label>
                      <input type='number' name='amount' required placeholder='$' />
                    </div>
                    <div class='cell medium-4'>
                      <label><span><i class="fas fa-star-of-life"></i>&nbsp;</span>Inside Sales</label>
                      <select name='inside_sales_id' required>
                        <option value="" selected disabled hidden>Select One</option>
                        @foreach ($insideSales as $item)
                        <option value='{{ $item->id }}'>{{ $item->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </fieldset>

                <fieldset class='fieldset'>
                  <legend>
                    External Information
                  </legend>
                  <div class='grid-x grid-padding-x'>
                    <div class='cell large-6'>
                      <label>APC OPP ID</label>
                      <input type='text' name='apc_opp_id' />
                    </div>
                    <div class='cell large-6'>
                      <label>Quote Link</label>
                      <input type='text' name='invoice_link' />
                    </div>
                  </div>
                </fieldset>

                <fieldset class='fieldset'>
                  <legend>
                    Additional Information
                  </legend>
                  <div class='grid-x grid-padding-x'>
                    <div class='cell medium-6 large-4'>
                      <label>Engineer</label>
                      <input type='text' name='engineer' />
                    </div>
                    <div class='cell medium-6 large-4'>
                      <label>Contractor</label>
                      <input type='text' name='contractor' />
                    </div>
                  </div>
                </fieldset>

                <fieldset class='fieldset'>
                  <legend>
                    Note
                  </legend>
                  <textarea name='note' width='100%'></textarea>
                </fieldset>

                <div style='font-style:italic;'>
                  Fields marked with "<span style='color: red;font-size:0.5em;position:relative;top:-3px;'><i class="fas fa-star-of-life"></i></span>" are required.
                </div>
                <br />
                <button type='submit' class='button button-primary'><i class="fas fa-plus"></i>&nbsp;Add Project</button>

              </form>

            </div>

          </div>
          <br />
          <div class='table-scroll'>
            <table class="unstriped">
              <thead>
                <tr>
                  <th></th>
                  <th class='sort' data-sort='name'>Name</th>
                  <th class='sort' data-sort='status'>Status</th>
                  <th class='sort' data-sort='bidDate'>Bid Date</th>
                  <th class='sort' data-sort='manufacturer'>Manufacturer</th>
                  <th class='sort' data-sort='product'>Product</th>
                  <th class='sort' data-sort='insideSales'>Inside Sales</th>
                  <th class='sort' data-sort='amount'>Amount</th>
                  <th class='sort' data-sort='apcOppId'>APC OPP ID</th>
                  <th>Quote</th>
                  <th class='sort' data-sort='engineer'>Engineer</th>
                  <th class='sort' data-sort='contractor'>Contractor</th>
                  <th>Note</th>
                </tr>
              </thead>
              <tbody class='list'>
                @foreach ($projects as $i)
                <tr>
                  <td><a id='{{$i->id}}-toggle' title='Click to Edit'><i class="fas fa-edit"></i></a></td>
                  <td class='name' id='{{$i->id}}-name'>{{ $i->name }}</td>
                  <td class='status'  id='{{$i->id}}-status'>{{ $i->status->status }}</td>
                  <td class='bidDate'  id='{{$i->id}}-bidDate'>{{ $i->bidDate }}</td>
                  <td class='manufacturer'  id='{{$i->id}}-manufacturer'>{{ $i->manufacturer}}</td>
                  <td class='product'  id='{{$i->id}}-product'>{{ $i->product }}</td>
                  <td class='insideSales'  id='{{$i->id}}-insideSales'>{{ $i->insideSales->name }}</td>
                  <td class='amount'  id='{{$i->id}}-amount'>{{ $i->amount }}</td>
                  <td class='apcOppId'  id='{{$i->id}}-apcOppId'>{{ $i->apc_opp_id }}</td>
                  <td>
                    @if (isset($i->invoice_link))
                    <a id='{{$i->id}}-invoiceLink' href='{{ $i->invoice_link }}' target='_blank'><i class="fas fa-file-invoice"></i></a>
                    @endif
                  </td>
                  <td class='engineer'  id='{{$i->id}}-engineer'>{{ $i->engineer}}</td>
                  <td class='contractor'  id='{{$i->id}}-contractor'>{{ $i->contractor }}</td>
                  <td><a data-open="{{$i->id}}-notes-modal" style='font-style:italic;color:rgba(54, 162, 235, 1);'>{{ $i->notes->first()->note }}</a></td>
                </tr>

                <div class='reveal' id='{{$i->id}}-notes-modal' data-reveal>
                  <button class="close-button" data-close aria-label="Close modal" type="button">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h3><strong>Project Notes</strong> &mdash; {{ $i->name }}</h3>
                  <br />
                  <!-- <i class="fas fa-plus"></i>&nbsp;Add Note -->
                  <form method='post' action='/note/add/{{ $i->id }}'>
                    {{ csrf_field() }}
                    <textarea name='note' placeholder="Add Note"></textarea>
                    <button type='submit' class='button button-primary' style='margin-top:10px;'><i class="fas fa-plus"></i>&nbsp;Add Note</button>
                  </form>
                  <br />
                  @foreach ($i->notes as $note)
                  <div class="callout secondary">
                    <h5>{{ $note->note }}</h5>
                    <p style='color:grey;'>
                      &mdash;&nbsp;<em>{{ $note->author }}</em> on {{ $note->date }}
                    </p>
                  </div>
                  @endforeach
                </div>

                <script>

                  $.ajaxSetup({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }

                  });

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
                    $('#{{$i->id}}-contractor').toggleClass('edit-enabled');
                  });


                </script>


                @endforeach
              </tbody>

              <!-- script for list.js on table -->
              <script>
                var options = {
                  valueNames: [
                    'name',
                    'status',
                    'bidDate',
                    'manufacturer',
                    'product',
                    'insideSales',
                    'amount',
                    'apcOppId',
                    'engineer',
                    'contractor'
                  ]
                  };
                var projectList = new List('projects', options);

              </script>
            </table>

          </div>
          <div class='grid-x align-middle'>
            <div class='cell medium-6 large-2'>
              <a href='#upcoming-projects'><i class="fas fa-angle-double-up"></i>&nbsp;Back to Top</a>
            </div>
            <!-- <div class='cell medium-6 large-10'>
              <ul class='menu align-right'>
                <li><a href='#' data-open="add-project-modal"><i class="fas fa-plus"></i>&nbsp;Add Project</a></li>
                <li><input type='text' placeholder='Search for Project'/></li>
              </ul>
            </div> -->
          </div>
        </div>
      </div>
      <div class='cell small-12'>
        <div id='other-projects' class='card'>
          <div class='grid-x align-middle'>
            <div class='cell medium-6 large-2'>
              <h5><strong><i class="fas fa-users-cog"></i>&nbsp;Other Projects</strong></h5>
            </div>
            <div class='cell medium-6 large-10'>
              <ul class='menu align-right'>
                <li><input type='text' class='search' placeholder='Search Projects' /></li>
              </ul>

            </div>
          </div>
          <br />
          <div class='table-scroll'>
            <table class='unstriped'>
              <thead>
                <tr>
                  <th class='sort' data-sort='salesRep'>Sales Rep</th>
                  <th class='sort' data-sort='name'>Name</th>
                  <th class='sort' data-sort='status'>Status</th>
                  <th class='sort' data-sort='bidDate'>Bid Date</th>
                  <th class='sort' data-sort='manufacturer'>Manufacturer</th>
                  <th class='sort' data-sort='product'>Product</th>
                  <th class='sort' data-sort='insideSales'>Inside Sales</th>
                  <th class='sort' data-sort='amount'>Amount</th>
                  <th class='sort' data-sort='apcOppId'>APC OPP ID</th>
                  <th class='sort' data-sort='engineer'>Engineer</th>
                  <th class='sort' data-sort='contractor'>Contractor</th>
                </tr>
              </thead>
              <tbody class='list'>
                @foreach ($otherProjects as $i)
                <tr>
                  <td class='salesRep'>{{ $i->productSales->name }}</td>
                  <td class='name'>{{ $i->name }}</td>
                  <td class='status'>{{ $i->status->status }}</td>
                  <td class='bidDate'>{{ $i->bidDate }}</td>
                  <td class='manufacturer'>{{ $i->manufacturer}}</td>
                  <td class='product'>{{ $i->product }}</td>
                  <td class='insideSales'>{{ $i->insideSales->name }}</td>
                  <td class='amount'>{{ $i->amount }}</td>
                  <td class='apcOppId'>{{ $i->apc_opp_id }}</td>
                  <td class='engineer'>{{ $i->engineer}}</td>
                  <td class='contractor'>{{ $i->contractor}}</td>
                </tr>
                @endforeach
              </tbody>

              <!-- script for list.js on table -->
              <script>
                var options = {
                  valueNames: [
                    'salesRep',
                    'name',
                    'status',
                    'bidDate',
                    'manufacturer',
                    'product',
                    'insideSales',
                    'amount',
                    'apcOppId',
                    'engineer',
                    'contractor'
                  ]
                  };
                var otherProjectsList = new List('other-projects', options);

              </script>
            </table>
          </div>
          <div class='grid-x align-middle'>
            <div class='cell medium-6 large-2'>
              <a href='#upcoming-projects'><i class="fas fa-angle-double-up"></i>&nbsp;Back to Top</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  @include('footer')
  <script>
    $(document).foundation();
    //$.fn.editable.defaults.mode = 'inline';


  </script>

  <!-- charts -->
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


    var ctx = document.getElementById("projectStatus").getContext('2d');
    var projectStatus = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["New","Quoted","Sold","Engineered","Lost"],
            datasets: [{
                data: [11,13,9,8,15],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',

                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',

                ],
                borderWidth: 1
            }]
        },
        options: {
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Project Status (Last 12 Months)'
          },
          legend: {
            display: true,
            position: 'left',
          },
        }
    });

    var ctx = document.getElementById("projected-sales").getContext('2d');
    var myChart2 = new Chart(document.getElementById("projected-sales"), {
      type: 'line',
      data: {
        labels: ['Dec','Jan','Feb','Mar','Apr','May'],
        datasets: [{
            data: [8600,7900,16000,7000,10000,12000],
            label: "",
            borderColor: "rgba(255,99,132,1)",
            fill: false
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        title: {
          display: true,
          text: 'Projected Sales (Next 6 months)'
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
            labels: ["Dec", "Jan", "Feb", "Mar", "Apr", "May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
            datasets: [{
                data: [11,13,9,8,15,7,9,12,13,6,3,10],
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
            text: 'Project Counts (Last 12 Months)'
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
</html>
