@extends('layouts.user.signup')

@section('content')
    <div class="row" >
        <div class="col-md-12 mobile" >
            <h3>Your vets</h3>
        </div>
        <div class="col-md-6 col-centered float-none top-buffer" >
            <h3>{{ Lang::get('general.To find your vet practice, search below') }}</h3>
            {{ HTML::image('images/arrow.png', 'a Logo') }}
            <div class="btn-group btn-group-justified top-buffer vet-search" role="group" aria-label="...">
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-default active">{{ Lang::get('general.Location') }}</button>
              </div>
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-default">{{ Lang::get('general.Vet Practice') }}</button>
              </div>
            </div>
            <div class="row top-buffer" >
                <div class="col-md-12 col-centered" >
                    <div class="input-group">

                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                        {{ Form::text('search', '', array('class' => ' form-control text-left', 'placeholder' => Lang::get('general.Search by location'))) }}

                    </div>
                </div>
            </div>
            @foreach ($vets as $vet)

                {{ Form::open(array('url' => array('/user/register/vet/add', $vet->id), 'method' => 'post')) }}
            <div class="row top-buffer col-md-12 col-centered" >
                <div class="col-xs-3 small-padding" >
                    {{ HTML::image(isset($vet->image_path) ? $vet->image_path : '/images/vet-image.png', $vet->company_name, array('class' => 'img-responsive img-circle', 'width' => '100%')) }}
                </div>
                <div class="col-xs-6" >
                    <h4 class="top-none bottom-none">{{ $vet->company_name }}</h4>
                    <small class="top-none">{{ $vet->city }}</small>
                </div>
                <div class="col-xs-3 small-padding" >
                        {{ Form::submit(Lang::get('general.Add'), array('class' => 'btn-block btn btn-default btn-md')) }}
                </div>
            </div>
                {{ Form::close() }}

            @endforeach
        </div>
    </div>
    <div class="row large-top-buffer" >
        <div class="col-md-12 col-centered" >
            <div class="form-group">
                <div class="col-sm-12">
                    
                     <a href="/user/register/vet" >{{ Form::button(Lang::get('general.Back'), array('class' => 'btn btn-file btn-lg pull-left border-none')) }}</a>

                    <a href="/user/register/reading" >{{ Form::button(Lang::get('general.Next'), array('class' => 'btn btn-default btn-lg pull-right border-none')) }}</a>

                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
    <div class="top-buffer mobile" ></div>
@stop