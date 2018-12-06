<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Administrator | Critical Components</title>
    <link rel=stylesheet href="{{ asset('css/foundation.min.css')}}" />
    <link rel='stylesheet' href="{{ asset('css/navbar.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/default.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/admin/main.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/foundation.min.js')}}"></script>
  </head>
  @include('navbar')
  <body>
    <div class='grid-x'>
      <div class='cell medium-6 large-4'>
        <div class="card">
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

      <div class='cell medium-6 large-5'>
        <div class='card'>
          <h5><strong><i class="fas fa-chart-bar"></i>&nbsp;Statistics</strong></h5>

          <div class='grid-x grid-padding-x'>
            <div class='stat cell auto'>
              <div class='value'>
                {{ $stats->totalUsers }}
              </div>
              <div class='title'>
                Total Users
              </div>
            </div>
            <div class='stat cell auto'>
              <div class='value'>
                2
              </div>
              <div class='title'>
                Admins
              </div>
            </div>
            <div class='stat cell auto'>
              <div class='value'>
                128
              </div>
              <div class='title'>
                Projects
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <h5><strong><i class="fas fa-users"></i>&nbsp;Directory</strong></h5>
          <br /><br />
          <div class="input-group">
            <input class="input-group-field" type="text" name='query'>
            <div class="input-group-button">
              <input type="submit" class="button" value="Find User">
            </div>
          </div>

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

      <div class='cell medium-6 large-3'>
        <div class='card'>
          <h5><strong><i class="fas fa-network-wired"></i>&nbsp;System Information</strong></h5>
        </div>
      </div>
    </div>
  </body>
  <script>
    $(document).foundation();
  </script>
</html>
