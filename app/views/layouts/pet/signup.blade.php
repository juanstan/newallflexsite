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
    <link href="/assets/stylesheets/pace-theme-barber-shop.css" rel="stylesheet" />
    
  


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
    <body>
        <div class="container">
            <div class="col-md-8 col-centered float-none" >
                @if($errors->has())
                   @foreach ($errors->all() as $error)
                        <div class="alert alert-warning alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <strong>{{ Lang::get('general.error'); }}!</strong> {{ $error }}
                        </div>
                  @endforeach
                @endif
            </div>
            <div class="row large-top-buffer" >
                <div class="col-md-9 col-centered float-none" >
                    <div class="jumbotron text-center" >
                                {{ HTML::image('images/logo-pet.png', 'a Logo', array('class' => 'signup-logo')) }}
                        <ul class="nav nav-tabs nav-justified">
                            <li class="h2"><a href="/pet/signup/1" data-toggle="pill"><span>{{ Lang::get('general.aboutYou'); }}</span></a></li>
                            <li class="h2"><a href="/pet/signup/2" data-toggle="pill"><span>{{ Lang::get('general.yourPets'); }}</span></a></li>
                            <li class="h2"><a href="/pet/signup/5" data-toggle="pill"><span>{{ Lang::get('general.yourVets'); }}</span></a></li>
                            <li class="h2"><a href="/pet/signup/6" data-toggle="pill"><span>{{ Lang::get('general.yourReadings'); }}</span></a></li>
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
  <script src="/assets/javascripts/dropzone.js"></script>
  <script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>
  <script src="/assets/javascripts/pace.min.js"></script>
  <script src="/assets/javascripts/application.js"></script>
  <script>
    $( document.body ).on( 'click', '.dropdown-menu li', function( event ) {

        var $target = $(this);

        $target.closest( '.btn-group' )
                .find( 'input' ).val( $target.attr( 'data-id' ) );
        $target.closest( '.btn-group' )
                .find( '[data-bind="label"]' ).text( $target.text() )
                .end()
                .children( '.dropdown-toggle' );
        $target.closest('form').submit();
//        .dropdown( 'toggle' )
        return false;

    });
  </script>
</html>