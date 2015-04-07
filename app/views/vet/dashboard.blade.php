@extends('layouts.vet.dashboard')

@section('content')
    <?php
    $temperaturePref = \Auth::vet()->get()->units;
    ?>
    <div class="row col-md-11 float-none col-centered collapse-group" >
        <div class="collapse" id="file-upload">

            {{ Form::open(array('files'=> 'true', 'url' => '/vet/dashboard/reading-upload', 'class'=>'dropzone', 'method' => 'post')) }}
            {{ Form::close() }}

        </div>
    </div>
    <div class="row col-md-12 col-centered float-none" >
        <div class="col-md-4" >
            @if($user->readings->count())
            <div class="jumbotron vet-dashboard top-buffer" >
                <div class="row" >
                    <div class="col-md-11 col-centered float-none" >
                        <h3>{{ Lang::get('general.My readings') }}</h3>
                    </div>
                </div>
                @foreach($user->readings->slice(0, 1) as $reading)
                    <div class="row" >
                        <div class="col-md-7 col-centered float-none" >
                            <div class="circle top-buffer circle-small-border" style="border-color: {{ getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] }}">
                                 <div class="circle-inner">
                                     <div class="score-text small-text" style="color: {{ getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] }}" >
                                         {{ getTemperatureColor($reading->temperature, $temperaturePref)['temp'] }}<span>&#176;</span>
                                      </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-12 col-centered float-none top-buffer" >
                            <div class="col-md-3 small-top-buffer" >
                            {{ HTML::image('images/pet-image.png', 'Logo', array('width' => '100%')) }}
                            </div>
                            <div class="col-md-9 left-none" >
                                <h3 class="small-top-buffer bottom-none">{{ $reading->microchip_id }}</h3>
                                <p class="blue" >@if(date("d/m/y",strtotime($reading->created_at)) == date("d/m/y"))
                                        {{ Lang::get('general.today at') }} {{ date("h.ia",strtotime($reading->created_at)) }}
                                    @else
                                        {{ date("d/m/y",strtotime($reading->created_at)) }} {{ Lang::get('general.at') }} {{ date("h.ia",strtotime($reading->created_at)) }}
                                    @endif</p>
                            </div>

                        </div>
                    </div>
                @endforeach
                <div class="row" >
                    <div class="col-md-11 col-centered float-none" >
                        <h3>{{ Lang::get('general.Past Readings') }}</h3>
                    </div>
                </div>
                <div class="slider-content past-slider" >
                    <?php $counter = 0; ?>
                    @foreach($user->readings as $reading)
                        <?php if ($counter++ == 1) continue; ?>
                        <div class="row" >
                            <div class="col-md-12 " >
                                <div class="col-md-3 small-top-buffer" >
                                {{ HTML::image('images/pet-image.png', 'Logo', array('width' => '100%')) }}
                                </div>
                                <div class="col-md-6 left-none ellipsis" >
                                    <h4 class="small-top-buffer bottom-none">{{ $reading->microchip_id }}</h4>
                                    <p class="blue" >@if(date("d/m/y",strtotime($reading->created_at)) == date("d/m/y"))
                                            {{ Lang::get('general.today at') }} {{ date("h.ia",strtotime($reading->created_at)) }}
                                        @else
                                            {{ date("d/m/y",strtotime($reading->created_at)) }} {{ Lang::get('general.at') }} {{ date("h.ia",strtotime($reading->created_at)) }}
                                        @endif</p>
                                </div>
                                <div class="col-md-3 small-top-buffer" >
                                    <div class="circle circle-small-border" style="border-color: {{ getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] }}">
                                        <div class="circle-inner">
                                            <div class="small-score-text prev-reading" style="color: {{ getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] }}">
                                                {{ getTemperatureColor($reading->temperature, $temperaturePref)['temp'] }}<span>&#176;</span>
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
                    <div class="row" >
                        <h3>{{ Lang::get('general.There are no pet readings associated with your account') }}</h3>
                        <h4>{{ Lang::get('general.Click the "upload" button above to get started') }}</h4>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-8" >
            @if($pets->count())
            <div class="jumbotron vet-dashboard top-buffer" >
                <div class="row" >
                    <div class="col-md-5" >
                        <h3>{{ Lang::get('general.Customer activity') }}</h3>
                    </div>
                    <div class="col-md-7" >
                        <ul class="nav nav-pills top-buffer text-right">
                            <li class="active"><a href="#recent" data-toggle="pill" data-target="" >{{ Lang::get('general.Recent') }}</a></li>
                            {{--<li class="" ><a href="#customer" data-toggle="pill" data-target="">Customer</a></li>--}}
                            <li class="" ><a href="#pets" data-toggle="pill" data-target="">{{ Lang::get('general.Pets') }}</a></li>
                            <li class="" ><a href="#recent" data-toggle="pill" data-target=""><i class="fa fa-search"></i> {{ Lang::get('general.Search') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content ">
                    <div class="tab-pane active fade in" id="customer">
                        <div class="slider-content recent-slider top-buffer" >
                            @foreach($requests as $request)
                                @foreach ($pets as $pet)
                                    @if($request->pet_id = $pet->id && $request->approved == 1)
                                        @foreach ($pet->readings as $reading)
                                        <div class="row small-top-buffer" >
                                            <div class="col-md-12 " >
                                                <div class="col-md-2" >
                                                    {{ HTML::image(isset($pet->image_path) ? $pet->image_path : '/images/pet-image.png', $pet->name, array('class' => 'img-responsive img-circle', 'width' => '80%')) }}
                                                </div>
                                                <div class="col-md-6 left-none" >
                                                    <h3 class="small-top-buffer bottom-none">{{ $pet->name }}</h3><p class="blue" >@if(date("d/m/y",strtotime($reading->created_at)) == date("d/m/y"))
                                        {{ Lang::get('general.today at') }} {{ date("h.ia",strtotime($reading->created_at)) }}
                                    @else
                                        {{ date("d/m/y",strtotime($reading->created_at)) }} {{ Lang::get('general.at') }} {{ date("h.ia",strtotime($reading->created_at)) }}
                                    @endif</p>
                                                    <p>{{ Lang::get('general.Read') }} @if($reading->created_at == new DateTime())
                                                            {{ Lang::get('general.today at') }} {{ date("h.ia",strtotime($reading->created_at)) }}
                                                        @else
                                                            {{ date("d/m/y",strtotime($reading->created_at)) }} {{ Lang::get('general.at') }} {{ date("h.ia",strtotime($reading->created_at)) }}
                                                        @endif</p>
                                                </div>
                                                <div class="col-md-4 small-top-buffer" >
                                                    <div class="col-md-5" >
                                                        <div class="circle circle-small-border" style="border-color: {{ getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] }}">
                                                            <div class="circle-inner">
                                                                <div class="small-score-text prev-reading" style="color: {{ getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] }}">
                                                                    {{ getTemperatureColor($reading->temperature, $temperaturePref)['temp'] }}<span>&#176;</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7" >
                                                        <h4 class="top-buffer">+1.4<span>&#176;</span> <span><i class="fa fa-chevron-right"></i></span></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row small-top-buffer" >
                                            <div class="col-md-11 border-bottom col-centered float-none" ></div>
                                        </div>
                                        @endforeach
                                    @endif
                                @endforeach
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
                                @foreach($requests as $request)
                                    @foreach ($pets as $pet)
                                        @if($request->pet_id = $pet->id && $request->approved == 1)
                                            <?php
                                            $petsByName[strtolower($pet->name[0])][]=$pet;
                                            ?>
                                        @endif
                                    @endforeach
                                @endforeach
                                    <?php
                                        ksort($petsByName);
                                    ?>
                                @foreach($petsByName as $letter => $petsByLetter)
                                    <li id="{{ $letter }}"><a name="{{ $letter }}" class="title">{{ strtoupper($letter) }}</a>
                                        <ul>
                                            @foreach($petsByLetter as $pet)
                                                <li><a href="/vet/dashboard/pet/{{ $pet->id }}">{{ $pet->name }}<span class="pull-right" >{{ $pet->breed }} <i class="small-left-buffer fa fa-chevron-right"></i></span></a></li>
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
            <h3>{{ Lang::get('general.There is no customer data associated with your account') }}</h3>
            <h4>{{ Lang::get('general.Click the "settings"" button above to invite your customers') }}</h4>
            </div>
            @endif
        </div>
    </div>
@stop