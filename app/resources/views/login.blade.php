<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Critical Components CRM</title>
    <link rel=stylesheet href="{{ asset('css/foundation.min.css')}}" />
    <link rel='stylesheet' href="{{ asset('css/default.css') }}" />
    <link rel='stylesheet' href='{{ asset('css/login.css')}}' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
  </head>
  <body>
    <div id='main'>
      <img src='{{ asset('images/logo.png')}}' />
      <h3>Critical Components CRM</h3>
      <form method='post' action='/login'>
        {{ csrf_field() }}
        <label>Username</label>
        <input type='text' name='username' required />
        <label>Password</label>
        <input type='password' name='password' required />
        <button class='button button-primary expanded' type='submit'>Login</button>
      </form>
    </div>
  </body>
</html>
