<div  class="tab-pane fade in" id="edit{!! $pet->id !!}">
    <div class="form-horizontal float-none top-buffer col-md-12 col-centered">
        {!! Form::open(array('route' => array('user.dashboard.updatePet', $pet->id), 'method' => 'post', 'id' => 'petSettingsForm' . $pet->id )) !!}
        <div class="form-group">
            {!! Form::label('name', Lang::get('general.Name'), array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::text('name', $pet->name, array('class' => 'form-control text-left')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('breed', Lang::get('general.Breed'), array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                @if($pet->breed_id != '')
                    {!! Form::text('breed_id', $pet->breed->name, array('class' => 'form-control text-left breed-list', 'id' => 'breedList' . $pet->id )) !!}
                @else
                    {!! Form::text('breed_id', $pet->breed_wildcard, array('class' => 'form-control text-left breed-list', 'id' => 'breedList' . $pet->id )) !!}
                @endif
            </div>
        </div>
        <div class="col-xs-12 small-padding" >
            <div class="form-group">
                {!! Form::label('weight', Lang::get('general.Weight'), array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-xs-8">
                    <div class="input-group">
                        @if($user->weight_units == 0)
                            {!! Form::text('weight', $pet->weight, array('class' => 'form-control text-left')) !!}
                        @else
                            {!! Form::text('weight', round($pet->weight * 2.20462, 1), array('class' => 'form-control text-left')) !!}
                        @endif
                        <div class="input-group-addon">@if($user->weight_units == 0) {!! Lang::get('general.kg') !!} @else {!! Lang::get('general.lbs') !!} @endif</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('age', Lang::get('general.Date of birth'), array('class' => 'col-sm-5 control-label')) !!}
            <div class="col-sm-7">
                {!! Form::input('date', 'date_of_birth', isset($pet->date_of_birth)?$pet->date_of_birth:'', array('class' => 'form-control text-left')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('gender', Lang::get('general.Gender'), array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-xs-9">
                <div class="radio-pill-buttons">
                    <label><input type="radio" @if($pet->gender == 1) checked @endif name="gender" value="1"><span class="pointer" >{!! Lang::get('general.Male') !!}</span></label>
                    <label><input type="radio" @if($pet->gender == 0) checked @endif name="gender" value="0"><span class="pointer" >{!! Lang::get('general.Female') !!}</span></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('Known conditions', Lang::get('general.Known conditions'), array('class' => 'col-sm-7 control-label')) !!}
            <div class="col-xs-5">
                <a href="#" class="allconditions" data-toggle="collapse" data-target="#condition-list{!! $pet->id !!}" >
                    {!! Form::button(Lang::get('general.Manage <i class="fa fa-angle-right small-left-buffer"></i>'), array('class' => 'btn btn-file btn-block btn-md')) !!}
                </a>
            </div>
        </div>
        {!! Form::close() !!}
        {!! Form::open(array('route' => array('user.dashboard.resetAverageTemperature', $pet->id), 'method' => 'post')) !!}
        <div class="form-group">
            {!! Form::label('Average temperature', Lang::get('general.Average temperature'), array('class' => 'col-sm-7 control-label')) !!}
            <div class="col-xs-5">
                {!! Form::button(Lang::get('general.<i class="fa fa-refresh"></i> Reset'), array('class' => 'btn btn-file btn-block btn-md', 'type' => 'submit')) !!}
            </div>
        </div>
        {!! Form::close() !!}
        <div class="form-group">
            <div class="col-xs-5" >
                <a href="#" data-toggle="collapse" data-target="#pet-delete{!! $pet->id !!}" >{!! Form::button(Lang::get('general.Remove'), array('class' => 'btn btn-file btn-block btn-md border-none')) !!}</a>
            </div>
            <div class="top-buffer mobile" ></div>
            <div class="col-xs-7" >
                {!! Form::submit(Lang::get('general.Save changes'), array('class' => 'btn btn-block btn-default btn-md', 'form' => 'petSettingsForm' . $pet->id)) !!}
            </div>
        </div>
    </div>
</div>