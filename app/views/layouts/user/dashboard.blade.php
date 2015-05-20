<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

      <!-- Stylesheets -->
      @include('layouts.core.stylesheets')

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
            @include('layouts.user.navigation')

            @yield('content')
        </div>
    </body>
    <!-- Javascript -->
  @include('layouts/core/javascript')
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script>
        $('.breed-list').autocomplete({
            source: '/user/register/pet/breeds',
            minLength:1,
        });
        $( "#createBreedList" ).autocomplete({
            source: '/user/register/pet/breeds',
            minLength:1,
        });
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

    var md = new Dropzone(".dropzone", {

    });
    md.on("complete", function (file) {
        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
            window.setTimeout(function(){window.location.reload()}, 3000);
        }
        
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