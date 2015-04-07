@extends('layouts.signup')

@section('content')
    <div class="row large-top-buffer" >
        <div class="col-md-6 col-centered float-none" >
            <div class="jumbotron text-center" >
                {{ HTML::image('images/logo-pet.png', 'a Logo', array('class' => 'signup-logo')) }}
                <h2>{{ trans('petconnect.signinto') }}</h2>

                <ul class="nav nav-pills top-buffer">
                    <li class="active">{{ HTML::link('pet/', 'Pet owner') }}</li>
                    <li>{{ HTML::link('vet/', 'Vet practice') }}</li>
                </ul>
                    {{ Form::open(array('url' => 'pet/login', 'method' => 'post', 'class' => 'top-buffer')) }}

                    {{  Form::text('email_address', Input::old('email_address'), array('class' => 'form-control', 'placeholder' => 'Email address')) }}

                    {{ Form::password('password', array('class' => 'small-top-buffer form-control', 'placeholder' => 'Password')) }}

                    {{ Form::submit('Sign in', array('class' => 'btn btn-lg btn-default btn-block small-top-buffer')) }}

                    {{ Form::close() }}

                    <h4>or</h4>

                    {{ Form::open(array('url' => '/pet/login/fb', 'method' => 'get')) }}

                    {{ Form::submit('Sign in with Facebook', array('class' => 'btn btn-lg btn-primary btn-block small-top-buffer')) }}

                    {{ Form::close() }}

                    {{ Form::open(array('url' => '/pet/login/twitter', 'method' => 'get')) }}

                    {{ Form::submit('Sign in with Twitter', array('class' => 'btn btn-lg btn-info btn-block small-top-buffer')) }}

                    {{ Form::close() }}

                    <p class="top-buffer">Don't have an account? <strong>{{ HTML::link('pet/register', 'Sign up') }}</strong>
            </div>
        </div>
    </div>
@stop