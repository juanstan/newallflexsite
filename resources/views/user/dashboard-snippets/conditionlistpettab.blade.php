<div class="collapse vet-overlay fade" id="condition-list{!! $pet->id !!}" >
    {!! Form::open(array('files'=> 'true', 'route' => array('user.dashboard.addConditions', $pet->id), 'method' => 'post')) !!}
    <div class="col-xs-12 top-buffer" >
        <div class="col-xs-8" >
            <h3 class="top-none">{!! Lang::get('general.Add conditions') !!}</h3>
            <p>{!! Lang::get('general.Select all that apply') !!}</p>
        </div>

        <div class="col-xs-4 text-right" >
            {!! Form::submit(Lang::get('general.Done'), array('class' => 'submit-text')) !!}
        </div>
    </div>
    <div class="col-xs-12" >
        <div class="conditions-wrapper">
            <?php $conditionItems= $pet->conditions->lists('name')->toArray();?>
            @foreach ($conditions as $condition)
                <div class="condition" >
                    <input type="checkbox" id="{{$condition->name.$pet->id}}" name="conditions[]" @if( !empty($conditionItems) && in_array($condition->name, $conditionItems)) checked @endif value="{!! $condition->id !!}" autocomplete="off">
                    <label for="{{$condition->name.$pet->id}}" class="@if( !empty($conditionItems) && in_array($condition->name, $conditionItems)) active  @endif">
                        <span class="choice-text"> {!! $condition->name !!} </span>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    {!! Form::close() !!}
</div>