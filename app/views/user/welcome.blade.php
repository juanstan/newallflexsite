@extends('layouts.signup')

@section('content')
    <div class="row large-top-buffer" >
        <div class="col-md-6 col-centered float-none" >
            <div class="jumbotron text-center" >
                {{ HTML::image('images/logo-pet.png', 'a Logo', array('class' => 'signup-logo')) }}
                <h2>{{ Lang::get('general.Sign in to Pet Connect') }}</h2>

                <ul class="nav desktop mobile nav-pills top-buffer">
                    <li class="active">{{ HTML::linkRoute('user', Lang::get('general.Pet owner')) }}</li>
                    <li>{{ HTML::linkRoute('vet', Lang::get('general.Vet practice')) }}</li>
                </ul>
                    {{ Form::open(array('route' => 'user.login', 'method' => 'post', 'class' => 'top-buffer')) }}

                    {{  Form::text('email_address', Input::old('email_address'), array('class' => 'form-control', 'placeholder' => 'Email address')) }}

                    {{ Form::password('password', array('class' => 'small-top-buffer form-control', 'placeholder' => 'Password')) }}

                    {{ Form::submit(Lang::get('general.Sign in'), array('class' => 'btn btn-lg btn-default btn-block small-top-buffer')) }}

                    {{ Form::close() }}

                    <h4>or</h4>

                    {{ Form::open(array('route' => 'user.facebook.login', 'method' => 'get')) }}

                    {{ Form::submit(Lang::get('general.Sign in with Facebook'), array('class' => 'btn btn-lg btn-primary btn-block small-top-buffer')) }}

                    {{ Form::close() }}

                    {{ Form::open(array('route' => 'user.twitter.login', 'method' => 'get')) }}

                    {{ Form::submit(Lang::get('general.Sign in with Twitter'), array('class' => 'btn btn-lg btn-info btn-block small-top-buffer')) }}

                    {{ Form::close() }}

                    <p class="top-buffer">{{ Lang::get('general.Don&#39;t have an account?') }} <strong>{{ HTML::linkRoute('user.register', Lang::get('general.Sign up')) }}</strong>
            </div>
        </div>
    </div>
@stop