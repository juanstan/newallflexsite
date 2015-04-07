@extends('layouts.pet.signup')

@section('content')
    <div class="row" >
        <div class="col-md-9 col-centered float-none" >

            <div class="form-horizontal large-top-buffer">
                
                {{ Form::open(array('files'=> 'true', 'url' => '/pet/register/pet/create', 'method' => 'post')) }}
                
                <div class="form-group">
                
                        {{ Form::label('pet-photo', 'Pet&#39;s photo', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8 text-left">

                        {{ Form::button('Browse...', array('class' => 'btn btn-file pull-left', 'onclick' => '$("#ufile").click()' )) }}

                        {{ Form::file('pet-photo', array('class' => 'hide', 'id'=>'ufile')) }}
                       

                        <small class="small-left-buffer">JPEG or PNG 4mb file limit</small>
                    </div>
                </div>
                
                {{ Form::open(array('url' => '/pet/register/pet/create', 'method' => 'post' )) }}
                
                <div class="form-group">

                        {{ Form::label('name', 'Pet&#39;s name', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('name', '', array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('breed', 'Breed', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('breed', '', array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('date_of_birth', 'Date of birth', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-5">

                        {{ Form::input('date', 'date_of_birth', '', array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                {{--<div class="form-group">--}}

                        {{--{{ Form::label('Known conditions', 'conditions', array('class' => 'col-sm-4 control-label')) }}--}}

                    {{--<div class="col-sm-8">--}}

                        {{----}}

                        {{--{{ Form::select('conditions', array('1' => 'first-condition', '2' => 'second-condition'), null, array('class' => 'form-control')) }}--}}

                    {{--</div>--}}
                {{--</div>--}}
                <div class="form-group">

                        {{ Form::label('weight', 'Weight', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-4">

                        <div class="input-group">

                            {{ Form::text('weight', '', array('class' => 'form-control text-left')) }}

                            <div class="input-group-addon">kg</div>

                        </div>

                    </div>
                </div>

                <div class="form-group">

                        {{ Form::label('gender', 'Gender', array('class' => 'col-sm-4 control-label')) }}
                        
                    <div class="col-sm-8">
                        <div class="radio-pill-buttons">
                            <label><input type="radio" name="gender" value="Male"><span class="pointer" >Male</span></label>
                            <label><input type="radio" name="gender" value="Female"><span class="pointer" >Female</span></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">

                        {{ Form::label('size', 'Size', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">
                        
                        <div class="radio-pill-buttons">
                            <label><input type="radio" name="size" value="S"><span class="pointer" >Small</span></label>
                            <label><input type="radio" name="size" value="M"><span class="pointer" >Medium</span></label>
                            <label><input type="radio" name="size" value="L"><span class="pointer" >Large</span></label>
                            <label><input type="radio" name="size" value="XL"><span class="pointer" >X-Large</span></label> 
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
                        
                        <a href="/pet/register/about" >{{ Form::button('Back', array('class' => 'btn btn-file btn-lg pull-left border-none')) }}</a>
                        
                        
                        {{ Form::submit('Next', array('class' => 'btn btn-default btn-lg border-none pull-right')) }}
                        
                        <a href="/pet/register/pet" >{{ Form::button('Skip', array('class' => 'btn btn-file btn-lg pull-right border-none right-buffer')) }}</a>

                        {{ Form::close() }}

                    </div>
                </div>
        </div>
    </div>
@stop