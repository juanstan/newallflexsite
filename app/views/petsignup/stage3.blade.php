@extends('layouts.pet.signup')

@section('content')
    <div class="row" >
        <div class="col-md-6 col-centered float-none" >
            <div class="form-horizontal top-buffer">
                    @forelse ($pets as $value) 
                        <div class="row" >
                            <div class="col-md-4 top-buffer" >
                                {{ HTML::image(isset($value->image_path) ? $value->image_path : '/images/pet-image.png', $value->name, array('class' => 'img-responsive img-circle', 'width' => '100%')) }}
                            </div>
                            <div class="col-md-8 top-buffer" >
                                <h3 class="bottom-none text-left">{{ $value->name }}</h3>
                                <h4 class="top-none text-left">{{ $value->breed }}</h4>
                            </div>
                        </div>
                    @empty
                        <div class="row" >
                            <div class="col-md-12 top-buffer text-center" >
                                <h4>Click the button below to add a pet.</h4>
                            </div>
                        </div>
                    @endforelse
                    <div class="col-md-12 col-centered top-buffer" >
                        @if($pets->isEmpty())
                        <a href="/pet/register/pet/create" >
                            {{ Form::button('+ Add a pet', array('class' => 'btn btn-default btn-lg pull-left border-none btn-block')) }}
                        </a>
                        @else
                        <a href="/pet/register/pet/create" >
                            {{ Form::button('+ Add another pet', array('class' => 'btn btn-default btn-lg pull-left border-none btn-block')) }}
                        </a>
                        @endif
                    </div>
            </div>
        </div>
    </div>
    <div class="row top-buffer" >
        <div class="col-md-12 col-centered" >
            <div class="form-group">
                    <div class="col-sm-12">
                        
                        <a href="/pet/register/about" >{{ Form::button('Back', array('class' => 'btn btn-file btn-lg pull-left border-none')) }}</a>
                        
                        @if($pets->isEmpty())
                            <a href="/pet/register/vet" >{{ Form::button('Skip', array('class' => 'btn btn-file border-none btn-lg pull-right')) }}</a>
                        @else
                            <a href="/pet/register/vet" >{{ Form::button('Next', array('class' => 'btn btn-default border-none btn-lg pull-right')) }}</a>
                        @endif
                        
                        

                        {{ Form::close() }}

                    </div>
                </div>
        </div>
    </div>
@stop