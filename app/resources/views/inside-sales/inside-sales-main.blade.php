<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Inside Sales | Critical Components</title>
    <link rel=stylesheet href="{{ asset('css/foundation.min.css')}}" />
    <link rel='stylesheet' href="{{ asset('css/navbar.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/default.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/inside-sales/inside-sales-main.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/foundation.min.js')}}"></script>
    <script src="{{ asset('js/Chart.min.js')}}"></script>
  </head>
  @include('navbar')
  <body>
    <div id='main' class='grid-x'>
      <div class='cell small-12'>
        <div class='card'>
          upcoming projects
        </div>
      </div>
      <div class='cell large-6'>
        <div class='card'>
          sales statistics
        </div>
      </div>
      <div class='cell large-6'>
        <div class='card'>
          project statistics
        </div>
      </div>
      <div class='cell small-12'>
        <div class='card'>
          ongoing projects
        </div>
      </div>

    </div>
  </body>
  @include('footer')
  <script>
    $(document).foundation();
  </script>

</html>
