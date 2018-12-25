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
                  <span class='stat'>{{ $person->ongoingProjects->count() }}</span>
                  <span class='stat-title'>Ongoing Projects</span><br />

                  <span class='stat'>{{ $person->projectsThisYear->where('status_id', 3)->count() }}</span>
                  <span class='stat-title'>Projects Sold</span><br />

                  <span class='stat'>{{ $person->projectsThisYear->count() }}</span>
                  <span class='stat-title'>Total Projects</span>
                </div>
              </div>
              <div class='cell medium-4'>
                project counts
              </div>
              <div class='cell medium-4'>
                project status
              </div>

            </div>
          </div>

          <div class='table'>
            <h5><strong><i class="fas fa-project-diagram"></i>&nbsp;Ongoing Projects</strong></h5>
            <div class='table-scroll'>
              <table id='ongoing-projects-table' class='unstriped'>
                <thead>
                  <tr>
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
                  </tr>
                </thead>
                <tbody>
                  @foreach ($person->ongoingProjects() as $i)
                  <tr>
                    <td>{{ $i->name }}</td>
                    <td>{{ $i->product }}</td>
                    <td
                      <?php

                        $status = $i->status()->status;
                        $bidTiming = $i->bidTiming();

                        if ($status == 'New') { echo 'class=\'status-new\''; }
                        if ($status == 'Engineered') { echo 'class=\'status-engineered\''; }
                        if ($status == 'Sold') { echo 'class=\'status-sold\''; }
                        if ($status == 'Quoted') { echo 'class=\'status-quoted\''; }
                        if ($status == 'Lost') { echo 'class=\'status-lost\''; }
                      ?>
                    >{{ $i->status()->status }}</td>
                    <td
                    <?php


                      if ($bidTiming == 'late' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-late\'';}
                      if ($bidTiming == 'soon' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-soon\''; }
                    ?>
                    >{{ $i->formattedBidDate() }}</td>
                    <td>{{ $i->insideSales->name }}</td>
                    <td>{{ $i->formattedAmount() }}</td>
                    <td>{{ $i->apc_opp_id }}</td>
                    <td>
                      @if (isset($i->invoice_link))
                      <a href='{{ $i->invoice_link }}' target='_blank'><i class="fas fa-link"></i></i></a>
                      @endif
                    </td>
                    <td>{{ $i->engineer }}</td>
                    <td>{{ $i->contractor }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

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
