<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
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
$( document ).ready(function() {
    $( document.body ).on( 'click', '.dropdown-menu li', function( event ) {
        var $target = $(this);

        $target.closest( '.btn-group' )
                .find( 'input[name="pet-id"]' ).val( $target.attr( 'data-id' ) );

        $target.closest( '.btn-group' )
                .find( '[data-bind="label"]' ).text( $target.text() )
                .end()
                .children( '.dropdown-toggle' );
        $target.closest('form').submit();
        return false;
    });


    $(document.body).on('click', '.symptom-pill-add a, a.allconditions', function(e){
        e.preventDefault();
    });


    $('.breed-list').autocomplete({
        source: '/user/register/pet/breeds',
        minLength:3
    });

    $( "#createBreedList" ).autocomplete({
        source: '/user/register/pet/breeds',
        minLength:3
    });

    $( "#vet-search" ).autocomplete({
        source: '/user/dashboard/vet',
        minLength:3
    });


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

</script>
</html>