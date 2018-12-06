<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sales | Critical Components</title>
    <link rel=stylesheet href="{{ asset('css/foundation.min.css')}}" />
    <link rel='stylesheet' href="{{ asset('css/navbar.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/default.css') }}" />
    <link rel='stylesheet' href="{{ asset('css/sales/sales-main.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/foundation.min.js')}}"></script>
  </head>
  @include('navbar')
  <body>
    <div id='main' class='grid-x'>
      <div class='cell medium-6 large-4'>
        <div id='upcoming-projects' class='card'>
          <h5><strong><i class="fas fa-clock"></i>&nbsp;Upcoming Projects</strong></h5>
          <br />
          <p>
            <i class="fas fa-eye"></i>&nbsp;<span>January 28, 2018</span>&nbsp;&mdash;&nbsp;Microsoft Corporation<br />
            <i class="fas fa-eye"></i>&nbsp;<span>January 28, 2018</span>&nbsp;&mdash;&nbsp;Microsoft Corporation<br />
            <i class="fas fa-eye"></i>&nbsp;<span>January 28, 2018</span>&nbsp;&mdash;&nbsp;Microsoft Corporation<br />
            <i class="fas fa-eye"></i>&nbsp;<span>January 28, 2018</span>&nbsp;&mdash;&nbsp;Microsoft Corporation<br />
            <i class="fas fa-eye"></i>&nbsp;<span>January 28, 2018</span>&nbsp;&mdash;&nbsp;Microsoft Corporation<br />
          </p>
        </div>
      </div>
      <div class='cell medium-6 large-8'>
        <div class='card'>
          <h5><strong><i class="fas fa-chart-bar"></i>&nbsp;Statistics</strong></h5>
          <p>numbers and charts go here</p>
        </div>
      </div>
      <div class='cell small-12'>
        <div class='card'>
          <h5><strong><i class="fas fa-project-diagram"></i>&nbsp;Active Projects</strong></h5>
        </div>
      </div>
    </div>
  </body>
  <script>
    $(document).foundation();
  </script>
</html>
