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
                @if(Session::has('error'))
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>{{ Lang::get('general.Error') }}</strong> {{ Session::get('error') }}
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
            
            @yield('content')
                    
        </div>
    </body>
    <!-- Javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="{{ url('assets/javascripts/application.js') }}" ></script>
    <script type="text/javascript" src="{{ url('assets/javascripts/dropzone.js') }}" ></script>

</html>