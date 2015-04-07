@extends('layouts.pet.dashboard')

@section('content')
        
                 
            <div class="row" >
                <div class="col-md-8 col-centered float-none" >
                    <div class="jumbotron text-center" >

                    <div class="form-horizontal ">

                        {{ Form::open(array('files'=> 'true', 'url' => '/pet/dashboard/settings', 'method' => 'post' )) }}
                        
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
                                
                                {{ Form::button('Browse...', array('class' => 'btn btn-file pull-left', 'onclick' => '$("#ufile").click()' )) }}

                                {{ Form::file('image_path', array('class' => 'hide', 'id'=>'ufile')) }}

                                <small class="small-left-buffer">JPEG or PNG 4mb file limit</small>
                            </div>
                        </div>
                        <div class="form-group">

                                {{ Form::label('first_name', 'First name', array('class' => 'col-sm-4 control-label')) }}

                            <div class="col-sm-8">

                                {{ Form::text('first_name', Auth::user()->get()->first_name, array('class' => 'form-control text-left')) }}

                            </div>
                        </div>
                        <div class="form-group">

                                {{ Form::label('last_name', 'Last name', array('class' => 'col-sm-4 control-label')) }}

                            <div class="col-sm-8">

                                {{ Form::text('last_name', Auth::user()->get()->last_name, array('class' => 'form-control text-left')) }}

                            </div>
                        </div>
                        <div class="form-group">

                                {{ Form::label('email_address', 'Email address', array('class' => 'col-sm-4 control-label')) }}

                            <div class="col-sm-8">

                                {{ Form::email('email_address', Auth::user()->get()->email_address, array('class' => 'form-control text-left')) }}

                            </div>
                        </div>
                        <div class="form-group">

                            {{ Form::label('old_password', 'Password', array('class' => 'col-sm-4 control-label')) }}

                            <div class="col-sm-8">


                                {{ Form::password('old_password', array('class' => 'small-top-buffer form-control text-left')) }}

                            </div>
                        </div>
                        <div class="form-group">

                            {{ Form::label('password', 'New password', array('class' => 'col-sm-4 control-label')) }}

                            <div class="col-sm-8">


                                {{ Form::password('password', array('class' => 'small-top-buffer form-control text-left')) }}

                            </div>
                        </div>
                        <div class="form-group">

                            {{ Form::label('password_confirmation', 'Retype password', array('class' => 'col-sm-4 control-label')) }}

                            <div class="col-sm-8">


                                {{ Form::password('password_confirmation', array('class' => 'small-top-buffer form-control text-left')) }}

                            </div>
                        </div>
                                                
                        <div class="form-group">

                                {{ Form::label('units', 'Units', array('class' => 'col-sm-4 control-label')) }}

                            <div class="col-sm-8">

                                <div class="radio-pill-buttons">
                                    <label><input type="radio" @if(Auth::user()->get()->units == 'C') checked @endif name="units" value="C"><span class="pointer" >Celcius</span></label>
                                    <label><input type="radio" @if(Auth::user()->get()->units == 'F') checked @endif name="units" value="F"><span class="pointer" >Fahrenheit</span></label>
                                </div>

                            </div>
                        </div>

                        
                            <div class="form-group top-buffer">
                                <div class="col-sm-12">
                                    <a href="/pet/delete" >
                                    {{ Form::button('Delete account', array('class' => 'btn btn-file btn-lg pull-left border-none')) }}
                                    </a>
                                    {{ Form::submit('Save changes', array('class' => 'btn btn-default btn-lg pull-right')) }}

                                    {{ Form::close() }}

                                </div>
                            </div>
                        
                    </div>

                </div>
            </div>
            <div class="row" >
                <div class="col-md-8 col-centered float-none" >
                    <div class="jumbotron text-center" >
                        <div class="col-md-12 text-left" >
                            <h2 class="top-none">Can't find your vet in our database?</h2>
                            <p>Fill out your vet's email below and we will send them an invitation</p>
                        </div>
                        <div class="form-horizontal">
                            {{ Form::open(array('url' => '/pet/dashboard/invite', 'method' => 'post' )) }}
                            <div class="form-group">
                                {{ Form::label('email_address', 'Email address', array('class' => 'col-sm-4 control-label')) }}
                                <div class="col-sm-5">
                                    {{ Form::email('email_address', '', array('class' => 'form-control text-left')) }}
                                </div>
                                <div class="col-sm-3">
                                    {{ Form::submit('Submit', array('class' => 'btn btn-default btn-lg pull-right')) }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
@stop