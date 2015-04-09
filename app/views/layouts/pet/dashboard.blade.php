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
  </head>
    <body>
        <div class="container">
            <div class="col-md-7 col-centered float-none" >
                @if(Session::has('success'))
                    <div class="alert alert-info alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <strong>{{ Lang::get('general.Success') }}</strong> {{ Session::get('success') }}
                    </div>
                @endif
                @if(Session::has('message'))
                    <div class="alert alert-warning alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <strong>{{ Lang::get('general.Message') }}</strong> {{ Session::get('message') }}
                    </div>
                @endif
                @if(Session::has('not-verified'))
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong class="inline-block ">{{ Lang::get('general.Email not yet verified') }}</strong> {{ Lang::get('general.please verify') }}

                        <a href="resend-confirmation" ><button style="margin-top: -5px;" class="btn btn-warning btn-sm pull-right border-none" type="button">{{ Lang::get('general.Resend confirmation email') }}</button></a>
                    </div>
                @endif
                @if($errors->has())
                   @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <strong>{{ Lang::get('general.Error') }}</strong> {{ $error }}
                        </div>
                  @endforeach
                @endif
            </div>
            <nav class="navbar navbar-default" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header" >
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigationbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>

                </div>
                <div class="navbar-brand">{{ HTML::image('images/logo-pet.png', 'Logo', array('width' => '60px')) }}</div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navigationbar">
                 
                  <ul class="nav desktop mobile navbar-nav navbar-left">
                    <li>{{ HTML::link('pet/dashboard', Lang::get('general.My Pets')) }}</li>
                    <li class="desktop"><a href="#upload" id="upload-toggle" data-toggle="collapse" data-target="#file-upload"><i class="fa fa-cloud-upload"></i> {{ Lang::get('general.Upload') }}</a></li>
                  </ul>
                  <ul class="nav navbar-nav desktop mobile navbar-right">
                    <li>{{ HTML::link('pet/dashboard/help', Lang::get('general.Help')) }}</li>
                    <li>{{ HTML::link('pet/dashboard/vet', Lang::get('general.My Vet')) }}</li>
                    <li>{{ HTML::link('pet/dashboard/settings', Lang::get('general.Settings')) }}</li>
                    <li>{{ HTML::link('pet/logout',Lang::get('general.Logout')) }}</li>
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
    <script>
        $(function(){ // this will be called when the DOM is ready
            $('#vetsearch').keyup(function() {
                $('.vetname').show();
                var val = $(this).val().toLowerCase();
                $('.vetname').hide();
                $('.vetname').each(function() {
                    var text = $(this).text().toLowerCase();
                    if(text.indexOf(val) != -1)
                    {
                        $(this).show();
                    }
                });
            });
        });

    md.on("complete", function (file) {
        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
            window.setTimeout(function(){window.location.reload()}, 3000);
        }

        
    });

    $(document).ready(function() {



    });
    </script>
    
</html>