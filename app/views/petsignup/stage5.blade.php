@extends('layouts.pet.signup')

@section('content')
    <div class="row" >
        <div class="col-md-6 col-centered float-none top-buffer" >
            <h3>{{ Lang::get('general.searchVetText') }}</h3>
            {{ HTML::image('images/arrow.png', 'a Logo') }}
            <div class="btn-group btn-group-justified top-buffer vet-search" role="group" aria-label="...">
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-default active">{{ Lang::get('general.location') }}</button>
              </div>
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-default">{{ Lang::get('general.vetPractice') }}</button>
              </div>
            </div>
            <div class="row top-buffer" >
                <div class="col-md-12 col-centered" >
                    <div class="input-group">

                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                        {{ Form::text('search', '', array('class' => ' form-control text-left', 'placeholder' => Lang::get('general.searchByLocation'))) }}

                    </div>
                </div>
            </div>
            @foreach ($vets as $vet)

                {{ Form::open(array('url' => array('/pet/register/vet/add', $vet->id), 'method' => 'post')) }}
            <div class="row top-buffer col-md-12 col-centered" >
                <div class="col-md-3 small-padding" >
                    {{ HTML::image(isset($vet->image_path) ? $vet->image_path : '/images/vet-image.png', $vet->company_name, array('class' => 'img-responsive img-circle', 'width' => '100%')) }}
                </div>
                <div class="col-md-6" >
                    <h4 class="top-none bottom-none">{{ $vet->company_name }}</h4>
                    <small class="top-none">{{ $vet->city }}</small>
                </div>
                <div class="col-md-3 small-padding" >
                        {{ Form::submit('Add', array('class' => 'btn-block btn btn-default btn-md')) }}
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
                    
                     <a href="/pet/register/vet" >{{ Form::button(Lang::get('general.back'), array('class' => 'btn btn-file btn-lg pull-left border-none')) }}</a>

                    <a href="/pet/register/reading" >{{ Form::button(Lang::get('general.next'), array('class' => 'btn btn-default btn-lg pull-right border-none')) }}</a>

                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
@stop