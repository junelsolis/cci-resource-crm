@if ($project)
<div class='cell small-12 medium-4'>
  <div id='top' class='info-card' data-equalizer-watch>
    <div class='title'>
      <h5><strong><i class="fas fa-project-diagram"></i>&nbsp;Project Information</strong></h5>
    </div>
    <div class='content' style='padding:0px;'>

      <div class='table-scroll'>
        <table class='unstriped' style='color:#404040;'>
          <tbody style='border:none !important;'>
            <tr>
              <td style='width:20%;'><strong>Name</strong></td>
              <td>{{ $project->name}}</td>
            </tr>
            <tr>
              <td><strong>Status</strong></td>
              <td
                <?php
                  $status = $project['status']['status'];

                  if ($status == 'New') { echo 'class=\'status-new\''; }
                  if ($status == 'Engineered') { echo 'class=\'status-engineered\''; }
                  if ($status == 'Sold') { echo 'class=\'status-sold\''; }
                  if ($status == 'Quoted') { echo 'class=\'status-quoted\''; }
                  if ($status == 'Lost') { echo 'class=\'status-lost\''; }
                ?>
              >{{ $project['status']['status']}}</td>
            </tr>
            <tr>
              <td><strong>Bid Date</strong></td>
              <td
                <?php

                  $bidTiming = $project['bidTiming'];

                  if ($bidTiming == 'late' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-late\'';}
                  if ($bidTiming == 'soon' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-soon\''; }
                ?>
              >{{ $project['formattedBidDate'] }}</td>
            </tr>
            <tr>
              <td><strong>Manufacturer</strong></td>
              <td>{{ $project->manufacturer }}</td>
            </tr>
            <tr>
              <td><strong>Product</strong></td>
              <td>{{ $project->product }}</td>
            </tr>
            <tr>
              <td><strong>Product Sales</strong></td>
              <td>{{ $project['productSales']->name }}</td>
            </tr>
            <tr>
              <td><strong>Inside Sales</strong></td>
              <td>{{ $project['insideSales']->name }}</td>
            </tr>
            <tr>
              <td><strong>Amount</strong></td>
              <td>{{ $project['formattedAmount'] }}</td>
            </tr>
            <tr>
              <td><strong>APC OPP ID</strong></td>
              <td>{{ $project->apc_opp_id }}</td>
            </tr>
            <tr>
              <td><strong>Quote Link</strong></td>
              <td><a href='{{$project->invoice_link}}'>{{ str_limit($project->invoice_link,20) }}</a></td>
            </tr>
            <tr>
              <td><strong>Engineer</strong></td>
              <td>{{ $project->engineer}}</td>
            </tr>
            <tr>
              <td><strong>Contractor</strong></td>
              <td>{{ $project->contractor }}</td>
            </tr>
          </tbody>
        </table>
      </div>


    </div>
  </div>
</div>

<div class='cell small-12 medium-8'>
  <div class='info-card' style='padding:0;' data-equalizer-watch>
    <div class='title'>
      <h5><strong><i class="fas fa-sticky-note"></i>&nbsp;Project Notes</strong></h5>
    </div>
    <div class='content' style='padding:0px;'>
      <div class='table-scroll'>
          <table class='striped'>
            <tbody style='border:none !important;'>
              <tr>
                <td><a id='add-note' data-type='textarea'><i class="fas fa-plus"></i>&nbsp;Add Note</a></td>
                <script>

                  $.fn.editable.defaults.mode = 'inline';

                  $(function(){
                    $('#add-note').editable({
                      container: '#main',
                      url: '/note/add/{{$project->id}}',
                      title: 'Enter Note',
                      pk: {{ $project->id }},
                      rows: 4,
                      inputclass: 'textarea-width'
                    });
                  });


                </script>
              </tr>

              @forelse ($project->notes->reverse() as $i)
              <tr>
                <td>
                  <em id='note-{{$i->id}}'>{!! nl2br($i->note) !!}</em><br />&mdash; <strong>{{ $i->author->name}}</strong> on {{ $i['formattedDate'] }}<br /><br />

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
</div>

@endif
