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
      <div class='cell small-12'>
        <div class='card-top'>
          <h5><strong><i class="fas fa-project-diagram"></i>&nbsp;Project Information</strong></h5>
        </div>
        <div class='card-middle'>
          <div class='grid-x'>
            <div class='cell medium-6 large-3'>
              <ul>
                <li><strong>Name:</strong> {{ $project->name }}</li>
                <li><strong>Status:</strong> {{ $project['status']['status'] }}</li>
                <li><strong>Bid Date:</strong> {{ $project['formattedBidDate'] }}</li>
                <li><strong>Manufacturer:</strong> {{ $project->manufacturer }}</li>
                <li><strong>Product:</strong> {{ $project->product }}</li>
                <li><strong>Product Sales:</strong> {{ $project->insideSales->name }}</li>
              </ul>
            </div>
            <div class='cell medium-6 large-3'>
              <ul>
                <li><strong>Inside Sales:</strong> {{ $project->productSales->name }}</li>
                <li><strong>Amount:</strong> {{ $project['formattedAmount'] }}</li>
                <li><strong>APC OPP ID:</strong> {{ $project->apc_opp_id }}</li>
                <li><strong>Quote Link:</strong> <a href='{{$project->invoice_link}}'>{{ str_limit($project->invoice_link,20) }}</a></li>
                <li><strong>Engineer:</strong> {{ $project->engineer }}</li>
                <li><strong>Contractor:</strong> {{ $project->contractor }}</li>
              </ul>
            </div>
          </div>
        </div>
        <div class='card-bottom' style='background-color:#747d8c'>
          <div class='table-scroll'>
            <table class='unstriped' style='background-color:#dfe4ea;'>
              <tbody style='background-color:#dfe4ea;'>
                <tr>
                  <td><a id='add-note' data-type='textarea'><i class="fas fa-plus"></i>&nbsp;Add Note</a></td>
                  <script>

                    // $.fn.editable.sdefaults.mode = 'inline';

                    $(function(){
                      $('#add-note').editable({
                        container: '#main',
                        url: '/note/add/{{$project->id}}',
                        title: 'Enter Note',
                        pk: {{ $project->id }},
                        rows: 10
                      });
                    });


                  </script>
                </tr>

                @forelse ($project->notes->reverse() as $i)
                <tr>
                  <td>
                    <em>{!! nl2br($i->note) !!}</em><br />&mdash; <strong>{{ $i->author->name}}</strong> on {{ $i['formattedDate'] }}<br /><br />

                    @if ($i['isEditor'] == true && $i->editable == true)
                    <a id='{{$i->id}}-toggle' class='button tiny'><i class="fas fa-pen"></i>&nbsp;Edit</a>
                    <a href='/note/delete/{{ $i->id }}' class='button tiny secondary'><i class="fas fa-times"></i>&nbsp;Delete</a>
                    <script>

                        $('#note-{{$i->id}}').editable({
                          container: 'body',
                          type: 'textarea',
                          url: '/note/edit/{{$i->id}}',
                          title: 'Edit Note',
                          rows: 10,
                          pk: {{$i->id}},
                          disabled: true
                        });

                        $('#{{$i->id}}-toggle').click(function(e) {
                          e.stopPropagation();
                          $('#note-{{$i->id}}').editable('toggleDisabled');
                        });

                    </script>
                    @endif
                  </td>
                </tr>
                @empty
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class='cell small-12'>
        <div class='card-top'>
          <h5><strong>Other Projects</strong></h5>
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
