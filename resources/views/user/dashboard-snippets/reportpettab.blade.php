<div class="tab-pane fade in" id="reports{!! $pet->id !!}">
    <div class="row top-buffer dash-scrollable col-md-12 col-centered" >
        @if( $pet->readings->count() )
            @foreach ($pet->readings->slice(0, 1) as $reading)
                <div class="row hero-banner" >
                    <div class="col-xs-9 " >
                        @if(!empty($allReadingTemps))
                            <h4 class="top-buffer" style="color: white;">{!! isset($pet->name) ? $pet->name : 'Unknown' !!}{!! Lang::get('general.&#39; temperature is usually around') !!} {!! getTemperatureColor($readingAverage, $temperaturePref)['temp'] !!}&#176;</h4>
                        @else
                            <h4 class="top-buffer" style="color: white;">{!! Lang::get('general.There is not average temperature for') !!} {!! isset($pet->name) ? $pet->name : 'Unknown' !!} {!! Lang::get('general.yet') !!}</h4>
                        @endif
                    </div>
                    <div class="col-xs-2 small-padding" >
                        @if(!empty($allReadingTemps))
                            <div class="circle small-top-buffer circle-small-border" style="border-color: white;">
                                <div class="circle-inner">
                                    <div class="small-score-text margintop0-25" style="color: white;">
                                        {!! getTemperatureColor($readingAverage, $temperaturePref)['temp'] !!}<span>&#176;</span>
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
                    <h4 class="top-buffer" style="color: white;">{!! Lang::get('general.No readings have been uploaded for') !!} {!! isset($pet->name) ? $pet->name : 'Unknown'; !!} {!! Lang::get('general.yet') !!}.</h4>
                </div>
                <div class="col-xs-2 col-md-3 small-padding" >
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
        @if(count($pet->readings))
            <div class="row top-buffer" >
                <div class="graph-container col-centered" style="width:95%; height:150px;" data-data='{!! $pet->readings !!}' ></div>
            </div>
        @endif
        <div class="row" >
            @if( $pet->readings->count() )
                <?php $previousTemp = 0; ?>
                @foreach ($pet->readings->slice(0, 4) as $reading)
                    <div class="row text-left col-xs-12" >
                        <div class="col-xs-12" >
                            <h4>{!! date("d/m/y",strtotime($reading->reading_time)) !!}</h4>
                        </div>
                    </div>
                    <div class="row text-left col-xs-12" >
                        <div class="col-xs-2 small-padding" >
                            <div class="circle circle-small-border" style="border-color: {!! getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] !!}">
                                <div class="circle-inner">
                                    <div class="small-score-text prev-reading" style="color: {!! getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] !!}">
                                        {!! getTemperatureColor($reading->temperature, $temperaturePref)['temp'] !!}<span>&#176;</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-7 text-left" >
                            @if( $reading->symptoms->count() )
                                <ul class="nav nav-pills text-center symptom-pills">
                                    @foreach ($reading->symptoms as $readingSymptom)
                                        <li role="presentation" class="full-width small-top-buffer active"><a class="" href="#"><small>{!! $readingSymptom->name !!}</small></a></li>
                                    @endforeach
                                </ul>
                            @else
                                <small>{!! Lang::get('general.No symptoms added') !!}</small>
                            @endif
                            <small>{!! date("h.ia",strtotime($reading->reading_time)) !!}</small>
                        </div>
                        <div class="col-xs-1" >
                            <p>{!! round($reading->temperature,1) - $previousTemp !!}<span>&#176;</span></p>
                        </div>
                    </div>
                    <?php $previousTemp = round($reading->temperature,1); ?>
                @endforeach
            @else
                <div class="col-xs-8 small-padding" >
                    <h4>{!! Lang::get('general.No Previous Readings Available') !!}</h4>
                </div>
            @endif
        </div>
    </div>
</div>