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

            @include('layouts.core.notifications')

            <div class="row large-top-buffer" >
                <div class="col-md-9 col-centered float-none" >
                    <div class="jumbotron text-center" >
                                {!! HTML::image('images/suresenselogo.png', 'a Logo', array('class' => 'signup-logo')) !!}
                        <ul id="menu" class="nav nav-tabs nav-justified">
                            <li class="h2">{!! HTML::linkroute('user.register.about', Lang::get('general.About you')) !!}</li>
                            <li class="h2">{!! HTML::linkroute('user.register.pet', Lang::get('general.Your pets')) !!}</li>
                            <li class="h2">{!! HTML::linkroute('user.register.vet', Lang::get('general.Your vets')) !!}</li>
                            <li class="h2">{!! HTML::linkroute('user.register.reading', Lang::get('general.Your readings')) !!}</li>
                        </ul>
            @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </body>
    <!-- Javascript -->
  @include('layouts/core/javascript')
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

  <script>

      //Disabling the auto detect mecanishim
      Dropzone.autoDiscover = false;
      var md = new Dropzone("#uploadReading");
      md.on("complete", function (file) {
          if (this.getAcceptedFiles().length > 0) {
            $('button.btn-skip').hide();
            $('button.btn-next').removeClass('hidden');
          }
      });

      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('.image-placeholder')
                          .attr('src', e.target.result)
                          .width(100);
              };
              reader.readAsDataURL(input.files[0]);
          }
      }

      $( "#breedList" ).autocomplete({
          source: '/user/register/pet/breeds',
          minLength:1,
      });

      $(function() {
          var url = window.location.pathname;
          var page = url.substr(url.lastIndexOf('/') + 1);
          target = $('#menu a[href*="' + page + '"]');
          $(target).parent('li').addClass('active');
      });


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