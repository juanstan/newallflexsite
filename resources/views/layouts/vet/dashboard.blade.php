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

    <![endif]-->

      <link rel="stylesheet" type="text/css" href="http://services.postcodeanywhere.co.uk/css/captureplus-2.30.min.css?key=mz34-mz21-yg64-ug48" />
      <script type="text/javascript" src="http://services.postcodeanywhere.co.uk/js/captureplus-2.30.min.js?key=mz34-mz21-yg64-ug48"></script>
  </head>
    <body>
        <div class="container">

            @include('layouts.core.notifications')
            @include('layouts.vet.navigation')

            @yield('content')
        </div>
    </body>

<!-- Javascript -->
@include('layouts/core/javascript')

<script type="text/javascript">

    $( document ).ready(function() {
        $( document.body ).on( 'click', '.dropdown-menu li', function( event ) {
            var $target = $(this);
            $target.closest( '.btn-group' )
                    .find( 'input' ).val( $target.attr( 'data-id' ) );
            $target.closest( '.btn-group' )
                    .find( '[data-bind="label"]' ).text( $target.text() )
                    .end()
                    .children( '.dropdown-toggle' );
            $target.closest('form').submit();
            return false;
        });
    });


    function init_map() {
        var myOptions = {
            zoom: 14,
            center: new google.maps.LatLng({!! Auth::vet()->get()->latitude !!}, {!! Auth::vet()->get()->longitude !!}),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);
        marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng({!! Auth::vet()->get()->latitude !!}, {!! Auth::vet()->get()->longitude !!})
        });
        google.maps.event.addListener(marker, "click", function () {
            infowindow.open(map, marker);
        });
        infowindow.open(map, marker);
    }
    google.maps.event.addDomListener(window, 'load', init_map);

    /* var md = new Dropzone(".dropzone", {

    });
    md.on("complete", function (file) {
      if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
          window.setTimeout(function(){window.location.reload()}, 3000);
      }


    });*/

    //Disabling the auto detect mecanishim
    Dropzone.autoDiscover = false;

    if (document.querySelector('.dropzone') !== null) {
          var md = new Dropzone(".dropzone",
          {
              maxFiles: 1,
              maxThumbnailFilesize: 1,
              success: function (file, response) {
                  if (response.status == 'error') { // succeeded
                      // below is from the source code too
                      var node, _i, _len, _ref, _results;
                      var message = response.message // modify it to your error message
                      file.previewElement.classList.add("dz-error");
                      _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                      _results = [];
                      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                          node = _ref[_i];
                          _results.push(node.textContent = message);
                      }
                      return _results;
                  }
              }
          });

          md.on("maxfilesexceeded", function (file) {
              this.removeAllFiles();
              this.addFile(file);
          });

          md.on("complete", function (file) {
              var self = this;
              if (
                      self.getAcceptedFiles().length > 0
                      && typeof file.xhr !== "undefined"
                      && JSON.parse(file.xhr.response).status == 'success'
              ) {
                  window.location.reload();
              } else {
                  $(file.previewElement).on('click', function () {
                      self.removeAllFiles();
                      $('button.btn-skip').show();
                      $('button.btn-next').hide();
                  })
              }
          });
    }


    </script>
    
</html>