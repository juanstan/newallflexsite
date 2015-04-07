@extends('layouts.signup')

@section('content')
    <div class="row large-top-buffer" >
        <div class="col-md-6 col-centered float-none" >
            <div class="jumbotron text-center" >
                {{ HTML::image('images/logo-vet.png', 'a Logo', array('class' => 'signup-logo')) }}
                <h2>{{ Lang::get('general.Sign up to Vet Connect') }}</h2>
                <ul class="nav nav-pills top-buffer">
                    <li>{{ HTML::link('pet/', Lang::get('general.Pet owner')) }}</li>
                    <li class="active" >{{ HTML::link('vet/', Lang::get('general.Vet practice')) }}</li>
                </ul>
                    {{ Form::open(array('url' => 'vet/create', 'method' => 'post', 'class' => 'top-buffer')) }}

                    {{  Form::text('email_address', '', array('class' => 'form-control', 'placeholder' => 'Email address')) }}

                    {{ Form::password('password', array('class' => 'small-top-buffer form-control', 'placeholder' => 'Create Password')) }}

                    {{ Form::password('password_confirmation', array('class' => 'small-top-buffer form-control', 'placeholder' => 'Confirm Password')) }}

                    {{ Form::submit(Lang::get('general.Create account'), array('class' => 'btn btn-lg btn-default btn-block small-top-buffer')) }}

                    {{ Form::close() }}
                <p class="top-buffer">{{ Lang::get('general.Already have an account?') }} <strong>{{ HTML::link('vet/', Lang::get('general.Sign in')) }}</strong>
            </div>
        </div>
    </div>
@stop