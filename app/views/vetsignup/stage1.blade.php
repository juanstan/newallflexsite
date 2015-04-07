@extends('layouts.vet.signup')

@section('content')
    <div class="row" >
        <div class="col-md-8 col-centered float-none" >
            <div class="form-horizontal large-top-buffer" >

            {{ Form::open(array('files'=> 'true', 'url' => '/vet/register/about', 'method' => 'post' )) }}

                <div class="form-group">

                    <div class="col-sm-4 text-left">
                    </div>

                    <div class="col-sm-8 text-left">
                        @if (Auth::vet()->get()->image_path != NULL)
                            {{ HTML::image(Auth::vet()->get()->image_path, '', array('class' => 'img-responsive img-circle', 'width' => '30%', 'height' => '80px')) }}
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

                        {{ Form::label('company_name', 'Practice name', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('company_name', Auth::vet()->get()->company_name, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                    {{ Form::label('contact_name', 'Contact name', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('contact_name', Auth::vet()->get()->contact_name, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('telephone', 'Telephone No.', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('telephone', Auth::vet()->get()->telephone, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                        {{ Form::label('fax', 'Fax No.', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('fax', Auth::vet()->get()->fax, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" >
        <div class="col-md-10 col-centered" >
            <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-11">

                        {{ Form::submit('Next', array('class' => 'btn btn-default btn-lg pull-right')) }}

                        {{ Form::close() }}

                    </div>
                </div>
        </div>
    </div>
@stop