@extends('layouts.user.dashboard')

@section('content')
    <?php
    $temperaturePref = \Auth::user()->get()->units;
    ?>
    <div class="row col-md-11 float-none col-centered collapse-group" >
        <div class="collapse" id="file-upload">
            {{ Form::open(array('files'=> 'true', 'route' => 'user.dashboard.readingUpload', 'class'=>'dropzone', 'method' => 'post')) }}
            {{ Form::close() }}
        </div>
    </div>
    
    @foreach ($animals as $animal) 
        @if ($animal->name == null)
            <div class="row col-md-11 float-none col-centered desktop" >
                <div class="alert alert-grey alert-dismissible" role="alert">
                    <button type="button" class="close small-top-buffer" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="inline-block small-top-buffer">{{ Lang::get('general.1 unknown microchip found, would you like to create a new pet for this microchip?') }}</h4>

                    <a href="#edit{{ $animal->id }}" data-toggle="pill" ><button data-toggle="collapse" data-target="#pet-photo{{ $animal->id }}" class="btn btn-file btn-md pull-right border-none" type="button">{{ Lang::get('Create') }}</button></a>
                </div>
            </div>
        @endif
    @endforeach
    <div class="row col-md-12 col-centered float-none top-buffer" >
       
        @foreach ($animals as $animal)

            <div class="col-md-4" >
                <div class="top-buffer mobile" ></div>
                <div class="row" >
                    <div class="col-md-12" >
                        <div class="col-xs-3" >
                                                    
                            {{ HTML::image(isset($animal->image_path) ? $animal->image_path : '/images/pet-image.png', $animal->name, array('class' => 'img-responsive img-circle', 'width' => '100%')) }}
                            
                        </div>
                        <div class="tab-content ">
                            <div class="col-xs-9 active tab-pane fade in small-padding" id="pet-name{{ $animal->id }}" >
                                <h3 class="top-none bottom-none text-left">{{ isset($animal->name) ? $animal->name : 'Unknown'; }}</h3>
                                <h4 class="top-none text-left">{{ isset($animal->microchip_number) ? $animal->microchip_number : Null; }}</h4>
                            </div>
                            <div class="col-xs-9 tab-pane fade in small-padding top-buffer" id="pet-photo{{ $animal->id }}" >
                                {{ Form::open(array('files'=> 'true', 'route' => array('user.dashboard.updatePetPhoto', $animal->id), 'method' => 'post')) }}
                                <p class="pointer" onclick="$('#ufile{{ $animal->id }}').click()" ><i class="fa fa-camera"></i> {{ Lang::get('general.Change photo') }}</p>

                                    <input class="hide" id="ufile{{ $animal->id }}" onchange="this.form.submit()"  name="pet-photo" type="file">
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="jumbotron dashboard top-buffer" >
                    <div class="vet-overlay collapse fade" id="pet-delete{{ $animal->id }}" >
                        <div class="col-md-12 text-center" >
                        <h3>{{ Lang::get('general.Are you sure you want to remove this pet?') }}</h3>
                            <div class="col-md-10 float-none col-centered top-buffer" >
                                <div class="col-md-6 small-padding" >
                                    <a href="#" data-toggle="collapse" data-target="#pet-delete{{ $animal->id }}" >
                                        {{ Form::button(Lang::get('general.No, cancel'), array('class' => 'btn-block btn btn-file btn-md')) }}
                                    </a>
                                </div>
                                <div class="top-buffer mobile" ></div>
                                <div class="col-md-6 small-padding" >
                                    <a href="{{ URL::route('user.dashboard.removePet', $animal->id) }}" >
                                        {{ Form::button(Lang::get('general.Yes, remove'), array('class' => 'btn-block btn btn-danger btn-md')) }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collapse vet-overlay fade" id="symptom-list{{ $animal->id }}" >
                    @foreach ($animal->sensorReadings->slice(0, 1) as $sensorReading)
                        {{ Form::open(array('files'=> 'true', 'route' => array('user.dashboard.addSymptoms', $sensorReading->id), 'method' => 'post')) }}
                        <div class="col-md-12 top-buffer" >
                            <div class="col-md-8" >
                                <h3 class="top-none">{{ Lang::get('general.Add symptoms') }}</h3>
                                <p>{{ Lang::get('general.Select all that apply') }}</p>
                            </div>
            
                            <div class="col-md-4 text-right" >
                                {{ Form::submit(Lang::get('general.Done'), array('class' => 'submit-text')) }}
                            </div>
                        </div>
                        <div class="col-md-12" >
                            <div class="btn-group symptom-list-wrap nav-justified" data-toggle="buttons">
                                @if( $animal->sensorReadings->count() )
                                    @foreach ($animal->sensorReadings as $sensorReading)
                                            @foreach ($sensorReading->sensorReadingSymptoms as $sensorReadingSymptom)
                                                <?php $symptomItems[] = $sensorReadingSymptom->symptom->name; ?>
                                            @endforeach
                                    @endforeach
                                @endif
                                @foreach ($symptoms as $symptom)
                                <div class="col-md-6 top-buffer small-padding" >
                                    <label class="btn btn-primary btn-block @if( !empty($symptomItems) && in_array($symptom->name, $symptomItems)) active  @endif">
                                    <input type="checkbox" name="symptoms[]" @if( !empty($symptomItems) && in_array($symptom->name, $symptomItems)) checked @endif value="{{ $symptom->id }}" autocomplete="off"> {{ $symptom->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        {{ Form::close() }}
                    @endforeach   
                    </div>

                    <div class="collapse vet-overlay fade" id="condition-list{{ $animal->id }}" >
                            {{ Form::open(array('files'=> 'true', 'route' => array('user.dashboard.addConditions', $animal->id), 'method' => 'post')) }}
                            <div class="col-md-12 top-buffer" >
                                <div class="col-md-8" >
                                    <h3 class="top-none">{{ Lang::get('general.Add conditions') }}</h3>
                                    <p>{{ Lang::get('general.Select all that apply') }}</p>
                                </div>

                                <div class="col-md-4 text-right" >
                                    {{ Form::submit(Lang::get('general.Done'), array('class' => 'submit-text')) }}
                                </div>
                            </div>
                            <div class="col-md-12" >
                                <div class="btn-group symptom-list-wrap nav-justified" data-toggle="buttons">
                                    @if( $animal->animalConditions->count() )
                                        @foreach ($animal->animalConditions as $animalCondition)
                                                <?php $conditionItems[] = $animalCondition->condition->name; ?>
                                        @endforeach
                                    @endif
                                    @foreach ($conditions as $condition)
                                        <div class="col-md-6 top-buffer small-padding" >
                                            <label class="btn btn-primary btn-block @if( !empty($conditionItems) && in_array($condition->name, $conditionItems)) active  @endif">
                                                <input type="checkbox" name="conditions[]" @if( !empty($conditionItems) && in_array($condition->name, $conditionItems)) checked @endif value="{{ $condition->id }}" autocomplete="off"> {{ $condition->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            {{ Form::close() }}
                    </div>

                    <div class="row" >
                        <div class="col-md-12" >
                            <ul class="nav mobile-nav nav-pills text-left">
                                <li class="active"><a href="#latest{{ $animal->id }}" data-toggle="pill" data-target="#pet-name{{ $animal->id }}, #latest{{ $animal->id }}, #pet-photo-hide{{ $animal->id }}" >{{ Lang::get('general.Latest') }}</a></li>
                                <li class="report-toggle" ><a href="#reports{{ $animal->id }}" data-toggle="pill" data-target="#pet-name{{ $animal->id }}, #reports{{ $animal->id }}, #pet-photo-hide{{ $animal->id }}">{{ Lang::get('general.Reports') }}</a></li>
                                <li class="pull-right" ><a href="#edit{{ $animal->id }}" data-toggle="pill" data-target="#pet-photo{{ $animal->id }}, #edit{{ $animal->id }}"  >{{ ($animal->name == NULL ? Lang::get('general.<i class="fa fa-cog"></i> Edit') : Lang::get('general.<i class="fa fa-cog"></i> Edit') ); }}</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="tab-content ">
                        <div class="tab-pane latest-list-wrap active fade in" id="latest{{ $animal->id }}">
                            <div class="row col-sm-8 col-md-12 col-centered float-none top-buffer" >
                                    @foreach ($animal->sensorReadings as $sensorReading)
                                        @if ($sensorReading->average == 1)
                                            <?php $allReadingTemps[] = $sensorReading->temperature; ?>
                                        @endif
                                    @endforeach
                                    @if(!empty($allReadingTemps))
                                    <?php
                                        $readingCount = count($allReadingTemps);
                                        $readingSum = array_sum($allReadingTemps);
                                        $readingAverage = $readingSum/$readingCount;
                                    ?>
                                    @endif
                                @if( $animal->sensorReadings->count() )
                                    @foreach ($animal->sensorReadings->slice(0, 1) as $sensorReading)
                                        <div class="circle circle-border"  style="border-color: {{ getTemperatureColor($sensorReading->temperature, $temperaturePref)['tempcol'] }}">
                                            <div class="small-circle circle-solid" style="background-color: {{ getTemperatureColor($sensorReading->temperature, $temperaturePref)['tempcol'] }}" >
                                                <div class="circle-inner">
                                                    <div class="small-score-text">
                                                        <p>{{ Lang::get('general.Avg') }}.</p>
                                                        @if(!empty($allReadingTemps))
                                                            {{ getTemperatureColor($readingAverage, $temperaturePref)['temp'] }}<span>&#176;</span>
                                                        @else
                                                           --.-<span>&#176;</span>
                                                        @endif
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="circle-inner">
                                                 <div class="score-text" style="color: {{ getTemperatureColor($sensorReading->temperature, $temperaturePref)['tempcol'] }}" >
                                                        {{ getTemperatureColor($sensorReading->temperature, $temperaturePref)['temp'] }}<span>&#176;</span>
                                                     <p>@if(date("d/m/y",strtotime($sensorReading->created_at)) == date("d/m/y"))
                                                         {{ Lang::get('general.today at') }} {{ date("h.ia",strtotime($sensorReading->created_at)) }}
                                                     @else
                                                     {{ date("d/m/y",strtotime($sensorReading->created_at)) }} {{ Lang::get('general.at') }} {{ date("h.ia",strtotime($sensorReading->created_at)) }}
                                                     @endif</p>
                                                 </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                <div class="circle circle-border" >
                                    <div class="small-circle circle-solid" >
                                        <div class="circle-inner">
                                            <div class="small-score-text">
                                                <p>Avg.</p>
                                                --.-<span>&#176;</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="circle-inner">
                                        <div class="score-text" >
                                                --.-<span>&#176;</span>
                                                <p>{{ Lang::get('general.No readings available') }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="row text-center" >
                                    <div class="col-md-11 col-centered float-none" >
                                        <h3>{{ Lang::get('general.Symptoms' ) }}</h3>
                                        @if( $animal->sensorReadings->count() )
                                            @foreach ($animal->sensorReadings->slice(0, 1) as $sensorReading)
                                                <ul class="nav nav-pills text-center symptom-pills">
                                                    @foreach ($sensorReading->sensorReadingSymptoms as $sensorReadingSymptom)
                                                    <li role="presentation" class="symptom-pill small-top-buffer pill-remove active"><a href="{{ URL::route('user.dashboard.symptomRemove', $sensorReadingSymptom->reading_id . '/' . $sensorReadingSymptom->symptom_id) }}"><span>{{ $sensorReadingSymptom->symptom->name }}</span></a></li>
                                                    @endforeach
                                                    <li role="presentation" class="symptom-pill small-top-buffer active" ><a href="#" data-toggle="collapse" data-target="#symptom-list{{ $animal->id }}" >{{ Lang::get('general.+ Add') }}</a></li>
                                                </ul>
                                            @endforeach
                                        @else
                                            <h4>{{ Lang::get('general.No Symptoms Available' ) }}</h4>
                                        @endif
                                    </div>
                                </div>
                                <div class="row text-center top-buffer " >
                                    <div class="col-md-12 col-xs-10 col-centered float-none">
                                    <div class="col-md-4" >
                                        <h4>{{ Lang::get('general.Previous Readings') }}</h4>
                                    </div>
                                    @if( $animal->sensorReadings->count() )
                                        @foreach ($animal->sensorReadings->slice(0, 4) as $sensorReading)
                                        <div class="col-md-2 col-xs-3 small-padding" >
                                            <div class="circle circle-small-border" style="border-color: {{ getTemperatureColor($sensorReading->temperature, $temperaturePref)['tempcol'] }}" >
                                                 <div class="circle-inner">
                                                     <div class="small-score-text prev-reading" style="color: {{ getTemperatureColor($sensorReading->temperature, $temperaturePref)['tempcol'] }}">
                                                         {{ getTemperatureColor($sensorReading->temperature, $temperaturePref)['temp'] }}<span>&#176;</span>
                                                     </div>
                                                 </div>
                                            </div>
                                            <small>{{ date("d/m/y",strtotime($sensorReading->created_at)) }}</small>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="col-md-8 small-padding" >
                                            <h4>{{ Lang::get('general.No Previous Readings Available') }}</h4>
                                        </div>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade in" id="reports{{ $animal->id }}">
                            <div class="row top-buffer dash-scrollable col-md-12 col-centered" >
                                @if( $animal->sensorReadings->count() )
                                    @foreach ($animal->sensorReadings->slice(0, 1) as $sensorReading)
                                <div class="row hero-banner" >
                                    <div class="col-xs-9 " >
                                        @if(!empty($allReadingTemps))
                                            <h4 class="top-buffer" style="color: white;">{{ isset($animal->name) ? $animal->name : 'Unknown'; }}{{ Lang::get('general.&#39; temperature is usually around') }} {{ getTemperatureColor($readingAverage, $temperaturePref)['temp'] }}&#176;</h4>
                                        @else
                                            <h4 class="top-buffer" style="color: white;">{{ Lang::get('general.There is not average temperature for') }} {{ isset($animal->name) ? $animal->name : 'Unknown'; }} {{ Lang::get('general.yet') }}</h4>
                                        @endif
                                    </div>
                                    <div class="col-xs-3 col-sm-2 col-md-3 small-padding" >
                                        @if(!empty($allReadingTemps))
                                            <div class="circle small-top-buffer circle-small-border" style="border-color: white;">
                                                <div class="circle-inner">
                                                    <div class="small-score-text" style="color: white;">
                                                        {{ getTemperatureColor($readingAverage, $temperaturePref)['temp'] }}<span>&#176;</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="circle small-top-buffer circle-small-border">
                                                <div class="circle-inner">
                                                    <div class="small-score-text">
                                                       --.-<span>&#176;</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                    @endforeach
                                @else
                                    <div class="row hero-banner" >
                                        <div class="col-xs-9" >
                                            <h4 class="top-buffer" style="color: white;">{{ Lang::get('general.No readings have been uploaded for') }} {{ isset($animal->name) ? $animal->name : 'Unknown'; }} {{ Lang::get('general.yet') }}.</h4>
                                        </div>
                                        <div class="col-xs-3 col-sm-2 col-md-3 small-padding" >
                                            <div class="circle small-top-buffer circle-small-border" style="border-color: white;">
                                                <div class="circle-inner">
                                                    <div class="small-score-text" style="color: white;">
                                                        --.-<span>&#176;</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if(count($animal->sensorReadings))
                                <div class="row top-buffer" >
                                    <div class="graph-container col-centered" style="width:95%; height:150px;" data-data='{{ $animal->sensorReadings }}' ></div>
                                </div>
                                @endif
                                <div class="row" >
                                @if( $animal->sensorReadings->count() )
                                    <?php $previousTemp = 0; ?>
                                    @foreach ($animal->sensorReadings->slice(0, 4) as $sensorReading)
                                    <div class="row text-left col-md-12" >
                                        <div class="col-md-12" >
                                            <h4>{{ date("d/m/y",strtotime($sensorReading->reading_time)) }}</h4>
                                        </div>
                                    </div>
                                    <div class="row text-left col-md-12" >
                                        <div class="col-xs-3 col-sm-2 small-padding" >
                                            <div class="circle circle-small-border" style="border-color: {{ getTemperatureColor($sensorReading->temperature, $temperaturePref)['tempcol'] }}">
                                                 <div class="circle-inner">
                                                     <div class="small-score-text prev-reading" style="color: {{ getTemperatureColor($sensorReading->temperature, $temperaturePref)['tempcol'] }}">
                                                         {{ getTemperatureColor($sensorReading->temperature, $temperaturePref)['temp'] }}<span>&#176;</span>
                                                     </div>
                                                 </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-7 text-left" >
                                            @if( $sensorReading->sensorReadingSymptoms->count() )
                                                    <ul class="nav nav-pills text-center symptom-pills">
                                                        @foreach ($sensorReading->sensorReadingSymptoms as $sensorReadingSymptom)
                                                            <li role="presentation" class="full-width small-top-buffer active"><a class="" href="#"><small>{{ $sensorReadingSymptom->symptom->name }}</small></a></li>
                                                        @endforeach
                                                    </ul>
                                            @else
                                                <small>{{ Lang::get('general.No symptoms added') }}</small>
                                            @endif
                                            <small>{{ date("h.ia",strtotime($sensorReading->reading_time)) }}</small>
                                        </div>
                                        <div class="col-xs-1" >
                                            <p>{{ round($sensorReading->temperature,1) - $previousTemp }}<span>&#176;</span></p>
                                        </div>
                                    </div>

                                    <?php $previousTemp = round($sensorReading->temperature,1); ?>


                                    @endforeach
                                @else
                                    <div class="col-md-8 small-padding" >
                                        <h4>{{ Lang::get('general.No Previous Readings Available') }}</h4>
                                    </div>
                                @endif
                                </div>
                            </div>
                        </div>
                        <div  class="tab-pane fade in" id="edit{{ $animal->id }}">
                            <div class="form-horizontal float-none top-buffer col-md-12 col-centered">
                                {{ Form::open(array('route' => array('user.dashboard.updatePet', $animal->id), 'method' => 'post', 'id' => 'petSettingsForm' . $animal->id )) }}

                                <div class="form-group">

                                        {{ Form::label('name', Lang::get('general.Name'), array('class' => 'col-sm-2 control-label')) }}

                                    <div class="col-sm-10">

                                        {{ Form::text('name', $animal->name, array('class' => 'form-control text-left')) }}

                                    </div>
                                </div>
                                <div class="form-group">

                                        {{ Form::label('breed', Lang::get('general.Breed'), array('class' => 'col-sm-2 control-label')) }}

                                    <div class="col-sm-10">
                                        @if(isset($animal->breed_id))
                                            {{ Form::text('breed_id', $animal->breed->name, array('class' => 'form-control text-left breed-list', 'id' => 'breedList' . $animal->id )) }}
                                        @else
                                            {{ Form::text('breed_id', '', array('class' => 'form-control text-left breed-list', 'id' => 'breedList' . $animal->id )) }}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 small-padding" >
                                    <div class="form-group">

                                        {{ Form::label('weight', Lang::get('general.Weight'), array('class' => 'col-sm-4 control-label')) }}

                                        <div class="col-sm-8">

                                            <div class="input-group">
                                                @if(Auth::user()->get()->weight_units == 'KG')
                                                    {{ Form::text('weight', $animal->weight, array('class' => 'form-control text-left')) }}
                                                @else
                                                    {{ Form::text('weight', round($animal->weight * 2.20462, 1), array('class' => 'form-control text-left')) }}
                                                @endif
                                                <div class="input-group-addon">@if(Auth::user()->get()->weight_units == 'KG') {{ Lang::get('general.kg') }} @else {{ Lang::get('general.lbs') }} @endif</div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                
                                        {{ Form::label('age', Lang::get('general.Date of birth'), array('class' => 'col-sm-5 control-label')) }}
                                        
                                    <div class="col-sm-7">
                                        
                                        {{ Form::input('date', 'date_of_birth', $animal->date_of_birth, array('class' => 'form-control text-left')) }}

                                    </div>
                                </div>
                                <div class="form-group">

                                        {{ Form::label('gender', Lang::get('general.Gender'), array('class' => 'col-sm-3 control-label')) }}

                                    <div class="col-sm-9">
                                        <div class="radio-pill-buttons">
                                            <label><input type="radio" @if($animal->gender == '1') checked @endif name="gender" value="1"><span class="pointer" >{{ Lang::get('general.Male') }}</span></label>
                                            <label><input type="radio" @if($animal->gender == '0') checked @endif name="gender" value="0"><span class="pointer" >{{ Lang::get('general.Female') }}</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">

                                        {{ Form::label('Known conditions', Lang::get('general.Known conditions'), array('class' => 'col-sm-7 control-label')) }}

                                    <div class="col-sm-5">
                                        <a href="#" data-toggle="collapse" data-target="#condition-list{{ $animal->id }}" >
                                            {{ Form::button(Lang::get('general.Manage <i class="fa fa-angle-right small-left-buffer"></i>'), array('class' => 'btn btn-file btn-block btn-md')) }}
                                        </a>
                                    </div>
                                </div>

                                {{ Form::close() }}

                                {{ Form::open(array('route' => array('user.dashboard.resetAverageTemperature', $animal->id), 'method' => 'post')) }}

                                <div class="form-group">

                                        {{ Form::label('Average temperature', Lang::get('general.Average temperature'), array('class' => 'col-sm-7 control-label')) }}

                                    <div class="col-sm-5">

                                        {{ Form::button(Lang::get('general.<i class="fa fa-refresh"></i> Reset'), array('class' => 'btn btn-file btn-block btn-md', 'type' => 'submit')) }}

                                    </div>
                                </div>
                                {{ Form::close() }}

                                <div class="form-group">
                                    <div class="col-md-5" >
                                        <a href="#" data-toggle="collapse" data-target="#pet-delete{{ $animal->id }}" >{{ Form::button(Lang::get('general.Remove'), array('class' => 'btn btn-file btn-block btn-md border-none')) }}</a>
                                    </div>
                                    <div class="top-buffer mobile" ></div>
                                    <div class="col-md-7" >
                                        {{ Form::submit(Lang::get('general.Save changes'), array('class' => 'btn btn-block btn-default btn-md', 'form' => 'petSettingsForm' . $animal->id)) }}
                                    </div>
                                        

                                    
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-md-4" >
            <div class="tab-content ">
                <div  class="tab-pane active fade in" id="newPet">
                    <div class="jumbotron dashboard add-new-pet large-top-buffer" >
                        <div class="row" >
                            <div class="col-md-12 text-center" >
                                <a href="#newPetDetails" data-toggle="pill" data-target="" >
                                    <h2>
                                        <span class="fa-stack">
                                            <i class="fa fa-circle-thin fa-stack-2x"></i>
                                            <i class="fa fa-plus fa-stack-1x"></i>
                                        </span>
                                    </h2>
                                    <h3 class="top-none" >{{ Lang::get('general.New pet') }}</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div  class="tab-pane fade in" id="newPetDetails">
                    <div class="jumbotron dashboard large-top-buffer" >
                        <div class="row" >
                            <div class="col-md-12" >
                                <ul class="nav nav-pills text-left">
                                    <li class="disabled"><a href="#latest" data-toggle="pill" data-target="" >{{ Lang::get('general.Latest') }}</a></li>
                                    <li class="disabled" ><a href="#reports" data-toggle="pill" data-target="">{{ Lang::get('general.Reports') }}</a></li>
                                    <li class="pull-right active" ><a href="#edit" data-toggle="pill" data-target=""><i class="fa fa-plus"></i> {{ Lang::get('general.<i class="fa fa-cog"></i> Edit') }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-horizontal float-none  top-buffer col-md-12 col-centered">
                            {{ Form::open(array('files'=> 'true', 'route' => 'user.dashboard.createPet', 'method' => 'post')) }}
                            
                            <div class="form-group">
                
                                    {{ Form::label('pet-photo', Lang::get('general.Add photo'), array('class' => 'col-sm-3 right-none control-label')) }}

                                <div class="col-sm-9 text-left">

                                    {{ Form::button(Lang::get('general.Browse'), array('class' => 'btn btn-file pull-left', 'onclick' => '$("#ufile").click()' )) }}

                                    {{ Form::file('pet-photo', array('class' => 'hide', 'id'=>'ufile')) }}
                                   
                                </div>
                            </div>
                            <div class="form-group">

                                    {{ Form::label('name', Lang::get('general.Name'), array('class' => 'col-sm-3 control-label')) }}

                                <div class="col-sm-9">

                                    {{ Form::text('name', '', array('class' => 'form-control text-left')) }}

                                </div>
                            </div>
                            <div class="form-group">

                                    {{ Form::label('breed', Lang::get('general.Breed'), array('class' => 'col-sm-3 control-label')) }}

                                <div class="col-sm-9">

                                    {{ Form::text('breed_id', '', array('class' => 'form-control text-left breed-list')) }}

                                </div>
                            </div>

                            <div class="col-md-12 small-padding" >
                                <div class="form-group">

                                    {{ Form::label('weight', Lang::get('general.Weight'), array('class' => 'col-sm-4 control-label')) }}

                                    <div class="col-sm-8">

                                        <div class="input-group">

                                            {{ Form::text('weight', '', array('class' => 'form-control text-left')) }}


                                            <div class="input-group-addon">{{ Lang::get('general.kg') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            
                                    {{ Form::label('age', Lang::get('general.Date of birth'), array('class' => 'col-sm-5 control-label')) }}
                                    
                                <div class="col-sm-7">
                                    
                                    {{ Form::input('date', 'date_of_birth', '', array('class' => 'form-control text-left')) }}

                                </div>
                            </div>
                            <div class="form-group">

                                    {{ Form::label('gender', Lang::get('general.Gender'), array('class' => 'col-sm-3 control-label')) }}

                                <div class="col-sm-9">
                                    <div class="radio-pill-buttons">
                                        <label><input type="radio" name="gender" value="1"><span class="pointer" >{{ Lang::get('general.Male') }}</span></label>
                                        <label><input type="radio" name="gender" value="0"><span class="pointer" >{{ Lang::get('general.Female') }}</span></label>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="form-group">--}}

                                    {{--{{ Form::label('Known conditions', Lang::get('general.Known conditions'), array('class' => 'col-sm-7 control-label')) }}--}}

                                {{--<div class="col-sm-5">--}}

                                    {{--{{ Form::button(Lang::get('general.Manage <i class="fa fa-angle-right small-left-buffer"></i>'), array('class' => 'btn btn-file btn-block btn-md')) }}--}}

                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <div class="col-md-12" >

                                    {{ Form::submit(Lang::get('general.Save changes'), array('class' => 'btn btn-block btn-default btn-md')) }}

                                </div>
                                    
                                {{ Form::close() }}
                                
                            </div>
                        </div>  
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <div class="large-top-buffer" ></div>
@stop