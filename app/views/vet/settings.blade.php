@extends('layouts.vet.dashboard')

@section('content')
    <link rel="stylesheet" type="text/css" href="http://services.postcodeanywhere.co.uk/css/captureplus-2.30.min.css?key=mz34-mz21-yg64-ug48" />
    <script type="text/javascript" src="http://services.postcodeanywhere.co.uk/js/captureplus-2.30.min.js?key=mz34-mz21-yg64-ug48"></script>
    <div class="row" >
        <div class="col-md-8 col-centered float-none" >
            <div class="jumbotron text-center" >

            <div class="form-horizontal ">

                {{ Form::open(array('files'=> 'true', 'url' => '/vet/dashboard/settings', 'method' => 'post' )) }}

                <div class="form-group">

                    <div class="col-sm-4 text-left">
                    </div>

                    <div class="col-sm-8 text-left">
                        @if (Auth::vet()->get()->image_path != NULL)
                            {{ HTML::image(Auth::vet()->get()->image_path, '', array('class' => 'img-responsive img-circle', 'width' => '30%')) }}
                        @else
                            {{ HTML::image('images/vet-image.png', '', array('class' => 'img-responsive img-circle', 'width' => '30%')) }}
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

                        {{ Form::label('company_name', 'Company name', array('class' => 'col-sm-4 control-label')) }}

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

                        {{ Form::label('email_address', 'Email address', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::email('email_address', Auth::vet()->get()->email_address, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                    {{ Form::label('fax', 'Fax number', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('fax', Auth::vet()->get()->fax, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                    {{ Form::label('telephone', 'Telephone number', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('telephone', Auth::vet()->get()->telephone, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                    {{ Form::label('zip', 'Zip/ postal code', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('zip', Auth::vet()->get()->zip, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                    {{ Form::label('address_1', 'Address line 1', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('address_1', Auth::vet()->get()->address_1, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                    {{ Form::label('address_2', 'Address line 2', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('address_2', Auth::vet()->get()->address_2, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                    {{ Form::label('city', 'City', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('city', Auth::vet()->get()->city, array('class' => 'form-control text-left')) }}

                    </div>
                </div>
                <div class="form-group">

                    {{ Form::label('county', 'County', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        {{ Form::text('county', Auth::vet()->get()->county, array('class' => 'form-control text-left')) }}

                    </div>
                </div>

                <div class="form-group">

                    {{ Form::label('location', 'Location', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        <div id="gmap_canvas" @if(Auth::vet()->get()->latitude != null) style="width:100%; height:15em;" @endif >Loading map...</div>
                        <div id='map-label'>Map shows approximate location.</div>

                    </div>
                </div>
                <div class="form-group">

                    {{ Form::label('units', 'Units', array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">

                        <div class="radio-pill-buttons">
                            <label><input type="radio" @if(Auth::vet()->get()->units == 'C') checked @endif name="units" value="C"><span class="pointer" >Celcius</span></label>
                            <label><input type="radio" @if(Auth::vet()->get()->units == 'F') checked @endif name="units" value="F"><span class="pointer" >Fahrenheit</span></label>
                        </div>

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


                    <div class="form-group top-buffer">
                        <div class="col-sm-12">
                            <a href="/vet/delete" >
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
                    <h2 class="top-none">We can't find your customer in our database?</h2>
                    <p>Fill out your customer's email below and we will send them an invitation</p>
                </div>
                <div class="form-horizontal">
                    {{ Form::open(array('url' => '/vet/dashboard/invite', 'method' => 'post' )) }}
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