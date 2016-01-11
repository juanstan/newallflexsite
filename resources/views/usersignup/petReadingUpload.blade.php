@extends('layouts.user.signup')

@section('content')
    <div class="col-md-12 mobile" >
        <h3>{!! Lang::get('general.Your readings') !!}</h3>
    </div>
    <div class="row desktop" >
        <div class="col-md-11 col-centered float-none top-buffer" >
            <h3>{!! Lang::get('general.Finally upload readings from the SureSense reader') !!}</h3>
            <h4>{!! Lang::get('general.Scan your pets with the SureSense reader then follow one of the below methods') !!}</h4>
        </div>
    </div>
    <div class="row" >
        <div class="col-xs-12 col-md-6 text-left">
            <h3 class="blue" >{!! Lang::get('general.Sync via Bluetooth') !!}</h3>
            <p>{!! Lang::get('general.Easily pair the reader via Bluetooth on your mobile') !!}</p>
            <div class="col-md-12 text-center vcenterwrap" >
                <div class="col-md-6 vcenter">
                    {!! HTML::image('images/phones.png', 'a Logo', array('width' => '100%')) !!}
                </div>
                <div class="col-md-6 vcenter">
                    {!! HTML::image('images/app-store.svg', 'a Logo', array('width' => '100%', 'class' => 'col-xs-6 col-md-12 small-padding')) !!}
                    {!! HTML::image('images/play-store.png', 'a Logo', array('width' => '100%', 'class' => 'col-xs-6 col-md-12 small-padding')) !!}
                </div>    
            </div>
        </div>
        <div class="col-sm-6 desktop">
            <h3 class="blue" >{!! Lang::get('general.Upload readings via USB') !!}</h3>
            {!! Form::open(array('files'=> 'true', 'route' => 'user.register.reading.readingUpload', 'class'=>'dropzone', 'id'=>'uploadReading', 'method' => 'post')) !!}
            {!! Form::close() !!}
            <div class="row text-center top-buffer" >
                <p>{!! Lang::get('general.Upload instructions') !!}</p>
                <div class="col-sm-6 text-right">
                    <a href="{!! URL::route('user.register.reading.instructions', 'windows') !!}" >
                        <p><i class="fa fa-windows"></i> {!! Lang::get('general.Windows') !!}</p>
                    </a>
                </div>
                <div class="col-sm-6 text-left">
                    <a href="{!! URL::route('user.register.reading.instructions', 'mac') !!}" >
                        <p><i class="fa fa-apple"></i> {!! Lang::get('general.Mac') !!}</p>
                    </a>
                </div>
            </div> 
        </div>
    </div>
    <div class="row top-buffer" >
        <div class="col-md-12 col-centered" >
            <div class="form-group">
                <div class="col-sm-12">
                    
                    <a href="{!! URL::route('user.register.vet') !!}" >{!! Form::button(Lang::get('general.Back'), array('class' => 'btn btn-file btn-lg pull-left border-none')) !!}</a>
                    <a href="{!! URL::route('user.register.reading.finish') !!}" >
                        {!! Form::button(Lang::get('general.No thanks, skip'), array('class' => 'btn-skip btn btn-default btn-lg pull-right')) !!}
                    </a>
                    <a href="{!! URL::route('user.register.reading.assign') !!}" >{!! Form::button(Lang::get('general.Next'), array('class' => 'hidden btn-next btn btn-default btn-lg pull-right')) !!}</a>

                </div>
            </div>
        </div>
    </div>
    <div class="top-buffer mobile" ></div>
@stop

@section('javascript')
    //Disabling the auto detect mecanishim
    Dropzone.autoDiscover = false;
    var md = new Dropzone("#uploadReading",
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
            && typeof file.xhr!=="undefined"
            && JSON.parse(file.xhr.response).status == 'success'
        ) {
            $('button.btn-skip').hide();
            $('button.btn-next').removeClass('hidden').show();

        } else {
            $(file.previewElement).on('click', function () {
                self.removeAllFiles();
                $('button.btn-skip').show();
                $('button.btn-next').hide();
            })
        }
    });
@stop