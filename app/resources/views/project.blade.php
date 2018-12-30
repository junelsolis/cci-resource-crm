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
  <div class='card-bottom' style='background-color:#747d8c;padding:0;'>
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
