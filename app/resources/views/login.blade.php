<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CCI Tracker</title>
    <link rel=stylesheet href="{{ asset('css/app.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src='{{ asset('js/foundation.min.js')}}'></script>
  </head>
  <body class='login'>
    <div class='login-box'>
      <img src='{{ asset('images/logo.png')}}' />
      <!-- <h3>Critical Components CRM</h3> -->
      <br /><br />
      <form method='post' action='/login'>
        {{ csrf_field() }}
        <label>Username</label>
        <input type='text' name='username' required />
        <label>Password</label>
        <input type='password' name='password' required />

        @if (session('error'))
        <div data-closable class="callout alert-callout-subtle warning radius">
          <strong>Invalid credentials</strong><br />Please try again.
          <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
            <span aria-hidden="true">⊗</span>
          </button>
        </div>
        @endif

        <button class='button button-primary expanded' type='submit'><i class="fas fa-sign-in-alt"></i>&nbsp;Login</button>
      </form>
    </div>
  </body>
</html>
