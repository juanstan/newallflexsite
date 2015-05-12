@extends('layouts.user.dashboard')

@section('content')
        
                 
            <div class="row" >
                <div class="col-md-8 col-centered float-none" >
                    <div class="jumbotron text-center" >

                    <div class="form-horizontal ">

                        {{ Form::open(array('files'=> 'true', 'route' => 'user.dashboard.settings', 'method' => 'post' )) }}
                        
                        <div class="form-group">
                
                            <div class="col-sm-4 text-left">
                            </div>
                        
                            <div class="col-sm-8 text-left">
                                @if (Auth::user()->get()->image_path != NULL)
                                    {{ HTML::image(Auth::user()->get()->image_path, '', array('class' => 'img-responsive img-circle', 'width' => '30%', 'height' => '80px')) }}
                                @endif
                                </div>
                            </div>

                        <div class="form-group">
                
                                {{ Form::label('image_path', 'Profile photo', array('class' => 'col-sm-4 control-label')) }}

                            <div class="col-sm-8 text-left">
                                
                                {{ Form::button(Lang::get('general.Browse'), array('class' => 'btn btn-file pull-left', 'onclick' => '$("#ufile").click()' )) }}

                                {{ Form::file('image_path', array('class' => 'hide', 'id'=>'ufile')) }}

                                <small class="small-left-buffer">{{ Lang::get('general.JPEG or PNG 4mb file limit') }}</small>
                            </div>
                        </div>
                        <div class="form-group">

                                {{ Form::label('first_name', Lang::get('general.First name'), array('class' => 'col-sm-4 control-label')) }}

                            <div class="col-sm-8">

                                {{ Form::text('first_name', Auth::user()->get()->first_name, array('class' => 'form-control text-left')) }}

                            </div>
                        </div>
                        <div class="form-group">

                                {{ Form::label('last_name', Lang::get('general.Last name'), array('class' => 'col-sm-4 control-label')) }}

                            <div class="col-sm-8">

                                {{ Form::text('last_name', Auth::user()->get()->last_name, array('class' => 'form-control text-left')) }}

                            </div>
                        </div>
                        <div class="form-group">

                                {{ Form::label('email_address', Lang::get('general.Email address'), array('class' => 'col-sm-4 control-label')) }}

                            <div class="col-sm-8">

                                {{ Form::email('email_address', Auth::user()->get()->email_address, array('class' => 'form-control text-left')) }}

                            </div>
                        </div>
                        <div class="form-group">

                            {{ Form::label('old_password', Lang::get('general.Password'), array('class' => 'col-sm-4 control-label')) }}

                            <div class="col-sm-8">


                                {{ Form::password('old_password', array('class' => 'small-top-buffer form-control text-left')) }}

                            </div>
                        </div>
                        <div class="form-group">

                            {{ Form::label('password', Lang::get('general.New password'), array('class' => 'col-sm-4 control-label')) }}

                            <div class="col-sm-8">


                                {{ Form::password('password', array('class' => 'small-top-buffer form-control text-left')) }}

                            </div>
                        </div>
                        <div class="form-group">

                            {{ Form::label('password_confirmation', Lang::get('general.Retype password'), array('class' => 'col-sm-4 control-label')) }}

                            <div class="col-sm-8">


                                {{ Form::password('password_confirmation', array('class' => 'small-top-buffer form-control text-left')) }}

                            </div>
                        </div>
                                                
                        <div class="form-group">

                                {{ Form::label('units', Lang::get('general.Units'), array('class' => 'col-sm-4 control-label')) }}

                            <div class="col-sm-8">

                                <div class="radio-pill-buttons">
                                    <label><input type="radio" @if(Auth::user()->get()->units == 'C') checked @endif name="units" value="C"><span class="pointer" >{{ Lang::get('general.Celcius') }}</span></label>
                                    <label><input type="radio" @if(Auth::user()->get()->units == 'F') checked @endif name="units" value="F"><span class="pointer" >{{ Lang::get('general.Fahrenheit') }}</span></label>
                                </div>

                            </div>
                        </div>

                        
                            <div class="form-group top-buffer">
                                <div class="col-sm-12">
                                    <a href="{{ URL::route('user.delete) }}" >
                                        {{ Form::button(Lang::get('general.Delete account'), array('class' => 'btn btn-file btn-lg pull-left border-none')) }}
                                    </a>
                                    {{ Form::submit(Lang::get('general.Save changes'), array('class' => 'btn btn-default btn-lg pull-right')) }}

                                    {{ Form::close() }}

                                </div>
                            </div>
                        
                    </div>

                </div>
            </div>
            <div class="col-md-8 col-centered float-none" >
                <div class="jumbotron text-center" >
                    <div class="col-md-12 text-left" >
                        <div class="top-buffer mobile" ></div>
                        <h2 class="top-none">{{ Lang::get('general.Can&#39;t find your vet in our database?') }}</h2>
                        <p>{{ Lang::get('general.Fill out your vet&#39;s email below and we will send them an invitation') }}</p>
                    </div>
                    <div class="form-horizontal">
                        {{ Form::open(array('route' => 'user.dashboard.invite', 'method' => 'post' )) }}
                        <div class="form-group">
                            {{ Form::label('email_address', Lang::get('general.Email address'), array('class' => 'col-sm-4 control-label')) }}
                            <div class="col-sm-5">
                                {{ Form::email('email_address', '', array('class' => 'form-control text-left')) }}
                            </div>
                            <div class="top-buffer mobile" ></div>
                            <div class="col-sm-3">
                                {{ Form::submit(Lang::get('general.Submit'), array('class' => 'btn btn-default btn-lg pull-right')) }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
@stop