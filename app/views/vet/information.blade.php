@extends('layouts.vet.dashboard')

@section('content')
    <?php
    $temperaturePref = \Auth::vet()->get()->units;
    ?>
    <div class="row col-md-11 float-none col-centered collapse-group" >
        <div class="collapse" id="file-upload">

            {{ Form::open(array('files'=> 'true', 'route' => 'vet.dashboard.readingUpload', 'class'=>'dropzone', 'method' => 'post')) }}
            {{ Form::close() }}

        </div>
    </div>
    <div class="row col-md-12 col-centered float-none top-buffer" >
        <div class="col-md-4" >
            <div class="jumbotron pet-dashboard top-buffer" >
                <div class="row top-buffer" >
                    <div class="col-md-12 col-centered float-none" >
                        <div class="col-xs-4" >
                            {{ HTML::image(isset($pet->image_path) ? $pet->image_path : '/images/pet-image.png', $pet->name, array('class' => 'img-responsive img-circle', 'width' => '100%')) }}
                        </div>
                        <div class="col-md-8" >
                            <h3 class="bottom-none">{{ isset($pet->name) ? $pet->name : Lang::get('general.Unknown'); }}</h3>
                            <p>{{ isset($pet->microchip_number) ? $pet->microchip_number : Lang::get('general.Unknown microchip'); }}</p>
                        </div>
                    </div>
                </div>
                <div class="row top-buffer" >
                    <div class="col-md-12 col-centered float-none" >
                        <?php
                        # object oriented
                        $from = new DateTime($pet->date_of_birth);
                        $to   = new DateTime('today');
                        $age = $from->diff($to)->y;
                        ?>
                        <div class="col-xs-4" >
                            <h4><i class="fa fa-birthday-cake"></i> {{ $age }}</h4>
                        </div>
                        <div class="col-xs-4" >
                            <h4><i class="fa fa fa-heartbeat"></i> {{ $pet->weight }}</h4>
                        </div>
                        <div class="col-xs-4" >
                            @if($pet->gender == 'Male')
                                <h4><i class="fa fa-mars"></i> {{ $pet->gender }}</h4>
                            @else
                                <h4><i class="fa fa-venus"></i> {{ $pet->gender }}</h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8" >
            <div class="jumbotron vet-dashboard top-buffer" >
                <div class="row hero-banner" >
                @foreach ($pet->sensorReadings as $reading)
                    @if ($reading->average == 1)
                        <?php $allReadingTemps[] = $reading->temperature; ?>
                    @endif
                @endforeach
                @if(!empty($allReadingTemps))
                    <?php
                    $readingCount = count($allReadingTemps);
                    $readingSum = array_sum($allReadingTemps);
                    $readingAverage = $readingSum/$readingCount;
                    ?>
                @endif
                    @if( $pet->sensorReadings->count() )
                        @foreach ($pet->sensorReadings->slice(0, 1) as $reading)
                            <div class="col-md-12 col-centered float-none" >
                                <div class="col-xs-10" >
                                    @if(!empty($allReadingTemps))
                                        <h3 style="color: white;" class="small-top-buffer">{{ isset($pet->name) ? $pet->name : 'Unknown'; }}{{ Lang::get('general.&#39;s temperature is usually around') }} {{ getTemperatureColor($readingAverage, $temperaturePref)['temp'] }}&#176;</h3>
                                    @else
                                        <h3 style="color: white;" class="small-top-buffer">{{ Lang::get('general.There is not average temperature for') }} {{ isset($pet->name) ? $pet->name : 'Unknown'; }} {{ Lang::get('general.yet') }}</h3>
                                    @endif
                                </div>
                                <div class="col-xs-2">
                                    <div class="circle circle-small-border" style="border-color: white">
                                        <div class="circle-inner">
                                            <div class="small-score-text" style="color: white;" >
                                                @if(!empty($allReadingTemps))
                                                {{ getTemperatureColor($reading->temperature, $temperaturePref)['temp'] }}<span>&#176;</span>
                                                @else
                                                    --.-<span>&#176;</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12 col-centered float-none" >
                            <div class="col-md-10 col-xs-8" >
                                    <h3 style="color: white;" class="small-top-buffer">{{ Lang::get('general.There is no average temperature for') }} {{ isset($pet->name) ? $pet->name : Lang::get('general.Unknown'); }} {{ Lang::get('general.yet') }}</h3>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <div class="circle circle-small-border" style="border-color: white">
                                    <div class="circle-inner">
                                        <div class="small-score-text" style="color: white;" >
                                                --.-<span>&#176;</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @if( $pet->sensorReadings->count() )
                <div class="row top-buffer" >
                    <div class="col-md-11 col-centered float-none" >
                        <h3>{{ Lang::get('general.Readings over time') }}</h3>
                        <div class="vet-graph-container col-centered" style="width:95%; height:150px;" data-data='{{ $pet->readings }}' ></div>
                    </div>
                </div>
                @foreach ($pet->sensorReadings as $reading)
                <div class="row small-top-buffer" >
                    <div class="col-md-11 col-centered float-none" >
                        <div class="col-md-2">
                            <div class="circle circle-small-border" style="border-color: {{ getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] }}">
                                <div class="circle-inner">
                                    <div class="small-score-text" style="color: {{ getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] }}">
                                        {{ getTemperatureColor($reading->temperature, $temperaturePref)['temp'] }}<span>&#176;</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9" >
                            @if( $reading->count() )
                                    @foreach ($reading->sensorReadingSymptoms as $readingSymptom)
                                        <h4 style="color: #71787f;">{{ $readingSymptom->name }}</h4>
                                    @endforeach
                            @else
                                <h4>{{ Lang::get('general.No symptoms available') }}</h4>
                                <br>
                            @endif
                            <p>@if($reading->created_at == new DateTime())
                                    {{ Lang::get('general.today at') }} {{ date("h.ia",strtotime($reading->created_at)) }}
                                @else
                                    {{ date("d/m/y",strtotime($reading->created_at)) }} {{ Lang::get('general.at') }} {{ date("h.ia",strtotime($reading->created_at)) }}
                                @endif</p>
                        </div>
                        <div class="col-md-1" >
                            <h3>+2<span>&#176;</span></h3>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                    <div class="row top-buffer" >
                        <div class="col-md-11 col-centered float-none" >
                            <h3>{{ Lang::get('general.There is no reading data submitted for') }} {{ $pet->name }}</h3>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop