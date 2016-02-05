<div class="tab-content ">
    <div class="tab-pane latest-list-wrap @if(!$pet->name && !$petNoMicrochips->isEmpty()) select-pet-microchip @endif active fade in" id="latest{!! $pet->id !!}">
        <div class="row col-xs-12 col-centered float-none top-buffer" >
            @foreach ($pet->readings as $reading)
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
            @if( $pet->readings->count() )
                @foreach ($pet->readings->slice(0, 1) as $reading)
                    <div class="circle circle-border"  style="border-color: {!! getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] !!}">
                        <div class="small-circle circle-solid" style="background-color: {!! getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] !!}" >
                            <div class="circle-inner">
                                <div class="small-score-text center-block">
                                    <p>{!! Lang::get('general.Avg') !!}.</p>
                                    @if(!empty($allReadingTemps))
                                        {!! getTemperatureColor($readingAverage, $temperaturePref)['temp'] !!}<span  class="tempsymbol">&#176;</span>
                                    @else
                                        --.-<span>&#176;</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="circle-inner">
                            <div class="score-text center-block" style="color: {!! getTemperatureColor($reading->temperature, $temperaturePref)['tempcol'] !!}" >
                                <span class="temp">{!! getTemperatureColor($reading->temperature, $temperaturePref)['temp'] !!}</span>
                                <span  class="tempsymbol">&#176;</span>
                                <div class="clearfix"></div>
                                <p>
                                    @if(date("d/m/y",strtotime($reading->reading_time)) == date("d/m/y"))
                                        {!! Lang::get('general.today at') !!} {!! date("h.ia",strtotime($reading->reading_time)) !!}
                                    @else
                                        {!! date("d/m/y",strtotime($reading->reading_time)) !!} {!! Lang::get('general.at') !!} {!! date("h.ia",strtotime($reading->reading_time)) !!}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="circle circle-border" >
                    <div class="small-circle circle-solid" >
                        <div class="circle-inner">
                            <div class="small-score-text center-block">
                                <p>Avg.</p>
                                --.-<span>&#176;</span>
                            </div>
                        </div>
                    </div>
                    <div class="circle-inner">
                        <div class="score-text center-block" >
                            <span class="temp">--.-</span><span class="tempsymbol">&#176;</span>
                            <p>{!! Lang::get('general.No readings') !!}</p>
                        </div>
                    </div>
                </div>
            @endif

            @include('user.dashboard-snippets.assignblock')

        </div>
    </div>

    @include('user.dashboard-snippets.reportpettab')

    @include('user.dashboard-snippets.editpettab')

</div>