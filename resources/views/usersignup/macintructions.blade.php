@extends('layouts.user.signupwithoutmenu')

@section('content')
    <div class="row" >
        <div class="col-md-12 col-centered float-none top-buffer text-left" >
            <div class="toplinkgoback"> <a href="{!! URL::route('user.register.reading') !!}" >< Go Back </a></div>
            <div class="header-instructions">Upload instructions on a Mac</div>
            <div class="steps-instructions row">
                <div class="col-sm-4 col-xs-12">
                    {!! HTML::image('images/1StepMacInstruction.png', 'First Step For Uploading Files in a Window') !!}
                    <span class="stepnumber">1</span>
                    <span class="step-description">Connect the SureSense reader to a spare USB port</span>
                </div>
                <div class="col-sm-4 col-xs-12">
                    {!! HTML::image('images/2StepMacInstruction.png', 'Second Step For Uploading Files in a Window') !!}
                    <span class="stepnumber">2</span>
                    <span class="step-description">Locate the SureSense reader under 'Devices' in Finder</span>
                </div>
                <div class="col-sm-4 col-xs-12">
                    {!! HTML::image('images/3StepMacInstruction.png', 'Third Step For Uploading Files in a Window') !!}
                    <span class="stepnumber">3</span>
                    <span class="step-description">Drag and drop the .csv file where instructed</span>
                </div>
            </div>
        </div>
    </div>
@stop