@extends('layouts.user.dashboard')

@section('content')
<div class="col-md-8 col-centered float-none" >
    <div class="jumbotron text-center" >
        <div class="form-horizontal ">
            {!! Form::open(array('files'=> 'true', 'route' => 'user.dashboard.settings', 'method' => 'post' )) !!}
            @if(isset($user->provider))
                <div class="col-md-12 text-center" >
                    <h4><i class="fa fa-exclamation-circle"></i> {!! Lang::get('general.Log into your') . ' ' . $user->provider . ' ' . Lang::get('general. account to update your account details') !!} <i class="fa fa-exclamation-circle"></i></h4>
                </div>
            @endif
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8 text-left">
                    {!! HTML::image(isset($user->photo_id)?$user->photo->location:'/images/grey-circle.png', '', array('class' => 'image-placeholder img-responsive img-centered img-circle')) !!}
                </div>
            </div>
            <div class="form-group">
                    {!! Form::label('image_path', 'Profile photo', array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8 text-left">
                    @if(isset($user->provider))
                        {!! Form::button(Lang::get('general.Browse'), array('class' => 'btn btn-file pull-left disabled')) !!}
                    @else
                        {!! Form::button(Lang::get('general.Browse'), array('class' => 'btn btn-file pull-left', 'onclick' => '$("#ufile").click()' )) !!}
                        {!! Form::file('image_path', array('class' => 'hide', 'id'=>'ufile')) !!}
                    @endif
                    <small class="small-left-buffer browse-tag">{!! Lang::get('general.JPEG or PNG 4mb file limit') !!}</small>
                </div>
            </div>
            <div class="form-group">
                    {!! Form::label('first_name', Lang::get('general.First name'), array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::text('last_name', $user->first_name, $user->provider ? array('class' => 'form-control text-left', 'disabled' => 'true') : array('class' => 'form-control  text-left')) !!}
                </div>
            </div>
            <div class="form-group">
                    {!! Form::label('last_name', Lang::get('general.Last name'), array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::text('last_name', $user->first_name, $user->provider ? array('class' => 'form-control text-left', 'disabled' => 'true') : array('class' => 'form-control  text-left')) !!}
                </div>
            </div>
            <div class="form-group">
                    {!! Form::label('email', Lang::get('general.Email address'), array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::email('email', $user->email, $user->provider ? array('class' => 'form-control text-left', 'disabled' => 'true') : array('class' => 'form-control  text-left')) !!}
                </div>
            </div>
            @if(!isset($user->provider))
            <div class="form-group">
                {!! Form::label('old_password', Lang::get('general.Password'), array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::password('old_password', array('class' => 'form-control text-left')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('password', Lang::get('general.New password'), array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::password('password', array('class' => 'form-control text-left')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('password_confirmation', Lang::get('general.Retype password'), array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::password('password_confirmation', array('class' => 'form-control text-left')) !!}
                </div>
            </div>
            @endif
            <div class="form-group">
                {!! Form::label('units', Lang::get('general.Temperature units'), array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    <div class="radio-pill-buttons">
                        <label><input type="radio" @if($user->units == 0) checked @endif name="units" value="0"><span class="pointer" >{!! Lang::get('general.Celcius') !!}</span></label>
                        <label><input type="radio" @if($user->units == 1) checked @endif name="units" value="1"><span class="pointer" >{!! Lang::get('general.Fahrenheit') !!}</span></label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('weight_units', Lang::get('general.Weight units'), array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    <div class="radio-pill-buttons">
                        <label><input type="radio" @if($user->weight_units == 0) checked @endif name="weight_units" value="0"><span class="pointer" >{!! Lang::get('general.Kilograms') !!}</span></label>
                        <label><input type="radio" @if($user->weight_units == 1) checked @endif name="weight_units" value="1"><span class="pointer" >{!! Lang::get('general.Pounds') !!}</span></label>
                    </div>
                </div>
            </div>
            <div class="form-group top-buffer">
                <div class="col-sm-12">
                    <a href="{!! URL::route('user.delete') !!}" >
                        {!! Form::button(Lang::get('general.Delete account'), array('class' => 'btn btn-file btn-lg pull-left border-none')) !!}
                    </a>
                    {!! Form::submit(Lang::get('general.Save changes'), array('class' => 'btn btn-default btn-lg pull-right')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-8 col-centered float-none" >
    <div class="jumbotron text-center" >
        <div class="col-md-12 text-left" >
            <div class="top-buffer mobile" ></div>
            <h2 class="top-none removemarginlaterals15">{!! Lang::get('general.Can&#39;t find your vet in our database?') !!}</h2>
            <p class="removemarginlaterals15">{!! Lang::get('general.Fill out your vet&#39;s email below and we will send them an invitation') !!}</p>
        </div>
        <div class="form-horizontal col-md-12">
            {!! Form::open(array('route' => 'user.dashboard.invite', 'method' => 'post' )) !!}
            <div class="form-group">
                <div class="col-sm-3 npaddingleft npaddingright">
                {!! Form::label('email', Lang::get('general.Email address'), array('class' => 'col-sm-12 control-label npaddingleft npaddingright')) !!}
                </div>
                <div class="col-sm-6 npaddingleft">
                    {!! Form::email('email', '', array('class' => 'form-control text-left')) !!}
                </div>
                <div class="top-buffer mobile" ></div>
                <div class="col-sm-3">
                    {!! Form::submit(Lang::get('general.Submit'), array('class' => 'btn btn-default btn-lg pull-right paddingheight5px')) !!}
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
@stop