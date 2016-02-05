@if ($reading = $pet->readings->first())
    <div class="collapse vet-overlay fade" id="symptom-list{!! $pet->id !!}" >
        {!! Form::open(array('files'=> 'true', 'route' => array('user.dashboard.addSymptoms', $reading->id), 'method' => 'post')) !!}
        <div class="col-xs-12 top-buffer" >
            <div class="col-xs-8" >
                <h3 class="top-none">{!! Lang::get('general.Add symptoms') !!}</h3>
                <p>{!! Lang::get('general.Select all that apply') !!}</p>
            </div>
            <div class="col-xs-4 text-right" >
                {!! Form::submit(Lang::get('general.Done'), array('class' => 'submit-text')) !!}
            </div>
        </div>
        <div class="col-xs-12" >
            <div class="symptoms-wrapper">
                <?php $symptomItems= $reading->symptoms->lists('name')->toArray();?>
                @foreach ($symptoms as $symptom)
                    <div class="symptom">
                        <input type="checkbox" id="{{$symptom->name.$pet->id}}" name="symptoms[]" @if( !empty($symptomItems) && in_array($symptom->name, $symptomItems)) checked @endif value="{!! $symptom->id !!}" autocomplete="off">
                        <label for="{{$symptom->name.$pet->id}}" class="@if( !empty($symptomItems) && in_array($symptom->name, $symptomItems)) active  @endif">
                            <span class="choice-text"> {!! $symptom->name !!} </span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endif