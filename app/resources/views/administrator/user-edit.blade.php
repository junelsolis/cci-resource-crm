<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Administrator | Critical Components</title>
    <link rel=stylesheet href="{{ asset('css/foundation.min.css')}}" />
    <link rel='stylesheet' href="{{ asset('css/navbar.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/default.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/admin/main.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/admin/user-edit.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/foundation.min.js')}}"></script>
  </head>
  @include('navbar')
  <body>
    <div class='grid-x'>
      <div class='cell medium-6'>
        <div id='user-card' class="card" style="width: 90%;">
          <div class='banner align-middle'>
            <div>
              <i class="fas fa-user"></i>
            </div>
            <div class='name'>
              {{ $user->name }}
            </div>
          </div>

          <form method='post' action='/admin/user/edit/{{ $user->id}}'>
            {{ csrf_field() }}
            <fieldset class='fieldset'>
              <legend>
                User Details
              </legend>
              <div class='grid-x grid-padding-x'>
                <div class='cell medium-6'>
                  <label>Username</label>
                  <input type='text' name='username' value='{{ $user->username }}' required />
                </div>
                <div class='cell medium-6'>
                  <label>Full Name</label>
                  <input type='text' name='name' value='{{ $user->name }}' required />
                </div>
              </div>
            </fieldset>


            <fieldset class='fieldset'>
              <legend>
                User Roles
              </legend>

              <input name='roles[]' value='sales' type='checkbox'
                <?php
                  if (in_array('sales',$user->roles->toArray())) { echo 'checked'; }
                ?>
              /><label>Sales</label>

              <input name='roles[]' value='service' type='checkbox'
              <?php
                if (in_array('service',$user->roles->toArray())) { echo 'checked'; }
              ?>
              /><label>Service</label>

              <input name='roles[]' value='executive' type='checkbox'
              <?php
                if (in_array('executive',$user->roles->toArray())) { echo 'checked'; }
              ?>
              /><label>Executive</label>

              <input name='roles[]' value='administrator' type='checkbox'
              <?php
                if (in_array('administrator',$user->roles->toArray())) { echo 'checked'; }
              ?>
              /><label>System Administrator</label>
            </fieldset>


            <fieldset class='fieldset'>
              <legend>
                Password Reset
              </legend>
              <a href='/administrator/user/reset/{{ $user->id }}'><i class="fas fa-sync-alt"></i>&nbsp;Generate New Password</a>
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

            <button class='button button-primary' type='submit'><i class="fas fa-save"></i>&nbsp;Save</button>
          </form>
        </div>
      </div>

      <div class='cell medium-6'>
        <div class="card" style="width: 90%;">
          <h5><strong><i class="fas fa-users"></i>&nbsp;Directory</strong></h5>
          <br /><br />
          <div class="input-group">
            <input class="input-group-field" type="text" name='query'>
            <div class="input-group-button">
              <input type="submit" class="button" value="Find User">
            </div>
          </div>

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
                <td><a href='/admin/user/{{ $user->id}}'><i class="fas fa-edit"></i>&nbsp;Edit</a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
  <script>
    $(document).foundation();
  </script>
</html>
