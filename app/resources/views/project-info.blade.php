<div class="off-canvas position-right project-info" id="{{$i->id}}-all-projects-info" data-off-canvas data-auto-focus="false">
  <h4><span>{{ $i->name }}</span>&nbsp;</h4>
  <br /><br />

  <form method='post' action='/note/add/{{ $i->id }}'>
    {{ csrf_field() }}
    <input type='hidden' name='editable' value='true' />
    <textarea name='note' required placeholder='Type note here...'></textarea>
    <button type='submit' class='primary button'><i class="fas fa-check"></i>&nbsp;Save</button>
  </form>
  <br />

  @if (isset($i->notes))
  @foreach ($i->notes->reverse() as $note)
  <div class="note-card">

    <span id='note-{{$note->id}}-all-projects'>{!! $note->note !!}</span><br /><br />
    @if ($note['isEditor'] == true && $note->editable == true)
    <a id='{{$note->id}}-note-edit-all-projects-toggle' class='button tiny'><i class="fas fa-pen"></i>&nbsp;Edit</a>
    <a href='/note/delete/{{ $note->id }}' class='button tiny secondary'><i class="fas fa-times"></i>&nbsp;Delete</a>
    <script>

      // $(document).ready(function() {
        $('#note-{{$note->id}}-all-projects').editable({
          container: 'body',
          type: 'textarea',
          url: '/note/edit/{{$note->id}}',
          title: 'Edit Note',
          rows: 10,
          pk: {{$note->id}},
          disabled: true
        });

        $('#{{$note->id}}-note-edit-all-projects-toggle').click(function(e) {
          e.stopPropagation();
          $('#note-{{$note->id}}-all-projects').editable('toggleDisabled');
        });

      // });
    </script>
    <br />
    @endif
    <p>
      <strong>{{ $note->author->name }}</strong> on {{ $note['formattedDate'] }}
    </p>

  </div>
  @endforeach
  @endif
  <span style='color:lightgrey;font-style:italic;text-align:center'>---- End ----</span>

</div>
