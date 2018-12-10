<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Administrator | Critical Components</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel=stylesheet href="{{ asset('css/foundation.min.css')}}" />
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel='stylesheet' href="{{ asset('css/navbar.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/default.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/admin/main.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/foundation.min.js')}}"></script>
    <script src="{{ asset('js/Chart.min.js')}}"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
  </head>
  @include('navbar')
  <body>
    <div class='grid-x'>
      <div class='cell large-6'>
        <div class='card'>
          <h5><strong><i class="fas fa-chart-bar"></i>&nbsp;Statistics</strong></h5>
        </div>
      </div>
      <div class='cell large-6'>
        <div class='card'>
          <h5><strong><i class="fas fa-network-wired"></i>&nbsp;System Information</strong></h5>
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

              <div class='table-scroll'>
                <table class="unstriped">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Username</th>
                      <th>Created on</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($userDirectory as $user)
                    <tr>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->username }}</td>
                      <td>{{ $user->created_at }}</td>
                      <td><a href='/admin/user/{{ $user->id}}'><i class="fas fa-edit"></i></a></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </body>
  @include('footer')
  <script>
    $(document).foundation();
  </script>
</html>
