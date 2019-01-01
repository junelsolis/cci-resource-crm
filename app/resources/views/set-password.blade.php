<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Set Password | Critical Components</title>
    <link rel=stylesheet href="{{ asset('css/app.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/foundation.min.js')}}"></script>
  </head>
  <body class='set-password'>
    <div class='form-box'>
      <img src='{{ asset('images/logo.png') }}' style='max-width: 140px;' />
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
      <div style='text-align:left;padding-left:10px;color:#707070'>
        <strong>Password Policy</strong><br />
        <ul style='list-style:square;color:#707070;font-size:12px;'>
          <li>Minimum 10 characters</li>
          <li>Uppercase AND lowercase required</li>
          <li>Must contain at least 1 number</li>
          <li>Must contain at least 1 symbol</li>
        </ul>
      </div>
    </div>
  </body>
  <script>
    $(document).foundation();
  </script>
</html>
