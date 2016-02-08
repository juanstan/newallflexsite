@extends('layouts.user.signup')

@section('content')
    <div class="row" >
        <div class="col-md-12 mobile" >
            <h3>{!! Lang::get('general.Your vets') !!}</h3>
        </div>
        <div class="col-md-12 col-centered float-none" >
            <div class="form-horizontal top-buffer">
                <div class="row float-none top-buffer" >
                    <div class="col-md-5 desktop right-none left-none" >
                        {!! HTML::image('images/vetimageWeb.png', 'Springer', array('class' => '', 'width' => '68%')) !!}
                    </div>
                    <div class="col-md-7" >
                        <div class="row">
                            <div class="col-md-12 list-vets">
                                <ul class="nav nav-pills nav-stacked">
                                    @foreach($vets as $vet)
                                        <li>{{$vet->contact_name}} ({{$vet->company_name}})</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <h2 class="top-none text-left text-center-xs">{!! Lang::get('general.Connect with your vet') !!}</h2>
                        <div class="row" >
                            <div class="col-md-12 text-left" >
                                <h4><i class="orange right-buffer fa fa-share-alt"></i> {!! Lang::get('general.Easily share your readings with your vet') !!}</h4>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-12 text-left" >
                                <h4><i class="fa red right-buffer fa-file-text"></i> {!! Lang::get('general.Store important vet details for emergencies') !!}</h4>
                            </div>
                        </div>
                        <div class="row top-buffer" >
                            <div class="col-md-6" >
                                <a href="{!! URL::route('user.register.vet.add') !!}" >{!! HTML::decode(Form::button(Lang::get('general.<i class="fa fa-search"></i> Find my vet'), array('class' => 'btn border-none btn-default btn-lg pull-left btn-block'))) !!}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row top-buffer" >
        <div class="col-md-12 col-centered" >
            <div class="form-group">
                <div class="col-sm-12">
                    <a href="{!! URL::route('user.register.pet') !!}" >
                        {!! Form::button(Lang::get('general.Back'), array('class' => 'btn btn-file btn-lg pull-left border-none')) !!}
                    </a>
                    <a href="{!! URL::route('user.register.reading') !!}" >
                        {!! Form::button(Lang::get('general.No thanks, skip'), array('class' => 'btn btn-default btn-lg border-none pull-right')) !!}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="top-buffer mobile" ></div>
@stop