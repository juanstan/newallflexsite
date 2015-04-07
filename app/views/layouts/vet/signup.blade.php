<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="/assets/stylesheets/dropzone.css" rel="stylesheet">
    <link href="/assets/stylesheets/application.css" rel="stylesheet">


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
            <div class="row large-top-buffer" >
                <div class="col-md-9 col-centered float-none" >
                    <div class="jumbotron text-center" >
                                {{ HTML::image('images/logo-vet.png', 'a Logo', array('class' => 'signup-logo')) }}
                        <ul class="nav nav-tabs nav-justified">
                            <li class="h2"><a href="/vet/signup/1" data-toggle="pill"><span>{{ Lang::get('general.Your practice') }}</span></a></li>
                            <li class="h2"><a href="/vet/signup/2" data-toggle="pill"><span>{{ Lang::get('general.Address') }}</span></a></li>
                            <li class="h2"><a href="/vet/signup/5" data-toggle="pill"><span>{{ Lang::get('general.First upload') }}</span></a></li>
                        </ul>
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </body>
    <!-- Javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="/assets/javascripts/application.js"></script>
    <script src="/assets/javascripts/dropzone.js"></script>
</html>