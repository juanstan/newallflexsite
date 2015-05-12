@extends('layouts.vet.signup')

@section('content')
    <div class="row" >
        <div class="col-md-12 mobile" >
            <h3>{{ Lang::get('general.Address') }}</h3>
        </div>
        <div class="col-md-8 col-centered float-none" >
            <div class="form-horizontal top-buffer">

                {{ Form::open(array('route' => 'vet.register.address', 'method' => 'post' )) }}

                <div class="form-group">

                        {{ Form::label('zip', Lang::get('general.Zip'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8 text-left">

                        {{ Form::text('zip', Auth::vet()->get()->zip, array('class' => 'form-control text-left', 'autocomplete' => 'off')) }}


                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('address_1', Lang::get('general.Address line 1'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('address_1', Auth::vet()->get()->address_1, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('address_2', Lang::get('general.Address line 2'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('address_2', Auth::vet()->get()->address_2, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('city', Lang::get('general.Town/City'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('city', Auth::vet()->get()->city, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('county', Lang::get('general.county'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('county', Auth::vet()->get()->county, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
        </div>
    </div>
    <div class="row " >
        <div class="col-md-12 col-centered top-buffer" >
            <div class="form-group">
                <div class="col-sm-12">
                    <a href="{{ URL::route('vet.register.about') }}" >
                    {{ Form::button(Lang::get('general.Back'), array('class' => 'btn btn-file btn-lg pull-left border-none')) }}
                    </a>
                    
                    {{ Form::submit(Lang::get('general.Next'), array('class' => 'btn btn-default btn-lg pull-right')) }}

                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
        <div class="top-buffer mobile" ></div>
@stop