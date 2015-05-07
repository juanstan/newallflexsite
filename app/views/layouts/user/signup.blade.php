<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
            <div class="col-md-8 col-centered float-none" >
                @if($errors->has())
                   @foreach ($errors->all() as $error)
                        <div class="alert alert-warning alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <strong>Error!</strong> {{ $error }}
                        </div>
                  @endforeach
                @endif
            </div>
            <div class="row large-top-buffer" >
                <div class="col-md-9 col-centered float-none" >
                    <div class="jumbotron text-center" >
                                {{ HTML::image('images/logo-pet.png', 'a Logo', array('class' => 'signup-logo')) }}
                        <ul class="nav nav-tabs nav-justified">
                            <li class="h2">{{ HTML::linkroute('user.register.about', Lang::get('general.About you')) }}</li>
                            <li class="h2">{{ HTML::linkroute('user.register.pet', Lang::get('general.Your pets')) }}</li>
                            <li class="h2">{{ HTML::linkroute('user.register.vet', Lang::get('general.Your vets')) }}</li>
                            <li class="h2">{{ HTML::linkroute('user.register.reading', Lang::get('general.Your readings')) }}</li>
                        </ul>
            @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </body>
    <!-- Javascript -->
  @include('layouts/core/javascript')
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