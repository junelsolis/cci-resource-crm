@if ($project)
<div class='cell small-12 medium-4'>
  <div id='top' class='info-card' data-equalizer-watch>
    <div class='title'>
      <h5><strong><i class="fas fa-project-diagram"></i>&nbsp;Project Information</strong></h5>
    </div>
    <div class='content'>
      @if ($project->canEdit() == true)
      <div style='padding-left:10px;'>
        <a id='project-toggle'><i class="fas fa-edit"></i>&nbsp;Edit Project</a>
      </div>
      @endif
      <div class='table-scroll'>
        <table class='unstriped' style='color:#404040;'>
          <tbody style='border:none !important;'>
            <tr>
              <td style='width:20%;'><strong>Name</strong></td>
              <td id='project-name'>{{ $project->name}}</td>
            </tr>
            <tr>
              <td><strong>Status</strong></td>
              <td id='project-status'
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
              <td id='project-bidDate'
                <?php

                  $bidTiming = $project['bidTiming'];

                  if ($bidTiming == 'late' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-late\'';}
                  if ($bidTiming == 'soon' && ($status != 'Quoted') && ($status != 'Sold') && ($status != 'Lost')) { echo 'class=\'bidTiming-soon\''; }
                ?>
              >{{ $project['formattedBidDate'] }}</td>
            </tr>
            <tr>
              <td><strong>Manufacturer</strong></td>
              <td id='project-manufacturer'>{{ $project->manufacturer }}</td>
            </tr>
            <tr>
              <td><strong>Product</strong></td>
              <td id='project-product'>{{ $project->product }}</td>
            </tr>
            <tr>
              <td><strong>Product Sales</strong></td>
              <td id='project-productSales'>{{ $project['productSales']['formattedName']['initials'] }} &dash; {{ $project['productSales']->name }}</td>
            </tr>
            <tr>
              <td><strong>Inside Sales</strong></td>
              <td id='project-insideSales'>{{ $project['insideSales']->name }}</td>
            </tr>
            <tr>
              <td><strong>Amount</strong></td>
              <td id='project-amount'>{{ $project['formattedAmount'] }}</td>
            </tr>
            <tr>
              <td><strong>APC OPP ID</strong></td>
              <td id='project-apcOppId'>{{ $project->apc_opp_id }}</td>
            </tr>
            <tr>
              <td><strong>Quote Link</strong></td>
              <td id='project-invoiceLink'><a href='{{$project->invoice_link}}'>{{ str_limit($project->invoice_link,20) }}</a></td>
            </tr>
            <tr>
              <td><strong>Engineer</strong></td>
              <td id='project-engineer'>{{ $project->engineer}}</td>
            </tr>
            <tr>
              <td><strong>Contractor</strong></td>
              <td id='project-contractor'>{{ $project->contractor }}</td>
            </tr>
          </tbody>
        </table>
      </div>


    </div>
  </div>
</div>

