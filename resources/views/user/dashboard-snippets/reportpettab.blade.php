<div class="tab-pane fade in" id="reports{!! $pet->id !!}">
    <div class="row top-buffer dash-scrollable col-xs-12 col-centered" >
        @if( $pet->readings->count() )
            @foreach ($pet->readings->slice(0, 1) as $reading)
                <div class="row hero-banner" >
                    <div class="col-xs-12 " >
                        @if(!empty($allReadingTemps))
                            <h4 class="top-buffer" style="color: white;">{!! isset($pet->name) ? $pet->name : 'Unknown' !!}{!! Lang::get('general.&#39;s average temperature is') !!} {!! getTemperatureColor($readingAverage, $temperaturePref)['temp'] !!}&#176;</h4>
                        @else
                            <h4 class="top-buffer" style="color: white;">{!! Lang::get('general.There is not average temperature for') !!} {!! isset($pet->name) ? $pet->name : 'Unknown' !!} {!! Lang::get('general.yet') !!}</h4>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="row hero-banner" >
                <div class="col-xs-12" >
                    <h4 class="top-buffer" style="color: white;">{!! Lang::get('general.No readings have been uploaded for') !!} {!! isset($pet->name) ? $pet->name : 'Unknown'; !!} {!! Lang::get('general.yet') !!}.</h4>
                </div>
            </div>
        @endif
    </div>

     <div class="row col-xs-12 col-centered history-info" >
        @if( $pet->readings->count() )
            <?php $previousTemp = 0; $previous_time=false; ?>
            @foreach ($pet->readings as $reading)
                @if ($previous_time != $reading->reading_time->day)
                    <!--DATE -->
                    <div class="row text-left date-history" >
                        <div class="col-xs-12" >
                            <h4>
                                @if($reading->reading_time->isToday())
                                    Today
                                @elseif($reading->reading_time->isYesterday())
                                    Yesterday
                                @else
                                    {!! $reading->reading_time->format('l jS \\of F Y') !!}
                                @endif
                            </h4>
                        </div>
                    </div>
                @endif
                <?php $previous_time = $reading->reading_time->day;?>
                <!-- DEGREE -->
                <div class="row text-left history" >
                    <div class="col-xs-3 small-padding degree-history" >
                        <div class="circle circle-small-border" style="border-color: {!! getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] !!}">
                            <div class="circle-inner">
                                <div class="history-score-text" style="color: {!! getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] !!}">
                                    {!! getTemperatureColor($reading->temperature, $temperaturePref)['temp'] !!}<span>&#176;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- SYMPTOMS -->
                    <div class="col-xs-7 text-left symptoms-history" >
                        @if( $reading->symptoms->count() )
                            <ul class="nav nav-pills text-center symptom-pills">
                                @foreach ($reading->symptoms as $readingSymptom)
                                    <li role="presentation" class="small-top-buffer active"><a class="" href="#"><small>{!! $readingSymptom->name !!}</small></a></li>
                                @endforeach
                            </ul>
                        @else
                            {!! Lang::get('general.No symptoms added') !!}
                        @endif
                            <!-- Adding more symptoms -->
                        @if ($reading->reading_time->diffInHours(Carbon\Carbon::now('Europe/London')) < 24)
                                <a href="#" class="add-symptom-history" data-toggle="collapse" data-target="#symptom-list{!! $pet->id !!}" >{!! Lang::get('general.Add symptoms') !!}</a>
                        @endif
                    </div>

                    <!-- TIME -->
                    <div class="col-xs-2 time-history nopadding" >{!! $reading->reading_time->format('g.i a')  !!}</div>
                </div>
            @endforeach
        @endif
    </div>
</div>