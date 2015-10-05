@extends('layouts.vet.dashboard')

@section('content')
    <link rel="stylesheet" type="text/css" href="http://services.postcodeanywhere.co.uk/css/captureplus-2.30.min.css?key=mz34-mz21-yg64-ug48" />
    <script type="text/javascript" src="http://services.postcodeanywhere.co.uk/js/captureplus-2.30.min.js?key=mz34-mz21-yg64-ug48"></script>
    <div class="row" >
        <div class="col-md-8 col-centered float-none" >
            <div class="jumbotron text-center" >

            <div class="form-horizontal ">

                {!! Form::open(array('files'=> 'true', 'route' => 'vet.dashboard.settings', 'method' => 'post' )) !!}

                <div class="form-group">

                    <div class="col-sm-4 text-left">
                    </div>

                    <div class="col-sm-8 text-left">
                        @if (Auth::vet()->get()->image_path != NULL)
                            {!! HTML::image(Auth::vet()->get()->image_path, '', array('class' => 'img-responsive img-circle', 'width' => '30%')) !!}
                        @else
                            {!! HTML::image('images/vet-image.png', '', array('class' => 'img-responsive img-circle', 'width' => '30%')) !!}
                        @endif
                    </div>
                </div>

                <div class="form-group">

                    {!! Form::label('image_path', 'Profile photo', array('class' => 'col-sm-4 control-label')) !!}

                    <div class="col-sm-8 text-left">

                        {!! Form::button(Lang::get('general.Browse'), array('class' => 'btn btn-file pull-left', 'onclick' => '$("#ufile").click()' )) !!}

                        {!! Form::file('image_path', array('class' => 'hide', 'id'=>'ufile')) !!}

                        <small class="small-left-buffer">{!! Lang::get('general.JPEG or PNG 4mb file limit') !!}</small>
                    </div>
                </div>
                <div class="form-group">

                        {!! Form::label('company_name', Lang::get('general.Company name'), array('class' => 'col-sm-4 control-label')) !!}

                    <div class="col-sm-8">

                        {!! Form::text('company_name', Auth::vet()->get()->company_name, array('class' => 'form-control text-left')) !!}

                    </div>
                </div>
                <div class="form-group">

                        {!! Form::label('contact_name', Lang::get('general.Contact name'), array('class' => 'col-sm-4 control-label')) !!}

                    <div class="col-sm-8">

                        {!! Form::text('contact_name', Auth::vet()->get()->contact_name, array('class' => 'form-control text-left')) !!}

                    </div>
                </div>
                <div class="form-group">

                        {!! Form::label('email', Lang::get('general.Email address'), array('class' => 'col-sm-4 control-label')) !!}

                    <div class="col-sm-8">

                        {!! Form::email('email', Auth::vet()->get()->email, array('class' => 'form-control text-left')) !!}

                    </div>
                </div>
                <div class="form-group">

                    {!! Form::label('fax', Lang::get('general.Fax number'), array('class' => 'col-sm-4 control-label')) !!}

                    <div class="col-sm-8">

                        {!! Form::text('fax', Auth::vet()->get()->fax, array('class' => 'form-control text-left')) !!}

                    </div>
                </div>
                <div class="form-group">

                    {!! Form::label('telephone', Lang::get('general.Telephone number'), array('class' => 'col-sm-4 control-label')) !!}

                    <div class="col-sm-8">

                        {!! Form::text('telephone', Auth::vet()->get()->telephone, array('class' => 'form-control text-left')) !!}

                    </div>
                </div>
                <div class="form-group">

                    {!! Form::label('zip', Lang::get('general.Zip/ postal code'), array('class' => 'col-sm-4 control-label')) !!}

                    <div class="col-sm-8">

                        {!! Form::text('zip', Auth::vet()->get()->zip, array('class' => 'form-control text-left')) !!}

                    </div>
                </div>
                <div class="form-group">

                    {!! Form::label('address_1', Lang::get('general.Address line 1'), array('class' => 'col-sm-4 control-label')) !!}

                    <div class="col-sm-8">

                        {!! Form::text('address_1', Auth::vet()->get()->address_1, array('class' => 'form-control text-left')) !!}

                    </div>
                </div>
                <div class="form-group">

                    {!! Form::label('address_2', Lang::get('general.Address line 2'), array('class' => 'col-sm-4 control-label')) !!}

                    <div class="col-sm-8">

                        {!! Form::text('address_2', Auth::vet()->get()->address_2, array('class' => 'form-control text-left')) !!}

                    </div>
                </div>
                <div class="form-group">

                    {!! Form::label('city', Lang::get('general.City'), array('class' => 'col-sm-4 control-label')) !!}

                    <div class="col-sm-8">

                        {!! Form::text('city', Auth::vet()->get()->city, array('class' => 'form-control text-left')) !!}

                    </div>
                </div>
                <div class="form-group">

                    {!! Form::label('county', Lang::get('general.County'), array('class' => 'col-sm-4 control-label')) !!}

                    <div class="col-sm-8">

                        {!! Form::text('county', Auth::vet()->get()->county, array('class' => 'form-control text-left')) !!}

                    </div>
                </div>

                <div class="form-group">

                    {!! Form::label('location', Lang::get('general.Location'), array('class' => 'col-sm-4 control-label')) !!}

                    <div class="col-sm-8">

                        <div id="gmap_canvas" @if(Auth::vet()->get()->latitude != null) style="width:100%; height:15em;" @endif >{!! Lang::get('general.Loading map') !!}...</div>
                        <div id='map-label'>{!! Lang::get('general.Map shows approximate location') !!}.</div>

                    </div>
                </div>
                <div class="form-group">

                    {!! Form::label('units', Lang::get('general.Units'), array('class' => 'col-sm-4 control-label')) !!}

                    <div class="col-sm-8">

                        <div class="radio-pill-buttons">
                            <label><input type="radio" @if(Auth::vet()->get()->units == 0) checked @endif name="units" value="C"><span class="pointer" >{!! Lang::get('general.Celcius') !!}</span></label>
                            <label><input type="radio" @if(Auth::vet()->get()->units == 1) checked @endif name="units" value="F"><span class="pointer" >{!! Lang::get('general.Fahrenheit') !!}</span></label>
                        </div>

                    </div>
                </div>
                <div class="form-group">

                        {!! Form::label('old_password', Lang::get('general.Password'), array('class' => 'col-sm-4 control-label')) !!}

                    <div class="col-sm-8">


                        {!! Form::password('old_password', array('class' => 'small-top-buffer form-control text-left')) !!}

                    </div>
                </div>
                <div class="form-group">

                        {!! Form::label('password', Lang::get('general.New password'), array('class' => 'col-sm-4 control-label')) !!}

                    <div class="col-sm-8">


                        {!! Form::password('password', array('class' => 'small-top-buffer form-control text-left')) !!}

                    </div>
                </div>
                <div class="form-group">

                        {!! Form::label('password_confirmation', Lang::get('general.Retype password'), array('class' => 'col-sm-4 control-label')) !!}

                    <div class="col-sm-8">


                        {!! Form::password('password_confirmation', array('class' => 'small-top-buffer form-control text-left')) !!}

                    </div>
                </div>


                    <div class="form-group top-buffer">
                        <div class="col-sm-12">
                            <a href="{!! URL::route('vet.delete') !!}" >
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
                <div class="top-buffer mobile" ></div>
                <div class="col-md-12 text-left" >
                    <h2 class="top-none">{!! Lang::get('general.Can&#39;t find your customer in our database?') !!}</h2>
                    <p>{!! Lang::get('general.Fill out your customer&#39;s email below and we will send them an invitation') !!}</p>
                </div>
                <div class="form-horizontal">
                    {!! Form::open(array('route' => 'vet.dashboard.invite', 'method' => 'post' )) !!}
                    <div class="form-group">
                        {!! Form::label('email', Lang::get('general.Email address'), array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-5">
                            {!! Form::email('email', '', array('class' => 'form-control text-left')) !!}
                        </div>
                        <div class="top-buffer mobile" ></div>
                        <div class="col-sm-3">
                            {!! Form::submit(Lang::get('general.Submit'), array('class' => 'btn btn-default btn-lg pull-right')) !!}
                        </div>
                    </div>
                </div>
            </div>
    </div>
@stop