@extends('layouts.vet.signup')

@section('content')
    <div class="row" >
        <div class="col-md-11 col-centered float-none" >
            <div class="col-md-3" >
                <ul class="nav nav-pills how-to-tabs top-buffer">
                    <li class="active"><a href="#windows-instructions" data-toggle="pill"  ><i class="small-right-buffer fa fa-windows"></i> {{ Lang::get('general.Windows') }}</a></li>
                    <li><a href="#mac-instructions" data-toggle="pill" ><i class="small-right-buffer fa fa-apple"></i> {{ Lang::get('general.Mac') }}</a></li>
                </ul>
            </div>
            <div class="col-md-9 text-left" >
                <div class="tab-content ">
                    <div class="tab-pane active fade in" id="windows-instructions">
                        <h2>{{ Lang::get('general.How to upload readings via USB') }}</h2>
                        <ol>
                            <li>{{ Lang::get('general.Connect the reader via the supplied USB cable to your computer') }}</li>
                            <li>{{ Lang::get('general.Open "finder" and look for the "[readername]" drive') }}</li>
                            <li>{{ Lang::get('general.Drag the file to the below area or click to browse to the file manually') }}</li>
                        </ol>
                    </div>
                    <div class="tab-pane fade in" id="mac-instructions">
                        <h2>{{ Lang::get('general.How to upload readings via USB') }}</h2>
                        <ol>
                            <li>{{ Lang::get('general.Connect the reader via the supplied USB cable to your computer') }}</li>
                            <li>{{ Lang::get('general.Open "finder" and look for the "[readername]" drive') }}</li>
                            <li>{{ Lang::get('general.Drag the file to the below area or click to browse to the file manually') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" >
        <div class="col-md-11 col-centered float-none" >
            {{ Form::open(array('files'=> 'true', 'url' => '/vet/dashboard/reading-upload', 'class'=>'dropzone', 'method' => 'post')) }}
            {{ Form::close() }}
        </div>
    </div>
    <div class="row top-buffer" >
        <div class="col-md-12 col-centered" >
            <div class="form-group">
                <div class="col-sm-12">
                    <a href="/vet/dashboard" >{{ Form::button(Lang::get('general.Next'), array('class' => 'btn btn-default btn-lg pull-right border-none')) }}</a>
                </div>
            </div>
        </div>
    </div>
@stop