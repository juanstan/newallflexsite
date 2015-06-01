@extends('layouts.user.signup')

@section('content')
    <div class="row" >
        <div class="col-md-12 mobile" >
            <h3>{{ Lang::get('general.Your vets') }}</h3>
        </div>
        <div class="col-md-6 col-centered float-none top-buffer" >
            <h3>{{ Lang::get('general.To find your vet practice, search below') }}</h3>
            {{ HTML::image('images/arrow.png', 'a Logo') }}

            <div class="row top-buffer" >
                <div class="col-md-12 col-centered" >
                    <div role="tabpanel small-top-buffer">


                        <ul class="nav mobile-nav nav-pills">
                            <li class="active "><a href="#vetLocation" aria-controls="vetLocation" role="tab" data-toggle="tab">Location</a></li>
                            <li class="report-toggle"><a href="#vetName" aria-controls="vetName" role="tab" data-toggle="tab">Vet Practice</a></li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane" id="vetName">
                                <div class="input-group top-buffer">
                                            <span class="input-group-addon">
                                                <i class="fa fa-search"></i>
                                            </span>
                                    {{ Form::text('term', null, array('placeholder' => Lang::get('general.Search for vet'), 'id' => 'registerVetName', 'class' => 'form-control text-left', 'autocomplete' => 'off')) }}
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane active" id="vetLocation">
                                <div class="input-group top-buffer">
                                        <span class="input-group-addon">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    {{ Form::text('term', null, array('placeholder' => Lang::get('general.Search in your location'), 'id' => 'registerVetLocation', 'class' => 'form-control text-left', 'autocomplete' => 'off')) }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div id="results" ></div>


        </div>
    </div>
    <div class="row large-top-buffer" >
        <div class="col-md-12 col-centered" >
            <div class="form-group">
                <div class="col-sm-12">
                    
                     <a href="{{ URL::route('user.register.vet') }}" >{{ Form::button(Lang::get('general.Back'), array('class' => 'btn btn-file btn-lg pull-left border-none')) }}</a>

                    <a href="{{ URL::route('user.register.reading') }}" >{{ Form::button(Lang::get('general.Next'), array('class' => 'btn btn-default btn-lg pull-right border-none')) }}</a>

                </div>
            </div>
        </div>
    </div>
    <div class="top-buffer mobile" ></div>
@stop