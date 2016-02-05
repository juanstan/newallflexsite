<div class="row text-center" >
    <div class="col-xs-11 col-centered float-none nopadding" >
        @if ($pet->name)
            <h3>{!! Lang::get('general.Symptoms' ) !!}</h3>
            @if( $pet->readings->count() )
                @foreach ($pet->readings->slice(0, 1) as $reading)
                    <ul class="nav nav-pills text-center symptom-pills">
                        @foreach ($reading->symptoms as $readingSymptom)
                            <li role="presentation" class="symptom-pill small-top-buffer pill-remove active"><a href="{!! URL::route('user.dashboard.symptomRemove', $reading->id . '/' . $readingSymptom->id) !!}"><span>{!! $readingSymptom->name !!}</span></a></li>
                        @endforeach
                    </ul>
                    <ul class="nav nav-pills text-center symptom-pills">
                        <li role="presentation" class="symptom-pill-add small-top-buffer active" ><a href="#" data-toggle="collapse" data-target="#symptom-list{!! $pet->id !!}" >{!! Lang::get('general.+ Add') !!}</a></li>
                    </ul>
                @endforeach
            @else
                <h4>{!! Lang::get('general.No Symptoms Available' ) !!}</h4>
            @endif
            <div class="row text-center top-buffer " >
                <div class="col-xs-12 col-xs-10 col-centered float-none">
                    <div class="col-xs-4" >
                        <h4>{!! Lang::get('general.Previous Readings') !!}</h4>
                    </div>
                    @if( $pet->readings->count() )
                        @foreach ($pet->readings->slice(0, 4) as $reading)
                            <div class="col-xs-2 small-padding" >
                                <div class="circle circle-small-border" style="border-color: {!! getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] !!}" >
                                    <div class="circle-inner">
                                        <div class="small-score-text prev-reading" style="color: {!! getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] !!}">
                                            {!! getTemperatureColor($reading->temperature, $temperaturePref)['temp'] !!}<span>&#176;</span>
                                        </div>
                                    </div>
                                </div>
                                <small>{!! date("d/m/y",strtotime($reading->reading_time)) !!}</small>
                            </div>
                        @endforeach
                    @else
                        <div class="col-xs-8 small-padding noreadingyet" >
                            <h4>{!! Lang::get('general.No readings yet') !!}</h4>
                        </div>
                    @endif
                </div>
            </div>

        @else

            <div class="row assign-pet-title">
                <div class="col-xs-12">
                    <h4>{!! Lang::get('general.Assign to a pet') !!}</h4>
                    <div>{!! Lang::get('general.Create a pet profile fir this microchip number') !!}</div>
                </div>
            </div>

            <div class="row">
                @if(!$petNoMicrochips->isEmpty())
                    <div class="col-xs-6 nopadding">
                        <div class="btn-group btn-input clearfix">
                            {!! Form::open(array('route' => array('user.dashboard.assign', $pet->id), 'method' => 'post')) !!}
                            <button type="button" class="btn btn-default dropdown-toggle pet-tab form-control" data-toggle="dropdown">
                                <span data-bind="label">{!! Lang::get('general.Choose pet') !!}</span> <span class="caret"></span>
                                <input type="text" class="hidden" name="pet-id" value="" />
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                @foreach ($petNoMicrochips as $petNoMicrochip)
                                    <li data-id="{!! $petNoMicrochip->id !!}" ><a href="#">
                                            <div class="row choose-pet" >
                                                <div class="col-md-3 small-padding" >
                                                    {!! HTML::image(isset($petNoMicrochip->photo_id) ? $petNoMicrochip->photo->location : '/images/pet-image.png', $petNoMicrochip->name, array('class' => 'img-responsive img-circle', 'width' => '100%')) !!}
                                                </div>
                                                <div class="col-md-9 pet-name-dropdown" >
                                                    <h4>{!! $petNoMicrochip->name !!}</h4>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="col-xs-6 nopadding">
                @else
                    <div class="col-xs-12 nopadding center-create-pet-tab">
                @endif
                    <a href="#edit{!! $pet->id !!}" data-toggle="pill" class="create-pet-tab">
                        <button data-toggle="collapse" data-target="#pet-photo{!! $pet->id !!}" class="btn btn-block btn-default btn-lrg" type="button">{!! Lang::get('general.Create Profile') !!}</button>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>