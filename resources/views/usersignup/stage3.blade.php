@extends('layouts.user.signup')

@section('content')
    <div class="row" >
        <div class="col-md-12 mobile" >
            <h3>Your pets</h3>
        </div>
        <div class="col-md-6 col-centered float-none hidden-desktop" >
            <div class="form-horizontal top-buffer">
                    @forelse ($pets as $pet)
                        <div class="row" >
                            <div class="col-xs-4 top-buffer" >
                                {!! HTML::image(isset($pet->image_path) ? $pet->image_path : '/images/pet-image.png', $pet->name, array('class' => 'img-responsive img-circle', 'width' => '100%')) !!}
                            </div>
                            <div class="col-xs-8 top-buffer" >
                                <h3 class="bottom-none text-left">{!! $pet->name !!}</h3>
                                <h4 class="top-none text-left">{!! ($pet->breed) ? $pet->breed->name : $pet->breed_wildcard !!}</h4>
                            </div>
                        </div>
                    @empty
                        <div class="row" >
                            <div class="col-md-12 top-buffer text-center" >
                                <h4>{!! Lang::get('general.Click the button below to add a pet') !!}</h4>
                            </div>
                        </div>
                    @endforelse
                    <div class="col-md-12 col-centered top-buffer" >
                        @if($pets->isEmpty())
                        <a href="{!! URL::route('user.register.pet.create') !!}" >
                            {!! Form::button(Lang::get('general.+ Add a pet'), array('class' => 'btn btn-default btn-lg pull-left border-none btn-block')) !!}
                        </a>
                        @else
                        <a href="{!! URL::route('user.register.pet.create') !!}" >
                            {!! Form::button(Lang::get('general.+ Add another pet'), array('class' => 'btn btn-default btn-lg pull-left border-none btn-block')) !!}
                        </a>
                        @endif
                    </div>
            </div>
        </div>
    </div>
    <div class="row top-buffer" >
        <div class="col-md-12 col-centered" >
            <div class="form-group" >
                    <div class="col-sm-12">
                        
                        <a href="{!! URL::route('user.register.about') !!}" >{!! Form::button(Lang::get('general.Back'), array('class' => 'btn btn-file btn-lg pull-left border-none')) !!}</a>
                        
                        @if($pets->isEmpty())
                            <a href="{!! URL::route('user.register.vet') !!}" >{!! Form::button(Lang::get('general.Skip'), array('class' => 'btn btn-file border-none btn-lg pull-right')) !!}</a>
                        @else
                            <a href="{!! URL::route('user.register.vet') !!}" >{!! Form::button(Lang::get('general.Next'), array('class' => 'btn btn-default border-none btn-lg pull-right')) !!}</a>
                        @endif

                    </div>
                </div>
        </div>
    </div>
    <div class="top-buffer mobile" ></div>
@stop