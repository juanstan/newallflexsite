@extends('layouts.pet.signup')

@section('content')
    <div class="row" >
        <div class="col-md-10 col-centered float-none top-buffer" >
            <h3>We need to learn your pet's microchip number...</h3>
            <h4>Scan your pets with the [device name] then follow one of the below methods</h4>
        </div>
    </div>
    <div class="row" >
        <div class="col-sm-6 text-left">
            <h3 class="blue" >Sync via Bluetooth</h3>
            <p>Easily pair the reader via Bluetooth on<br> your mobile</p>
            <div class="col-md-10 text-center vcenterwrap" >
                <div class="col-sm-6 vcenter">

                    {{ HTML::image('images/phones.png', 'a Logo', array('width' => '100%')) }}
                
                </div>
                <div class="col-sm-6 vcenter">   

                    {{ HTML::image('images/app-store.svg', 'a Logo', array('width' => '128px')) }}
                    {{ HTML::image('images/play-store.png', 'a Logo') }} 
                
                </div>    
            </div>
        </div>
        <div class="col-sm-6">
            <h3 class="blue" >Upload readings via USB</h3>

            {{ Form::open(array('files'=> 'true', 'url' => '/pet/register/reading/reading-upload', 'class'=>'dropzone', 'method' => 'post')) }}
            {{ Form::close() }}

            {{ Form::open(array('files'=> 'true', 'url' => '/pet/register/reading/reading-upload', 'method' => 'post')) }}

            <div class="row text-center top-buffer" >
                <p>Upload instructions</p> 
                <div class="col-sm-6 text-right">
                    <p><i class="fa fa-windows"></i> Windows</p>
                </div>
                <div class="col-sm-6 text-left">
                    <p><i class="fa fa-apple"></i> Mac</p>
                </div>
            </div> 
        </div>
    </div>
    <div class="row top-buffer" >
        <div class="col-md-12 col-centered" >
            <div class="form-group">
                <div class="col-sm-12">
                    
                    <a href="/pet/register/vet" >{{ Form::button('Back', array('class' => 'btn btn-file btn-lg pull-left border-none')) }}</a>
                    <a href="/pet/register/reading/assign" >{{ Form::button('Next', array('class' => 'btn btn-default btn-lg pull-right')) }}</a>

                </div>
            </div>
        </div>
    </div>
@stop