<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CCI POST</title>
    <link rel=stylesheet href="{{ asset('css/app.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/foundation.min.js')}}"></script>
  </head>
  <body class='login'>
    <div class='login-box'>
      <img src='{{ asset('images/logo.png')}}' style='max-width: 140px;' />
      <!-- <h3>Critical Components CRM</h3> -->
      <br /><br />
      <span class='app-name'>Project Opportunities Sales Tracker</span>
      <br /><br />
      <form method='post' action='/login'>
        {{ csrf_field() }}
        <label>Username</label>
        <input type='text' name='username' required />
        <label>Password</label>
        <input type='password' name='password' required />


        <!-- divs for error messages -->
        <div class='grid-x' style='padding:0;'>
          <div class='cell small-12' style='padding:0'>
            @if (session('error'))
            <div class='message-card-error callout' style='width:100%;margin:auto;margin-bottom:10px;' data-closable>
              <span>{!! session('error') !!}</span>
              <button class="close-button" aria-label="Close alert" type="button" data-close>
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endif
          </div>
        </div>

        <button class='button button-primary expanded' type='submit'><i class="fas fa-sign-in-alt"></i>&nbsp;Login</button>
      </form>


    </div>
  </body>

   <!-- initialize foundation -->
   <script>

      $(document).foundation();


</script>
</html>
