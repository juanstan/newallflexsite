@extends('layouts.user.signup')

@section('content')
    <div class="row" >
        <div class="col-md-12 mobile" >
            <h3>About you</h3>
        </div>
        <div class="col-md-8 col-centered float-none" >
            <div class="form-horizontal top-buffer" >

            {{ Form::open(array('files'=> 'true', 'route' => 'user.register.about', 'method' => 'post' )) }}

                @if (Auth::user()->get()->image_path != NULL)
                <div class="form-group">
                
                    <div class="col-sm-4 text-left">
                    </div>
                    
                    <div class="col-sm-8 text-left">

                        {{ HTML::image(Auth::user()->get()->image_path, '', array('class' => 'img-responsive img-circle', 'width' => '30%', 'height' => '80px')) }}

                    </div>
                </div>
                @endif
                
                <div class="form-group">
                
                        {{ Form::label('image_path',  Lang::get('general.Profile photo'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8 text-left">
                        
                        {{ Form::button('Browse...', array('class' => 'btn btn-file pull-left', 'onclick' => '$("#ufile").click()' )) }}

                        {{ Form::file('image_path', array('class' => 'hide', 'id'=>'ufile')) }}

                        <small class="small-left-buffer">{{ Lang::get('general.JPEG or PNG 4mb file limit'); }}</small>
                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('email_address',  Lang::get('general.Email address'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::email('email_address', Auth::user()->get()->email_address, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('first_name',  Lang::get('general.First name'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('first_name',  Auth::user()->get()->first_name, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('last_name',  Lang::get('general.Last name'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('last_name', Auth::user()->get()->last_name, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('telephone',  Lang::get('general.Telephone Number'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('telephone', Auth::user()->get()->telephone, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                    {{ Form::label('units', Lang::get('general.Temperature unit type'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        <div class="radio-pill-buttons">
                            <label><input type="radio" @if(Auth::user()->get()->units == 'C') checked @endif name="units" value="C"><span class="pointer" >{{ Lang::get('general.Celcius') }}</span></label>
                            <label><input type="radio" @if(Auth::user()->get()->units == 'F') checked @endif name="units" value="F"><span class="pointer" >{{ Lang::get('general.Fahrenheit') }}</span></label>
                        </div>

                    </div>
                </div>
                <div class="form-group">

                    {{ Form::label('weight_units', Lang::get('general.Weight unit type'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        <div class="radio-pill-buttons">
                            <label><input type="radio" @if(Auth::user()->get()->weight_units == 'KG') checked @endif name="weight_units" value="KG"><span class="pointer" >{{ Lang::get('general.Kilograms') }}</span></label>
                            <label><input type="radio" @if(Auth::user()->get()->weight_units == 'LBS') checked @endif name="weight_units" value="LBS"><span class="pointer" >{{ Lang::get('general.Pounds') }}</span></label>
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

                        {{ Form::submit( Lang::get('general.Next'), array('class' => 'btn btn-default btn-lg pull-right')) }}

                        {{ Form::close() }}

                    </div>
                </div>
        </div>
    </div>
    <div class="top-buffer mobile" ></div>
@stop