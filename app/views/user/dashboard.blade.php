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
    
    @foreach ($pets as $value) 
        @if ($value->name == null)
            <div class="row col-md-11 float-none col-centered desktop" >
                <div class="alert alert-grey alert-dismissible" role="alert">
                    <button type="button" class="close small-top-buffer" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="inline-block small-top-buffer">{{ Lang::get('general.1 unknown microchip found, would you like to create a new pet for this microchip?') }}</h4>

                    <a href="#edit{{ $value->id }}" data-toggle="pill" ><button data-toggle="collapse" data-target="#pet-photo{{ $value->id }}" class="btn btn-file btn-md pull-right border-none" type="button">{{ Lang::get('Create') }}</button></a>
                </div>
            </div>
        @endif
    @endforeach
    <div class="row col-md-12 col-centered float-none top-buffer" >
       
        @foreach ($pets as $value)

            <div class="col-md-4" >
                <div class="top-buffer mobile" ></div>
                <div class="row" >
                    <div class="col-md-12" >
                        <div class="col-xs-3" >
                                                    
                            {{ HTML::image(isset($value->image_path) ? $value->image_path : '/images/pet-image.png', $value->name, array('class' => 'img-responsive img-circle', 'width' => '100%')) }}
                            
                        </div>
                        <div class="tab-content ">
                            <div class="col-xs-9 active tab-pane fade in small-padding" id="pet-name{{ $value->id }}" >
                                <h3 class="top-none bottom-none text-left">{{ isset($value->name) ? $value->name : 'Unknown'; }}</h3>
                                <h4 class="top-none text-left">{{ isset($value->microchip_number) ? $value->microchip_number : Null; }}</h4>
                            </div>
                            <div class="col-xs-9 tab-pane fade in small-padding top-buffer" id="pet-photo{{ $value->id }}" >
                                {{ Form::open(array('files'=> 'true', 'url' => array('/user/dashboard/update-pet-photo', $value->id), 'method' => 'post')) }}
                                <p class="pointer" onclick="$('#ufile{{ $value->id }}').click()" ><i class="fa fa-camera"></i> {{ Lang::get('general.Change photo') }}</p>

                                    <input class="hide" id="ufile{{ $value->id }}" onchange="this.form.submit()"  name="pet-photo" type="file">
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="jumbotron dashboard top-buffer" >
                    <div class="vet-overlay collapse fade" id="pet-delete{{ $value->id }}" >
                        <div class="col-md-12 text-center" >
                        <h3>{{ Lang::get('general.Are you sure you want to remove this pet?') }}</h3>
                            <div class="col-md-10 float-none col-centered top-buffer" >
                                <div class="col-md-6 small-padding" >
                                    <a href="#" data-toggle="collapse" data-target="#pet-delete{{ $value->id }}" >
                                        {{ Form::button(Lang::get('general.No, cancel'), array('class' => 'btn-block btn btn-file btn-md')) }}
                                    </a>
                                </div>
                                <div class="top-buffer mobile" ></div>
                                <div class="col-md-6 small-padding" >
                                    <a href="/user/dashboard/remove-pet/{{ $value->id }}" >
                                        {{ Form::button(Lang::get('general.Yes, remove'), array('class' => 'btn-block btn btn-danger btn-md')) }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collapse vet-overlay fade" id="symptom-list{{ $value->id }}" >
                    @foreach ($value->sensorReadings->slice(0, 1) as $readings)
                        {{ Form::open(array('files'=> 'true', 'url' => array('/user/dashboard/add-symptoms', $readings->id), 'method' => 'post')) }}
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
                                @if( $value->sensorReadings->count() )
                                    @foreach ($value->sensorReadings->slice(0, 1) as $readings)
                                            @foreach ($readings->sensorReadingSymptoms as $readingSymptom)
                                                <?php $symptomItems[] = $readingSymptom->name; ?>
                                            @endforeach
                                    @endforeach
                                @endif
                                @foreach ($symptoms as $symptom)
                                <div class="col-md-6 top-buffer" >
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

                    <div class="collapse vet-overlay fade" id="condition-list{{ $value->id }}" >
                        @foreach ($value->sensorReadings->slice(0, 1) as $readings)
                            {{ Form::open(array('files'=> 'true', 'url' => array('/user/dashboard/add-symptoms', $readings->id), 'method' => 'post')) }}
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
                                    @if( $value->sensorReadings->count() )
                                        @foreach ($value->sensorReadings->slice(0, 1) as $readings)
                                            @foreach ($readings->sensorReadingSymptoms as $readingSymptom)
                                                <?php $symptomItems[] = $readingSymptom->name; ?>
                                            @endforeach
                                        @endforeach
                                    @endif
                                    @foreach ($symptoms as $symptom)
                                        <div class="col-md-6 top-buffer" >
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

                    <div class="row" >
                        <div class="col-md-12" >
                            <ul class="nav mobile-nav nav-pills text-left">
                                <li class="active"><a href="#latest{{ $value->id }}" data-toggle="pill" data-target="#pet-name{{ $value->id }}, #latest{{ $value->id }}, #pet-photo-hide{{ $value->id }}" >{{ Lang::get('general.Latest') }}</a></li>
                                <li class="report-toggle" ><a href="#reports{{ $value->id }}" data-toggle="pill" data-target="#pet-name{{ $value->id }}, #reports{{ $value->id }}, #pet-photo-hide{{ $value->id }}">{{ Lang::get('general.Reports') }}</a></li>
                                <li class="pull-right" ><a href="#edit{{ $value->id }}" data-toggle="pill" data-target="#pet-photo{{ $value->id }}, #edit{{ $value->id }}"  >{{ ($value->name == NULL ? Lang::get('general.<i class="fa fa-cog"></i> Edit') : Lang::get('general.<i class="fa fa-cog"></i> Edit') ); }}</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="tab-content ">
                        <div class="tab-pane latest-list-wrap active fade in" id="latest{{ $value->id }}">
                            <div class="row col-sm-8 col-md-12 col-centered float-none top-buffer" >
                                    @foreach ($value->sensorReadings as $readings)
                                        @if ($readings->average == 1)
                                            <?php $allReadingTemps[] = $readings->temperature; ?>
                                        @endif
                                    @endforeach
                                    @if(!empty($allReadingTemps))
                                    <?php
                                        $readingCount = count($allReadingTemps);
                                        $readingSum = array_sum($allReadingTemps);
                                        $readingAverage = $readingSum/$readingCount;
                                    ?>
                                    @endif
                                @if( $value->sensorReadings->count() )
                                    @foreach ($value->sensorReadings->slice(0, 1) as $readings)
                                        <div class="circle circle-border"  style="border-color: {{ getTemperatureColor($readings->temperature, $temperaturePref)['tempcol'] }}">
                                            <div class="small-circle circle-solid" style="background-color: {{ getTemperatureColor($readings->temperature, $temperaturePref)['tempcol'] }}" >
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
                                                 <div class="score-text" style="color: {{ getTemperatureColor($readings->temperature, $temperaturePref)['tempcol'] }}" >
                                                        {{ getTemperatureColor($readings->temperature, $temperaturePref)['temp'] }}<span>&#176;</span>
                                                     <p>@if(date("d/m/y",strtotime($readings->created_at)) == date("d/m/y"))
                                                         {{ Lang::get('general.today at') }} {{ date("h.ia",strtotime($readings->created_at)) }}
                                                     @else
                                                     {{ date("d/m/y",strtotime($readings->created_at)) }} {{ Lang::get('general.at') }} {{ date("h.ia",strtotime($readings->created_at)) }}
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
                                        @if( $value->sensorReadings->count() )
                                            @foreach ($value->sensorReadings->slice(0, 1) as $readings)
                                                <ul class="nav nav-pills text-center symptom-pills">
                                                    @foreach ($readings->sensorReadingSymptoms as $readingSymptom)
                                                    <li role="presentation" class="symptom-pill small-top-buffer pill-remove active"><a href="dashboard/symptom-remove/{{ $readingSymptom->reading_id }}/{{ $readingSymptom->symptom_names->id }}"><span>{{ $readingSymptom->symptom_names->name }}</span></a></li>
                                                    @endforeach
                                                    <li role="presentation" class="symptom-pill small-top-buffer active" ><a href="#" data-toggle="collapse" data-target="#symptom-list{{ $value->id }}" >{{ Lang::get('general.+ Add') }}</a></li>
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
                                    @if( $value->sensorReadings->count() )
                                        @foreach ($value->sensorReadings->slice(0, 4) as $readings)
                                        <div class="col-md-2 col-xs-3 small-padding" >
                                            <div class="circle circle-small-border" style="border-color: {{ getTemperatureColor($readings->temperature, $temperaturePref)['tempcol'] }}" >
                                                 <div class="circle-inner">
                                                     <div class="small-score-text prev-reading" style="color: {{ getTemperatureColor($readings->temperature, $temperaturePref)['tempcol'] }}">
                                                         {{ getTemperatureColor($readings->temperature, $temperaturePref)['temp'] }}<span>&#176;</span>
                                                     </div>
                                                 </div>
                                            </div>
                                            <small>{{ date("d/m/y",strtotime($readings->created_at)) }}</small>
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

                        <div class="tab-pane fade in" id="reports{{ $value->id }}">
                            <div class="row top-buffer dash-scrollable col-md-12 col-centered" >
                                @if( $value->sensorReadings->count() )
                                    @foreach ($value->sensorReadings->slice(0, 1) as $readings)
                                <div class="row hero-banner" >
                                    <div class="col-xs-9 " >
                                        @if(!empty($allReadingTemps))
                                            <h4 class="top-buffer" style="color: white;">{{ isset($value->name) ? $value->name : 'Unknown'; }}{{ Lang::get('general.&#39; temperature is usually around') }} {{ getTemperatureColor($readingAverage, $temperaturePref)['temp'] }}&#176;</h4>
                                        @else
                                            <h4 class="top-buffer" style="color: white;">{{ Lang::get('general.There is not average temperature for') }} {{ isset($value->name) ? $value->name : 'Unknown'; }} {{ Lang::get('general.yet') }}</h4>
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
                                            <h4 class="top-buffer" style="color: white;">{{ Lang::get('general.No readings have been uploaded for') }} {{ isset($value->name) ? $value->name : 'Unknown'; }} {{ Lang::get('general.yet') }}.</h4>
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
                                @if(count($value->sensorReadings))
                                <div class="row top-buffer" >
                                    <div class="graph-container col-centered" style="width:95%; height:150px;" data-data='{{ $value->sensorReadings }}' ></div>
                                </div>
                                @endif
                                <div class="row" >
                                @if( $value->sensorReadings->count() )
                                    <?php $previousTemp = 0; ?>
                                    @foreach ($value->sensorReadings->slice(0, 4) as $readings)
                                    <div class="row text-left col-md-12" >
                                        <div class="col-md-12" >
                                            <h4>{{ date("d/m/y",strtotime($readings->reading_time)) }}</h4>
                                        </div>
                                    </div>
                                    <div class="row text-left col-md-12" >
                                        <div class="col-xs-3 col-sm-2 small-padding" >
                                            <div class="circle circle-small-border" style="border-color: {{ getTemperatureColor($readings->temperature, $temperaturePref)['tempcol'] }}">
                                                 <div class="circle-inner">
                                                     <div class="small-score-text prev-reading" style="color: {{ getTemperatureColor($readings->temperature, $temperaturePref)['tempcol'] }}">
                                                         {{ getTemperatureColor($readings->temperature, $temperaturePref)['temp'] }}<span>&#176;</span>
                                                     </div>
                                                 </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-7 text-left" >
                                            @if( $readings->sensorReadingSymptoms->count() )
                                                    <ul class="nav nav-pills text-center symptom-pills">
                                                        @foreach ($readings->sensorReadings as $readingSymptom)
                                                            <li role="presentation" class="full-width small-top-buffer active"><a class="" href="#"><small>{{ $readingSymptom->symptom_names->name }}</small></a></li>
                                                        @endforeach
                                                    </ul>
                                            @else
                                                <small>{{ Lang::get('general.No symptoms available') }}</small>
                                            @endif
                                            <small>{{ date("h.ia",strtotime($readings->reading_time)) }}</small>
                                        </div>
                                        <div class="col-xs-1" >
                                            <p>{{ round($readings->temperature,1) - $previousTemp }}<span>&#176;</span></p>
                                        </div>
                                    </div>

                                    <?php $previousTemp = round($readings->temperature,1); ?>


                                    @endforeach
                                @else
                                    <div class="col-md-8 small-padding" >
                                        <h4>{{ Lang::get('general.No Previous Readings Available') }}</h4>
                                    </div>
                                @endif
                                </div>
                            </div>
                        </div>
                        <div  class="tab-pane fade in" id="edit{{ $value->id }}">
                            <div class="form-horizontal float-none top-buffer col-md-12 col-centered">
                                {{ Form::open(array('url' => array('user', $value->id), 'method' => 'post', 'id' => 'petSettingsForm')) }}

                                <div class="form-group">

                                        {{ Form::label('name', Lang::get('general.Name'), array('class' => 'col-sm-2 control-label')) }}

                                    <div class="col-sm-10">

                                        {{ Form::text('name', $value->name, array('class' => 'form-control text-left')) }}

                                    </div>
                                </div>
                                <div class="form-group">

                                        {{ Form::label('breed', Lang::get('general.Breed'), array('class' => 'col-sm-2 control-label')) }}

                                    <div class="col-sm-10">

                                        {{ Form::text('breed', $value->breed, array('class' => 'form-control text-left')) }}

                                    </div>
                                </div>
                                <div class="col-md-6 small-padding" >
                                    <div class="form-group">
                                    
                                        {{ Form::label('size', Lang::get('general.Size'), array('class' => 'col-sm-4 control-label')) }}

                                        <div class="col-sm-7">
                                        
                                            {{ Form::select('size', array('S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL'), $value->size, array('class' => 'form-control')) }}

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 small-padding" >
                                    <div class="form-group">

                                        {{ Form::label('weight', Lang::get('general.Weight'), array('class' => 'col-sm-4 control-label')) }}

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                {{ Form::text('weight', $value->weight, array('class' => 'form-control text-left')) }}

                                                <div class="input-group-addon">{{ Lang::get('general.kg') }}</div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                
                                        {{ Form::label('age', Lang::get('general.Date of birth'), array('class' => 'col-sm-5 control-label')) }}
                                        
                                    <div class="col-sm-7">
                                        
                                        {{ Form::input('date', 'date_of_birth', $value->date_of_birth, array('class' => 'form-control text-left')) }}

                                    </div>
                                </div>
                                <div class="form-group">

                                        {{ Form::label('gender', Lang::get('general.Gender'), array('class' => 'col-sm-3 control-label')) }}

                                    <div class="col-sm-9">
                                        <div class="radio-pill-buttons">
                                            <label><input type="radio" @if($value->gender == 'Male') checked @endif name="gender" value="Male"><span class="pointer" >{{ Lang::get('general.Male') }}</span></label>
                                            <label><input type="radio" @if($value->gender == 'Female') checked @endif name="gender" value="Female"><span class="pointer" >{{ Lang::get('general.Female') }}</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">

                                        {{ Form::label('Known conditions', Lang::get('general.Known conditions'), array('class' => 'col-sm-7 control-label')) }}

                                    <div class="col-sm-5">
                                        <a href="#" data-toggle="collapse" data-target="#condition-list{{ $value->id }}" >
                                            {{ Form::button(Lang::get('general.Manage <i class="fa fa-angle-right small-left-buffer"></i>'), array('class' => 'btn btn-file btn-block btn-md')) }}
                                        </a>
                                    </div>
                                </div>

                                {{ Form::close() }}

                                {{ Form::open(array('url' => array('/user/dashboard/reset-average-temperature', $value->id), 'method' => 'post')) }}

                                <div class="form-group">

                                        {{ Form::label('Average temperature', Lang::get('general.Average temperature'), array('class' => 'col-sm-7 control-label')) }}

                                    <div class="col-sm-5">

                                        {{ Form::button(Lang::get('general.<i class="fa fa-refresh"></i> Reset'), array('class' => 'btn btn-file btn-block btn-md', 'type' => 'submit')) }}

                                    </div>
                                </div>
                                {{ Form::close() }}

                                <div class="form-group">
                                    <div class="col-md-5" >
                                        <a href="#" data-toggle="collapse" data-target="#pet-delete{{ $value->id }}" >{{ Form::button(Lang::get('general.Remove'), array('class' => 'btn btn-file btn-block btn-md border-none')) }}</a>
                                    </div>
                                    <div class="top-buffer mobile" ></div>
                                    <div class="col-md-7" >
                                        {{ Form::submit(Lang::get('general.Save changes'), array('class' => 'btn btn-block btn-default btn-md', 'form' => 'petSettingsForm')) }}
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
                            {{ Form::open(array('files'=> 'true', 'url' => '/user/dashboard/create-pet', 'method' => 'post')) }}
                            
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

                                    {{ Form::text('breed', '', array('class' => 'form-control text-left')) }}

                                </div>
                            </div>
                            <div class="col-md-6 small-padding" >
                                <div class="form-group">
                                
                                    {{ Form::label('size', Lang::get('general.Size'), array('class' => 'col-sm-4 control-label')) }}

                                    <div class="col-sm-7">
                                    
                                        {{ Form::select('size', array('S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL'), NULL, array('class' => 'form-control')) }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 small-padding" >
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
                                        <label><input type="radio" name="gender" value="Male"><span class="pointer" >{{ Lang::get('general.Male') }}</span></label>
                                        <label><input type="radio" name="gender" value="Female"><span class="pointer" >{{ Lang::get('general.Female') }}</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">

                                    {{ Form::label('Known conditions', Lang::get('general.Known conditions'), array('class' => 'col-sm-7 control-label')) }}

                                <div class="col-sm-5">

                                    {{ Form::button(Lang::get('general.Manage <i class="fa fa-angle-right small-left-buffer"></i>'), array('class' => 'btn btn-file btn-block btn-md')) }}

                                </div>
                            </div>
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