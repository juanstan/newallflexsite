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