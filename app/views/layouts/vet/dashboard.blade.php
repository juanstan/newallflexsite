<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <!-- Bootstrap -->
      <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
      <link rel="stylesheet" href="{{ url('assets/stylesheets/dropzone.css') }}" />
      <link rel="stylesheet" href="{{ url('assets/stylesheets/application.css') }}" />
      <link rel="stylesheet" href="{{ url('assets/stylesheets/pace.css') }}" />
      <link rel="stylesheet" href="{{ url('vendor/selectize/css/selectize.bootstrap3.css') }}" />
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>

    <![endif]-->

      <link rel="stylesheet" type="text/css" href="http://services.postcodeanywhere.co.uk/css/captureplus-2.30.min.css?key=mz34-mz21-yg64-ug48" />
      <script type="text/javascript" src="http://services.postcodeanywhere.co.uk/js/captureplus-2.30.min.js?key=mz34-mz21-yg64-ug48"></script>
  </head>
    <body>
        <div class="container">
            <div class="col-md-7 col-centered float-none" >
                @if(Session::has('success'))
                    <div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Success!</strong> {{ Session::get('success') }}
                    </div>
                @endif
                @if(Session::has('message'))
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Success!</strong> {{ Session::get('message') }}
                    </div>
                @endif
                @if(Session::has('not-verified'))
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong class="inline-block ">Email not yet verified</strong> please verify

                        <a href="resend-confirmation" ><button style="margin-top: -5px;" class="btn btn-warning btn-sm pull-right border-none" type="button">Resend confirmation email</button></a>
                    </div>
                @endif
                @if($errors->has())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Error!</strong> {{ $error }}
                        </div>
                    @endforeach
                @endif
            </div>
            <nav class="navbar navbar-default" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  
                </div>
                <a class="navbar-brand" href="/vet/dashboard">{{ HTML::image('images/logo-vet.png', 'Logo', array('width' => '60px')) }}</a>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse-1">
                 
                  <ul class="nav navbar-nav navbar-left">
                    <li><a href="/vet/dashboard">Overview</a></li>
                    <li><a href="#upload" id="upload-toggle" data-toggle="collapse" data-target="#file-upload"><i class="fa fa-cloud-upload"></i> Upload</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li>{{ HTML::link('vet/dashboard/help', 'Help') }}</li>
                      <li>{{ HTML::link('vet/dashboard/settings', 'Settings') }}</li>
                      <li>{{ HTML::link('vet/logout','Logout') }}</li>
                  </ul>
                </div><!-- /.navbar-collapse -->
            </nav>

            @yield('content')
        </div>
    </body>
    <!-- Javascript -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{ url('assets/javascripts/dropzone.js') }}" ></script>
        <script type="text/javascript" src="{{ url('vendor/highcharts/highcharts.js') }}" ></script>
        <script type="text/javascript" src="{{ url('assets/javascripts/pace.min.js') }}" ></script>
        <script type="text/javascript" src="{{ url('assets/javascripts/application.js') }}" ></script>
        <script type="text/javascript" src="{{ url('vendor/selectize/js/standalone/selectize.min.js') }}" ></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript">
          function init_map() {
              var myOptions = {
                  zoom: 14,
                  center: new google.maps.LatLng({{ Auth::vet()->get()->latitude }}, {{ Auth::vet()->get()->longitude }}),
                  mapTypeId: google.maps.MapTypeId.ROADMAP
              };
              map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);
              marker = new google.maps.Marker({
                  map: map,
                  position: new google.maps.LatLng({{ Auth::vet()->get()->latitude }}, {{ Auth::vet()->get()->longitude }})
              });
              google.maps.event.addListener(marker, "click", function () {
                  infowindow.open(map, marker);
              });
              infowindow.open(map, marker);
          }
          google.maps.event.addDomListener(window, 'load', init_map);

          var md = new Dropzone(".dropzone", {

          });
          md.on("complete", function (file) {
              if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                  window.setTimeout(function(){window.location.reload()}, 3000);
              }


          });
          var md = new Dropzone(".dropzone", {

          });
          md.on("complete", function (file) {
              if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                  window.setTimeout(function(){window.location.reload()}, 3000);
              }


          });
        </script>


    
</html>