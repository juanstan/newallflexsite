@extends('layouts.vet.dashboard')

@section('content')
    <?php
    $temperaturePref = \Auth::vet()->get()->units;
    ?>
    @foreach ($microchips as $microchip)
        <div class="row col-md-11 float-none top-buffer col-centered desktop" >
            <div class="alert alert-grey alert-dismissible" role="alert">
                <button type="button" class="close small-top-buffer" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="inline-block small-top-buffer color73">{!! Lang::get('general.1 unknown microchip found, would you like to create a new pet?') !!}</h4>
                {!! Form::open(array('route' => array('vet.dashboard.assign', $microchip->id), 'method' => 'post', 'class' => 'pull-right')) !!}
                <div class="btn-group btn-input clearfix pull-right">
                    <button type="button" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown">
                        <span data-bind="label">{!! Lang::get('general.Choose pet') !!}</span> <span class="caret"></span>
                        <input type="text" class="hidden" name="pet-id" value="" />
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        @foreach ($pets as $pet)
                            @if ($pet->microchip_number == null)
                                <li data-id="{!! $pet->id !!}" ><a href="#">
                                        <div class="row choose-pet" >
                                            <div class="col-md-3 small-padding" >
                                                {!! HTML::image(isset($pet->photo_id) ? $pet->photo->location : '/images/pet-image.png', $pet->name, array('class' => 'img-responsive img-circle', 'width' => '100%')) !!}
                                            </div>
                                            <div class="col-md-9 pet-name-dropdown" >
                                                <h4>{!! $pet->name !!}</h4>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                {!! Form::close() !!}
                <a href="#edit{!! $microchip->id !!}" data-toggle="pill" >
                    <button data-toggle="collapse" data-target="#pet-photo{!! $microchip->id !!}" class="btn btn-file btn-lg pull-right" type="button">{!! Lang::get('general.Create') !!}</button>
                </a>
            </div>
        </div>
    @endforeach
    <div class="row col-centered float-none" >
        <div class="col-md-4" >
            @if($vet->readings->count())
            <div class="jumbotron vet-dashboard top-buffer" >
                <div class="col-md-11 col-centered float-none" >
                    <h3>{!! Lang::get('general.My Readings') !!}</h3>
                </div>
                @foreach($vet->readings->slice(0, 1) as $reading)
                    <div class="row" >
                        <div class="col-md-7 col-centered float-none" >
                            <div class="circle top-buffer circle-small-border" style="border-color: {!! getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] !!}">
                                 <div class="circle-inner">
                                     <div class="score-text small-text" style="color: {!! getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] !!}" >
                                         {!! getTemperatureColor($reading->temperature, $temperaturePref)['temp'] !!}<span>&#176;</span>
                                      </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-12 col-centered float-none top-buffer" >
                            <div class="col-md-3 small-top-buffer" >
                            {!! HTML::image('images/pet-image.png', '', array('width' => '100%')) !!}
                            </div>
                            <div class="col-md-9 left-none" >
                                <h3 class="small-top-buffer bottom-none">{!! $reading->microchip_id !!}</h3>
                                <p class="blue" >@if(date("d/m/y",strtotime($reading->created_at)) == date("d/m/y"))
                                        {!! Lang::get('general.today at') !!} {!! date("h.ia",strtotime($reading->created_at)) !!}
                                    @else
                                        {!! date("d/m/y",strtotime($reading->created_at)) !!} {!! Lang::get('general.at') !!} {!! date("h.ia",strtotime($reading->created_at)) !!}
                                    @endif</p>
                            </div>

                        </div>
                    </div>
                @endforeach
                <div class="row" >
                    <div class="col-md-11 col-centered float-none" >
                        <h3>{!! Lang::get('general.Past Readings') !!}</h3>
                    </div>
                </div>
                <div class="slider-content past-slider" >
                    <?php $counter = 0; ?>
                    @foreach($vet->readings as $reading)
                        <?php if ($counter++ == 1) continue; ?>
                        <div class="row" >
                            <div class="col-md-12 " >
                                <div class="col-md-3 small-top-buffer" >
                                {!! HTML::image('images/pet-image.png', '', array('width' => '100%')) !!}
                                </div>
                                <div class="col-md-6 left-none ellipsis" >
                                    <h4 class="small-top-buffer bottom-none">{!! $reading->microchip_id !!}</h4>
                                    <p class="blue" >
                                        @if(date("d/m/y",strtotime($reading->created_at)) == date("d/m/y"))
                                            {!! Lang::get('general.today at') !!} {!! date("h.ia",strtotime($reading->created_at)) !!}
                                        @else
                                            {!! date("d/m/y",strtotime($reading->created_at)) !!} {!! Lang::get('general.at') !!} {!! date("h.ia",strtotime($reading->created_at)) !!}
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-3 small-top-buffer" >
                                    <div class="circle circle-small-border" style="border-color: {!! getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] !!}">
                                        <div class="circle-inner">
                                            <div class="small-score-text prev-reading" style="color: {!! getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] !!}">
                                                {!! getTemperatureColor($reading->temperature, $temperaturePref)['temp'] !!}<span>&#176;</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row small-top-buffer" >
                            <div class="col-md-10 border-bottom col-centered float-none" ></div>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
                <div class="jumbotron top-buffer" >
                    <h3>{!! Lang::get('general.There are no pet readings associated with your account') !!}</h3>
                    <h4>{!! Lang::get('general.Click the "upload" button above to get started') !!}</h4>
                </div>
            @endif
        </div>
        <div class="col-md-8" >
            @if($pets->count())
            <div class="jumbotron vet-dashboard top-buffer" >
                <div class="row" >
                    <div class="col-md-5" >
                        <h3>{!! Lang::get('general.Customer activity') !!}</h3>
                    </div>
                    <div class="col-md-7 col-xs-12" >
                        <ul class="nav nav-pills mobile desktop top-buffer text-right">
                            <li class="active"><a href="#recent" data-toggle="pill" data-target="" >{!! Lang::get('general.Recent') !!}</a></li>
                            <li class="" ><a href="#pets" data-toggle="pill" data-target="">{!! Lang::get('general.Pets') !!}</a></li>
                            <li class="" ><a href="#recent" data-toggle="pill" data-target=""><i class="fa fa-search"></i> {!! Lang::get('general.Search') !!}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content ">
                    <div class="tab-pane active fade in" id="recent">
                        <div class="slider-content recent-slider top-buffer" >
                            @foreach($pets as $pet)
                                @if($pet->pivot->approved == 1)
                                    @foreach ($pet->readings as $reading)
                                    <div class="row small-top-buffer" >
                                        <div class="col-md-12 " >
                                            <div class="col-md-2 col-xs-4" >
                                                {!! HTML::image(isset($pet->image_path) ? $pet->image_path : '/images/pet-image.png', $pet->name, array('class' => 'img-responsive img-circle', 'width' => '80%')) !!}
                                            </div>
                                            <div class="col-md-5 left-none" >
                                                <h3 class="small-top-buffer bottom-none">{!! $pet->name !!}</h3>
                                                <p class="blue" >
                                                    @if(date("d/m/y",strtotime($reading->created_at)) == date("d/m/y"))
                                                        {!! Lang::get('general.today at') !!} {!! date("h.ia",strtotime($reading->created_at)) !!}
                                                    @else
                                                        {!! date("d/m/y",strtotime($reading->created_at)) !!} {!! Lang::get('general.at') !!} {!! date("h.ia",strtotime($reading->created_at)) !!}
                                                    @endif
                                                </p>
                                                <p>
                                                    {!! Lang::get('general.Read') !!}
                                                    @if($reading->created_at == new DateTime())
                                                        {!! Lang::get('general.today at') !!} {!! date("h.ia",strtotime($reading->created_at)) !!}
                                                    @else
                                                        {!! date("d/m/y",strtotime($reading->created_at)) !!} {!! Lang::get('general.at') !!} {!! date("h.ia",strtotime($reading->created_at)) !!}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-md-2 col-xs-4 vcenter" >
                                                <div class="circle circle-small-border" style="border-color: {!! getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] !!}">
                                                    <div class="circle-inner">
                                                        <div class="small-score-text prev-reading" style="color: {!! getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] !!}">
                                                            {!! getTemperatureColor($reading->temperature, $temperaturePref)['temp'] !!}<span>&#176;</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 vcenter" >
                                                <h4 class="top-buffer">+1.4<span>&#176;</span> <span><i class="fa fa-chevron-right"></i></span></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row small-top-buffer" >
                                        <div class="col-md-11 border-bottom col-centered float-none" ></div>
                                    </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="customer">
                        <div class="col-md-12" >
                        </div>    
                    </div>
                    <div  class="tab-pane fade in" id="pets">
                        <div class="row" >
                        <div class="float-none top-buffer col-md-12 col-centered">
                            <div class="slider-content pets-slider">
                                <ul>
                                <?php
                                    $petsByName = array();
                                ?>
                                @foreach($pets as $pet)
                                    @if($pet->pivot->approved == 1)
                                        <?php
                                        $petsByName[strtolower($pet->name[0])][]=$pet;
                                        ?>
                                    @endif
                                @endforeach
                                    <?php
                                        ksort($petsByName);
                                    ?>
                                @foreach($petsByName as $letter => $petsByLetter)
                                    <li id="{!! $letter !!}"><a name="{!! $letter !!}" class="title">{!! strtoupper($letter) !!}</a>
                                        <ul>
                                            @foreach($petsByLetter as $pet)
                                                <li><a href="{!! URL::route('vet.dashboard.pet', $pet->id) !!}">{!! $pet->name !!}<span class="pull-right" >{!! ($pet->breed) ? $pet->breed->name : $pet->breed_wildcard !!} <i class="small-left-buffer fa fa-chevron-right"></i></span></a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                                </ul>
                            </div>
                        </div>  
                    </div>
                </div>
                </div>
            </div>
            @else
            <div class="jumbotron top-buffer" >
            <h3>{!! Lang::get('general.There is no customer data associated with your account') !!}</h3>
            <h4>{!! Lang::get('general.Click the "settings" button above to invite your customers') !!}</h4>
            </div>
            @endif
        </div>
    </div>
@stop