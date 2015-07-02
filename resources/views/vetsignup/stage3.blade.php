@extends('layouts.vet.signup')

@section('content')
    <div class="row" >
        <div class="col-md-12 mobile" >
            <h3>{!! Lang::get('general.Readings') !!}</h3>
        </div>
        <div class="col-sm-6 text-left">
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
        <div class="col-md-11 desktop col-centered float-none" >
            <div class="col-md-3" >
                <ul class="nav nav-pills how-to-tabs top-buffer">
                    <li class="active"><a href="#windows-instructions" data-toggle="pill"  ><i class="small-right-buffer fa fa-windows"></i> {!! Lang::get('general.Windows') !!}</a></li>
                    <li><a href="#mac-instructions" data-toggle="pill" ><i class="small-right-buffer fa fa-apple"></i> {!! Lang::get('general.Mac') !!}</a></li>
                </ul>
            </div>
            <div class="col-md-9 text-left" >
                <div class="tab-content ">
                    <div class="tab-pane active fade in" id="windows-instructions">
                        <h2>{!! Lang::get('general.How to upload readings via USB') !!}</h2>
                        <ol>
                            <li>{!! Lang::get('general.Connect the reader via the supplied USB cable to your computer') !!}</li>
                            <li>{!! Lang::get('general.Open "finder" and look for the "[readername]" drive') !!}</li>
                            <li>{!! Lang::get('general.Drag the file to the below area or click to browse to the file manually') !!}</li>
                        </ol>
                    </div>
                    <div class="tab-pane fade in" id="mac-instructions">
                        <h2>{!! Lang::get('general.How to upload readings via USB') !!}</h2>
                        <ol>
                            <li>{!! Lang::get('general.Connect the reader via the supplied USB cable to your computer') !!}</li>
                            <li>{!! Lang::get('general.Open "finder" and look for the "[readername]" drive') !!}</li>
                            <li>{!! Lang::get('general.Drag the file to the below area or click to browse to the file manually') !!}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row desktop" >
        <div class="col-md-11 col-centered float-none" >
            {!! Form::open(array('files'=> 'true', 'route' => 'vet.dashboard.readingUpload', 'class'=>'dropzone', 'method' => 'post')) !!}
            {!! Form::close() !!}
        </div>
    </div>
    <div class="row top-buffer" >
        <div class="col-md-12 col-centered" >
            <div class="form-group">
                <div class="col-sm-12">
                    <a href="{!! URL::route('vet.dashboard') !!}" >{!! Form::button(Lang::get('general.Next'), array('class' => 'btn btn-default btn-lg pull-right border-none')) !!}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="top-buffer mobile" ></div>
@stop