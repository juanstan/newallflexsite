 @extends('layouts.user.signup')

@section('content')
    <div class="row" >
        <div class="col-md-12 mobile" >
            <h3>About you</h3>
        </div>
        <div class="col-md-8 col-centered float-none" >
            <div class="form-horizontal top-buffer" >
            {!! Form::open(array('files'=> 'true', 'route' => 'user.register.about', 'method' => 'post' )) !!}
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8 text-left">
                        {!! HTML::image(isset($user->photo_id) ? $user->photo->location:'/images/grey-circle.png', '', array('class' => 'image-placeholder img-responsive img-centered img-circle', 'width' => '100px')) !!}
                    </div>
                </div>
                <div class="form-group">
                        {!! Form::label('image_path',  Lang::get('general.Profile photo'), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8 text-left">
                        {!! Form::button('Browse...', array('class' => 'btn btn-file pull-left', 'onclick' => '$("#ufile").click()' )) !!}
                        {!! Form::file('image_path', array('class' => 'hide', 'id'=>'ufile', 'onchange' => 'readURL(this);')) !!}
                        <small class="small-left-buffer">{!! Lang::get('general.JPEG or PNG 4mb file limit') !!}</small>
                    </div>
                </div>
                <div class="form-group" >
                        {!! Form::label('email',  Lang::get('general.Email address'), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::email('email', $user->email, array('class' => 'form-control text-left')) !!}
                    </div>
                </div>
                <div class="form-group">
                        {!! Form::label('first_name',  Lang::get('general.First name'), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('first_name', $user->first_name, array('class' => 'form-control text-left')) !!}
                    </div>
                </div>
                <div class="form-group">
                        {!! Form::label('last_name',  Lang::get('general.Last name'), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('last_name', $user->last_name, array('class' => 'form-control text-left')) !!}
                    </div>
                </div>
                <div class="form-group">
                        {!! Form::label('telephone',  Lang::get('general.Telephone Number'), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('telephone', $user->telephone, array('class' => 'form-control text-left')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('units', Lang::get('general.Temperature unit type'), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="radio-pill-buttons">
                            <label><input type="radio" @if($user->units == 0) checked @endif name="units" value="0"><span class="pointer">{!! Lang::get('general.Celcius') !!}</span></label>
                            <label><input type="radio" @if($user->units == 1) checked @endif name="units" value="1"><span class="pointer">{!! Lang::get('general.Fahrenheit') !!}</span></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('weight_units', Lang::get('general.Weight unit type'), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="radio-pill-buttons">
                            <label><input type="radio" @if($user->weight_units == 0) checked @endif name="weight_units" value="0"><span class="pointer" >{!! Lang::get('general.Kilograms') !!}</span></label>
                            <label><input type="radio" @if($user->weight_units == 1) checked @endif name="weight_units" value="1"><span class="pointer" >{!! Lang::get('general.Pounds') !!}</span></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" >
        <div class="col-md-10 col-centered" >
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-11">
                    {!! Form::submit( Lang::get('general.Next'), array('class' => 'btn btn-default btn-lg pull-right')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="top-buffer mobile" ></div>
@stop