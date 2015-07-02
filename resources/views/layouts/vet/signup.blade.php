<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

      <!-- Stylesheets -->
      @include('layouts/core/stylesheets')

      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
      <link rel="stylesheet" type="text/css" href="http://services.postcodeanywhere.co.uk/css/captureplus-2.30.min.css?key=mz34-mz21-yg64-ug48" />
      <script type="text/javascript" src="http://services.postcodeanywhere.co.uk/js/captureplus-2.30.min.js?key=mz34-mz21-yg64-ug48"></script>
  </head>
    <body>
        <div class="container">

            @include('layouts.core.notifications')

            <div class="row large-top-buffer" >
                <div class="col-md-9 col-centered float-none" >
                    <div class="jumbotron text-center" >
                                {!! HTML::image('images/logo-vet.png', 'a Logo', array('class' => 'signup-logo')) !!}
                        <ul id="menu" class="nav nav-tabs nav-justified">
                            <li class="h2"><a href="{!! URL::route('vet.register.about') !!}" data-toggle="pill"><span>{!! Lang::get('general.Your practice') !!}</span></a></li>
                            <li class="h2"><a href="{!! URL::route('vet.register.address') !!}" data-toggle="pill"><span>{!! Lang::get('general.Address') !!}</span></a></li>
                            <li class="h2"><a href="{!! URL::route('vet.register.reading') !!}" data-toggle="pill"><span>{!! Lang::get('general.First upload') !!}</span></a></li>
                        </ul>
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </body>
  <script>
      $(function() {
          var url = window.location.pathname;
          var page = url.substr(url.lastIndexOf('/') + 1);
          target = $('#menu a[href*="' + page + '"]');
          $(target).parent('li').addClass('active');
      });
  </script>
    <!-- Javascript -->
  @include('layouts/core/javascript')

</html>