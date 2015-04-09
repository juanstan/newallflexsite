@extends('layouts.pet.signup')

@section('content')
    <div class="col-md-12 mobile" >
        <h3>Your readings</h3>
    </div>
    <div class="row desktop" >
        <div class="col-md-10 col-centered float-none top-buffer" >
            <h3>{{ Lang::get('general.We need to learn your pet&#39;s microchip number') }}</h3>
            <h4>{{ Lang::get('general.Scan your pets with the [device name] then follow one of the below methods') }}</h4>
        </div>
    </div>
    <div class="row" >
        <div class="col-sm-6 text-left">
            <h3 class="blue" >{{ Lang::get('general.Sync via Bluetooth') }}</h3>
            <p>{{ Lang::get('general.Easily pair the reader via Bluetooth on your mobile') }}</p>
            <div class="col-md-12 text-center vcenterwrap" >
                <div class="col-md-6 vcenter">

                    {{ HTML::image('images/phones.png', 'a Logo', array('width' => '100%')) }}
                
                </div>
                <div class="col-md-6 vcenter">

                    {{ HTML::image('images/app-store.svg', 'a Logo', array('width' => '100%', 'class' => 'col-xs-6 col-md-12 small-padding')) }}
                    {{ HTML::image('images/play-store.png', 'a Logo', array('width' => '100%', 'class' => 'col-xs-6 col-md-12 small-padding')) }}
                
                </div>    
            </div>
        </div>
        <div class="col-sm-6 desktop">
            <h3 class="blue" >{{ Lang::get('general.Upload readings via USB') }}</h3>

            {{ Form::open(array('files'=> 'true', 'url' => '/pet/register/reading/reading-upload', 'class'=>'dropzone', 'method' => 'post')) }}
            {{ Form::close() }}

            <div class="row text-center top-buffer" >
                <p>{{ Lang::get('general.Upload instructions') }}</p>
                <div class="col-sm-6 text-right">
                    <p><i class="fa fa-windows"></i> {{ Lang::get('general.Windows') }}</p>
                </div>
                <div class="col-sm-6 text-left">
                    <p><i class="fa fa-apple"></i> {{ Lang::get('general.Mac') }}</p>
                </div>
            </div> 
        </div>
    </div>
    <div class="row top-buffer" >
        <div class="col-md-12 col-centered" >
            <div class="form-group">
                <div class="col-sm-12">
                    
                    <a href="/pet/register/vet" >{{ Form::button(Lang::get('general.Back'), array('class' => 'btn btn-file btn-lg pull-left border-none')) }}</a>
                    <a href="/pet/register/reading/assign" >{{ Form::button(Lang::get('general.Next'), array('class' => 'btn btn-default btn-lg pull-right')) }}</a>

                </div>
            </div>
        </div>
    </div>
    <div class="top-buffer mobile" ></div>
@stop