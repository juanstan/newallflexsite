@extends('layouts.signup')

@section('content')
    <div class="row large-top-buffer" >
        <div class="col-md-6 col-centered float-none" >
            <div class="jumbotron text-center" >

                {{ HTML::image('images/logo-vet.png', 'a Logo', array('class' => 'signup-logo')) }}
                <h2>{{ trans('vetconnect.signinto') }}</h2>

                <ul class="nav nav-pills top-buffer">
                    <li>{{ HTML::link('pet/', 'Pet owner') }}</li>
                    <li class="active" >{{ HTML::link('vet/', 'Vet practice') }}</li>
                </ul>

                        {{ Form::open(array('url' => 'vet/login', 'method' => 'post', 'class' => 'top-buffer')) }}

                        {{  Form::text('email_address', '', array('class' => 'form-control', 'placeholder' => 'Email address')) }}

                        {{ Form::password('password', array('class' => 'small-top-buffer form-control', 'placeholder' => 'Password')) }}

                        {{ Form::submit('Sign in', array('class' => 'btn btn-lg btn-default btn-block small-top-buffer')) }}

                        {{ Form::close() }}

                    <p class="top-buffer">Don't have an account? <strong>{{ HTML::link('vet/register', 'Sign up') }}</strong>
            </div>
        </div>
    </div>
@stop