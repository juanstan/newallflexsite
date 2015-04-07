@extends('layouts.pet.signup')

@section('content')
    <div class="row" >
        <div class="col-md-9 col-centered float-none" >

            <div class="form-horizontal large-top-buffer">
                
                {{ Form::open(array('files'=> 'true', 'url' => '/pet/register/pet/create', 'method' => 'post')) }}
                
                <div class="form-group">
                
                        {{ Form::label('pet-photo', Lang::get('general.Pet&#39;s photo'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8 text-left">

                        {{ Form::button(Lang::get('general.Browse'), array('class' => 'btn btn-file pull-left', 'onclick' => '$("#ufile").click()' )) }}

                        {{ Form::file('pet-photo', array('class' => 'hide', 'id'=>'ufile')) }}
                       

                        <small class="small-left-buffer">{{ Lang::get('general.JPEG or PNG 4mb file limit') }}</small>
                    </div>
                </div>
                
                {{ Form::open(array('url' => '/pet/register/pet/create', 'method' => 'post' )) }}
                
                <div class="form-group">

                        {{ Form::label('name', Lang::get('general.Pet&#39;s name'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('name', '', array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('breed', Lang::get('general.Breed'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('breed', '', array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('date_of_birth', Lang::get('general.Date of birth'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-5">

                        {{ Form::input('date', 'date_of_birth', '', array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('weight', Lang::get('general.Weight'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-4">

                        <div class="input-group">

                            {{ Form::text('weight', '', array('class' => 'form-control text-left')) }}

                            <div class="input-group-addon">{{ Lang::get('general.kg') }}</div>

                        </div>

                    </div>
                </div>

                <div class="form-group">

                        {{ Form::label('gender', Lang::get('general.Gender'), array('class' => 'col-sm-4 control-label')) }}
                        
                    <div class="col-sm-8">
                        <div class="radio-pill-buttons">
                            <label><input type="radio" name="gender" value="Male"><span class="pointer" >{{ Lang::get('general.Male') }}</span></label>
                            <label><input type="radio" name="gender" value="Female"><span class="pointer" >{{ Lang::get('general.Female') }}</span></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">

                        {{ Form::label('size', Lang::get('general.Size'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">
                        
                        <div class="radio-pill-buttons">
                            <label><input type="radio" name="size" value="S"><span class="pointer" >{{ Lang::get('general.Small') }}</span></label>
                            <label><input type="radio" name="size" value="M"><span class="pointer" >{{ Lang::get('general.Medium') }}</span></label>
                            <label><input type="radio" name="size" value="L"><span class="pointer" >{{ Lang::get('general.Large') }}</span></label>
                            <label><input type="radio" name="size" value="XL"><span class="pointer" >{{ Lang::get('general.X-Large') }}</span></label>
                        </div>

                    </div>
                </div>
                
            </div>

        </div>
    </div>
    <div class="row" >
        <div class="col-md-12 col-centered" >
            <div class="form-group">
                    <div class="col-sm-12">
                        
                        <a href="/pet/register/about" >{{ Form::button(Lang::get('general.Back'), array('class' => 'btn btn-file btn-lg pull-left border-none')) }}</a>
                        
                        
                        {{ Form::submit(Lang::get('general.Next'), array('class' => 'btn btn-default btn-lg border-none pull-right')) }}
                        
                        <a href="/pet/register/pet" >{{ Form::button(Lang::get('general.Skip'), array('class' => 'btn btn-file btn-lg pull-right border-none right-buffer')) }}</a>

                        {{ Form::close() }}

                    </div>
                </div>
        </div>
    </div>
@stop