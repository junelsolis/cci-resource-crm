<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Set Password | Critical Components</title>
    <link rel=stylesheet href="{{ asset('css/foundation.min.css')}}" />
    <link rel='stylesheet' href="{{ asset('css/navbar.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/default.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/set-password.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/foundation.min.js')}}"></script>
  </head>
  <body>
    <div id='main'>
      <img src='{{ asset('images/logo.png') }}' />
      <br /><br />
      <div id='welcome'>
        Welcome, <strong>{{ $name }}</strong><br />
        Please change your password.
      </div>

      <br />
      <form method='post' action='/dashboard/set-password'>
        {{ csrf_field() }}
        <label>Password</label>
        <input type='password' name='password' required />
        <label>Confirm Password</label>
        <input type='password' name='confirmPassword' required />
        <button class='button button-primary expanded' type='submit'><i class="fas fa-sync-alt"></i>&nbsp;Change Password</button>

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
      </form>
      <br /><br />
      <div style='text-align:left;padding-left:40px;'>
        <strong>Password Policy</strong><br />
        &dash; Minimum 10 characters<br />
        &dash; Uppercase AND lowercase required<br />
        &dash; Must contain at least 1 number<br />
        &dash; Must contain at least 1 symbol
      </div>
    </div>
  </body>
  <script>
    $(document).foundation();
  </script>
</html>
