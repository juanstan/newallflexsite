@extends('layouts.pet.signup')

@section('content')
    <div class="row" >
        <div class="col-md-8 col-centered float-none" >
            <div class="form-horizontal top-buffer" >

            {{ Form::open(array('files'=> 'true', 'url' => '/pet/register/about', 'method' => 'post' )) }}
                 
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
                
                        {{ Form::label('image_path', Lang::get('general.profilePhoto'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8 text-left">
                        
                        {{ Form::button(Lang::get('general.browse'), array('class' => 'btn btn-file pull-left', 'onclick' => '$("#ufile").click()' )) }}

                        {{ Form::file('image_path', array('class' => 'hide', 'id'=>'ufile')) }}

                        <small class="small-left-buffer">{{ Lang::get('general.imageFileText'); }}</small>
                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('email_address', Lang::get('general.emailAddress'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::email('email_address', Auth::user()->get()->email_address, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('first_name', Lang::get('general.firstName'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('first_name',  Auth::user()->get()->first_name, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('last_name',  Lang::get('general.lastName'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('last_name', Auth::user()->get()->last_name, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('telephone', Lang::get('general.telephoneNumber'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('telephone', Auth::user()->get()->telephone, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" >
        <div class="col-md-10 col-centered" >
            <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-11">

                        {{ Form::submit(Lang::get('general.next'), array('class' => 'btn btn-default btn-lg pull-right')) }}

                        {{ Form::close() }}

                    </div>
                </div>
        </div>
    </div>
@stop