<!-- initialize editables for project -->
<script>

  // $.fn.editable.defaults.mode = 'inline';
  $('#project-name').editable(
    {
      container: 'body',
      type: 'text',
      pk: {{ $project->id }},
      url: '/project/edit/name',
      title: 'Enter Project Name',
      disabled: true,
      name: 'name',
    }
  );

  $('#project-status').editable(
    {
      container: 'body',
      type: 'select',
      pk: {{ $project->id }},
      url: '/project/edit/status',
      title: 'Choose Status',
      disabled: true,
      name: 'status',
      value: {{ $project->status_id}},
        source: [
          @foreach ($projectStatusCodes as $code)
          { value: {{ $code->id }}, text: '{{ $code->status }}'},
          @endforeach
        ]
    }
  );

  $('#project-bidDate').editable(
    {
      container: 'body',
      type: 'date',
      pk: {{ $project->id }},
      url: '/project/edit/bid-date',
      title: 'Select Bid Date',
      disabled: true,
      name: 'bidDate',
      format: 'yyyy-mm-dd',
      viewformat: 'mm/dd/yyyy',
      datepicker: {
        weekStart: 1
      },
      placement: 'bottom'
    }
  );


  $('#project-manufacturer').editable(
    {
      container: 'body',
      type: 'text',
      pk: {{ $project->id }},
      url: '/project/edit/manufacturer',
      title: 'Enter Manufacturer',
      disabled: true,
      name: 'manufacturer',
    }
  );

  $('#project-product').editable(
    {
      container: 'body',
      type: 'text',
      pk: {{ $project->id }},
      url: '/project/edit/product',
      title: 'Enter Product Name',
      disabled: true,
      name: 'product',
    }
  );

  $('#project-productSales').editable(
    {
      container: 'body',
      type: 'select',
      pk: {{ $project->id }},
      url: '/project/edit/product-sales',
      title: 'Select Product Sales Rep',
      value: {{ $project->product_sales_id }},
      disabled: true,
      name: 'productSales',
      source: [
        @foreach ($productSales as $item)
        { value: {{ $item->id }}, text: '{{$item['formattedName']['initials']}} - {{ $item->name }}'},
        @endforeach
      ]
    }
  );


  $('#project-insideSales').editable(
    {
      container: 'body',
      type: 'select',
      pk: {{ $project->id }},
      url: '/project/edit/inside-sales',
      title: 'Select Inside Sales Rep',
      value: {{ $project->inside_sales_id }},
      disabled: true,
      name: 'insideSales',
      source: [
        @foreach ($insideSales as $item)
        { value: {{ $item->id }}, text: '{{ $item->name }}'},
        @endforeach
      ]
    }
  );

  $('#project-amount').editable(
    {
      container: 'body',
      type: 'number',
      pk: {{ $project->id }},
      url: '/project/edit/amount',
      title: 'Enter Amount',
      disabled: true,
      name: 'amount',
    }
  );

  $('#project-apcOppId').editable(
    {
      container: 'body',
      type: 'text',
      pk: {{ $project->id }},
      url: '/project/edit/apc-opp-id',
      title: 'Enter APC OPP ID',
      disabled: true,
      name: 'apcOppId',
    }
  );

  $('#project-invoiceLink').editable(
    {
      container: 'body',
      type: 'text',
      pk: {{ $project->id }},
      url: '/project/edit/quote',
      title: 'Edit Quote',
      disabled: true,
      name: 'quote'
    }
  );

  $('#project-engineer').editable(
    {
      container: 'body',
      type: 'text',
      pk: {{ $project->id }},
      url: '/project/edit/engineer',
      title: 'Enter Engineer',
      disabled: true,
      name: 'engineer',
    }
  );

  $('#project-contractor').editable(
    {
      container: 'body',
      type: 'text',
      pk: {{ $project->id }},
      url: '/project/edit/contractor',
      title: 'Enter Contractor',
      disabled: true,
      name: 'contractor',
    }
  );



  // enable editing of row on click of toggle link
  $('#project-toggle').click(function(e) {
    e.stopPropagation();
    $('#project-name').editable('toggleDisabled');
    $('#project-status').editable('toggleDisabled');
    $('#project-bidDate').editable('toggleDisabled');
    $('#project-manufacturer').editable('toggleDisabled');
    $('#project-product').editable('toggleDisabled');
    $('#project-productSales').editable('toggleDisabled');
    $('#project-insideSales').editable('toggleDisabled');
    $('#project-amount').editable('toggleDisabled');
    $('#project-apcOppId').editable('toggleDisabled');
    $('#project-invoiceLink').editable('toggleDisabled');
    $('#project-engineer').editable('toggleDisabled');
    $('#project-contractor').editable('toggleDisabled');


    $('#project-name').toggleClass('edit-enabled');
    $('#project-status').toggleClass('edit-enabled');
    $('#project-bidDate').toggleClass('edit-enabled');
    $('#project-manufacturer').toggleClass('edit-enabled');
    $('#project-product').toggleClass('edit-enabled');
    $('#project-productSales').toggleClass('edit-enabled');
    $('#project-insideSales').toggleClass('edit-enabled');
    $('#project-amount').toggleClass('edit-enabled');
    $('#project-apcOppId').toggleClass('edit-enabled');
    $('#project-invoiceLink').toggleClass('edit-enabled');
    $('#project-engineer').toggleClass('edit-enabled');
    $('#project-contractor').toggleClass('edit-enabled');
  });
</script>


<!-- card for notes -->
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
