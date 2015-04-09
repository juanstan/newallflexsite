@extends('layouts.signup')

@section('content')
    <div class="row large-top-buffer" >
        <div class="col-md-6 col-centered float-none" >
            <div class="jumbotron text-center" >

                {{ HTML::image('images/logo-vet.png', 'a Logo', array('class' => 'signup-logo')) }}
                <h2>{{ Lang::get('general.Sign in to Vet Connect') }}</h2>

                <ul class="nav mobile desktop nav-pills top-buffer">
                    <li>{{ HTML::link('pet/', Lang::get('general.Pet owner')) }}</li>
                    <li class="active" >{{ HTML::link('vet/', Lang::get('general.Vet practice')) }}</li>
                </ul>

                        {{ Form::open(array('url' => 'vet/login', 'method' => 'post', 'class' => 'top-buffer')) }}

                        {{  Form::text('email_address', '', array('class' => 'form-control', 'placeholder' => 'Email address')) }}

                        {{ Form::password('password', array('class' => 'small-top-buffer form-control', 'placeholder' => 'Password')) }}

                        {{ Form::submit(Lang::get('general.Sign in'), array('class' => 'btn btn-lg btn-default btn-block small-top-buffer')) }}

                        {{ Form::close() }}

                    <p class="top-buffer">{{ Lang::get('general.Don&#39;t have an account?') }} <strong>{{ HTML::link('vet/register', Lang::get('general.Sign up')) }}</strong>
            </div>
        </div>
    </div>
@stop