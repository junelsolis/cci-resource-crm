<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Administrator | Critical Components</title>
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

    <div id='main' class='grid-x'>

      @if (session('user-directory-success'))
      <div class='cell small-12'>
        <div class='card'>
          <div data-closable class="callout alert-callout-subtle success radius">
            <strong>Success</strong><br />{!! session('user-directory-success') !!}
            <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
              <span aria-hidden="true">⊗</span>
            </button>
          </div>
      </div>

      </div>
      @endif

      <div class='cell medium-4'>
        <div class='info-card'>
          <div class='title'>
            <h5><strong><i class="fas fa-user-plus"></i>&nbsp;Add User</strong></h5>
          </div>
          <div class='content'>
            <form method='post' action='/user/add'>
              {{ csrf_field() }}
            </form>
          </div>
        </div>
      </div>

      <div class='cell medium-8'>
        <div class='info-card'>
          <div class='title-muted'>
            <h5><strong><i class="fas fa-users"></i>&nbsp;Directory</strong></h5>
          </div>
          <div class='content'>
            <div class='table-scroll'>
              <table id='users-table' class="unstriped">
                <thead>
                  <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Roles</th>
                    <th>Password</th>
                    <th>Last Login</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $user)
                  <tr>
                    <td><a id='{{$user->id}}-toggle' title='Click to Edit'><i class="fas fa-edit"></i></a></td>
                    <td id='{{ $user->id}}-name'>{{ $user->name }}</td>
                    <td id='{{ $user->id}}-username'>{{ $user->username }}</td>
                    <td id='{{ $user->id}}-roles'>
                      @foreach ($user['roles'] as $role)
                      {{ $role }}<br />
                      @endforeach
                    </td>
                    <td><a data-open='{{$user->id}}-password-modal'><i class="fas fa-sync-alt"></i>&nbsp;Reset Password</a></td>
                    <td id='{{ $user->id}}->lastLogin'>{{ $user->lastLogin }}</a></td>
                  </tr>

                  <script>

                  $.ajaxSetup({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }

                  });

                  $(document).ready(function() {
                    $('#{{$user->id}}-name').editable(
                      {
                        type: 'text',
                        pk: {{ $user->id }},
                        url: '/user/edit/name',
                        title: 'Enter Name',
                        disabled: true,
                        name: 'name',
                      }
                    );

                    $('#{{$user->id}}-username').editable(
                      {
                        type: 'text',
                        pk: {{ $user->id }},
                        url: '/user/edit/username',
                        title: 'Enter Name',
                        disabled: true,
                        name: 'username',
                      }
                    );

                    $('#{{$user->id}}-roles').editable(
                      {
                        type: 'checklist',
                        pk: {{ $user->id }},
                        url: '/user/edit/roles',
                        title: 'Select Roles',
                        disabled: true,
                        name: 'roles',
                        source: [
                          { value: 'product-sales', text: 'Product Sales' },
                          { value: 'inside-sales', text: 'Inside Sales' },
                          { value: 'executive', text: 'Executive' },
                          { value: 'administrator', text: 'Administrator' },
                        ]
                      }
                    );
                  });

                  // enable editing of row on click of toggle link
                  $('#{{$user->id}}-toggle').click(function(e) {
                    e.stopPropagation();
                    $('#{{$user->id}}-name').editable('toggleDisabled');
                    $('#{{$user->id}}-username').editable('toggleDisabled');
                    $('#{{$user->id}}-roles').editable('toggleDisabled');

                    $('#{{$user->id}}-name').toggleClass('edit-enabled');
                    $('#{{$user->id}}-username').toggleClass('edit-enabled');
                    $('#{{$user->id}}-roles').toggleClass('edit-enabled');

                  });
                  </script>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class='cell medium-12' data-equalizer>
        <div class='grid-x'>
          <div class='cell medium-4'>
            <div class="card" data-equalizer-watch>
              <h5><strong><i class="fas fa-user"></i>&nbsp;Add User</strong></h5>
              <form method='post' action='/admin/user/add'>
                {{ csrf_field() }}
                <fieldset class='fieldset'>
                  <legend>
                    User Details
                  </legend>
                  <label>Full Name</label>
                  <input type='text' name='name' required />
                </fieldset>
                <fieldset class='fieldset'>
                  <legend>
                    Select Roles
                  </legend>

                  <input name='roles[]' value='product-sales' type='checkbox' /><label>Product&nbsp;Sales</label><br />
                  <input name='roles[]' value='inside-sales' type='checkbox' /><label>Inside&nbsp;Sales</label><br />
                  <input name='roles[]' value='executive' type='checkbox' /><label>Executive</label><br />
                  <input name='roles[]' value='administrator' type='checkbox' /><label>System Administrator</label>
                </fieldset>

                @if ($errors->any())
                  @foreach ($errors->all() as $error)
                  <div data-closable class="callout alert-callout-subtle warning radius">
                    <strong>Error</strong><br />{{ $error }}
                    <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                      <span aria-hidden="true">⊗</span>
                    </button>
                  </div>
                  @endforeach
                @endif

                @if (session('error'))
                <div data-closable class="callout alert-callout-subtle warning radius">
                  <strong>Error</strong><br />{{ session('error') }}
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

                <button type='submit' class='button button-primary'><i class="fas fa-check"></i>&nbsp;Create User</button>
              </form>
            </div>
          </div>
          <div class='cell medium-8'>
            <div class="card" data-equalizer-watch>
              <h5><strong><i class="fas fa-users"></i>&nbsp;Directory</strong></h5>
              <br />
              <input type='text' placeholder='Find user' />


            </div>


          </div>
        </div>


        <!-- Modals -->
        @foreach ($users as $user)
        <div class='reveal' id='{{$user->id}}-password-modal' style='text-align: center;' data-reveal>
          <h5 style="color:#707070;">Confirm password change for</h5>
          <h3 style='font-weight:bolder;'>{{ $user->name}}</h3>
          <br /><br />
          <form action='/admin/user/reset/{{ $user->id }}' method='post'>
            {{ csrf_field() }}
            <div class='button-group align-center'>
              <button type='submit' class='primary button'><i class="fas fa-sync"></i>&nbsp;Reset Password</button>
              <button class='secondary button' data-close aria-label="Close modal">Cancel</button>
            </div>
          </form>

        </div>
        @endforeach
      </div>
    </div>
  </body>
  @include('footer')
  <script>
    $(document).foundation();

    $.fn.dataTable.moment( 'MM/DD/YYYY' );

    $('#users-table').DataTable( {
      'pageLength': 10,
    });
  </script>
</html>
