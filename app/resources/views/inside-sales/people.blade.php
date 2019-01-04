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
    <div id='main' class='grid-x off-canvas-content' data-equalizer data-equalize-on="medium" data-off-canvas-content>
      @include('person')

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
          <input id='date' type='date' name='bid_date' required />

          <script>
            if ( $('#date')[0].type != 'date' ) $('#date').datepicker({
              //altField: '#actualDate',
              altFormat: 'yy-mm-dd'
            });
          </script>

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
            @foreach ($productSalesReps as $item)
            <option value='{{ $item->id }}'>{{ $item->name }}</option>
            @endforeach
          </select>

          <label>Inside Sales<span><i class="fas fa-star-of-life"></i></span></label>
          <select name='inside_sales_id' required>
            <option value="" selected disabled hidden>Select One</option>
            @foreach ($insideSalesReps as $item)
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

    @include('footer')

  </body>

  <!-- some initialization scripts -->
  <script>

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }

    });

    $(document).foundation();


  </script>


</html>
