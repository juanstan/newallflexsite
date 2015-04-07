@extends('layouts.vet.signup')

@section('content')
    <div class="row" >
        <div class="col-md-8 col-centered float-none" >
            <div class="form-horizontal large-top-buffer">

                {{ Form::open(array('url' => 'vet/register/address', 'method' => 'post' )) }}

                <div class="form-group">

                        {{ Form::label('zip', 'Zip', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8 text-left">

                        {{ Form::text('zip', Auth::vet()->get()->zip, array('class' => 'form-control text-left', 'autocomplete' => 'off')) }}


                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('address_1', 'Address line 1', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('address_1', Auth::vet()->get()->address_1, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('address_2', 'Address line 2', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('address_2', Auth::vet()->get()->address_2, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('city', 'Town/City', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('city', Auth::vet()->get()->city, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('county', 'county', array('class' => 'col-sm-4 control-label')) }}

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
                    <a href="/vet/register/about" >
                    {{ Form::button('Back', array('class' => 'btn btn-file btn-lg pull-left border-none')) }}
                    </a>
                    
                    {{ Form::submit('Next', array('class' => 'btn btn-default btn-lg pull-right')) }}

                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
@stop