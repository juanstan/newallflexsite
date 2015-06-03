@extends('layouts.signup')

@section('content')
    <div class="row large-top-buffer" >
        <div class="col-md-6 col-centered float-none" >
            <div class="jumbotron text-center" >
                {{ HTML::image('images/logo-pet.png', 'a Logo', array('class' => 'signup-logo')) }}
                <h2>{{ Lang::get('general.Sign up to PetConnect') }}</h2>

                <ul class="nav mobile desktop nav-pills top-buffer">
                    <li class="active">{{ HTML::linkRoute('user', Lang::get('general.Pet owner')) }}</li>
                    <li>{{ HTML::linkRoute('vet', Lang::get('general.Vet practice')) }}</li>
                </ul>
                    {{ Form::open(array('route' => 'user.create', 'method' => 'post', 'class' => 'top-buffer')) }}

                    {{  Form::text('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'Email address')) }}

                    {{ Form::password('password', array('class' => 'small-top-buffer form-control', 'placeholder' => 'Create Password')) }}

                    {{ Form::password('password_confirmation', array('class' => 'small-top-buffer form-control', 'placeholder' => 'Confirm Password')) }}

                    {{ Form::submit(Lang::get('general.Create account'), array('class' => 'btn btn-lg btn-default btn-block small-top-buffer')) }}

                    {{ Form::close() }}

                    <h4>or</h4>

                    {{ Form::open(array('route' => 'user.facebook.create', 'method' => 'get')) }}

                    {{ Form::submit(Lang::get('general.Sign up with Facebook'), array('class' => 'btn btn-lg btn-primary btn-block small-top-buffer')) }}

                    {{ Form::close() }}

                    {{ Form::open(array('route' => 'user.twitter.create', 'method' => 'get')) }}

                    {{ Form::submit(Lang::get('general.Sign up with Twitter'), array('class' => 'btn btn-lg btn-info btn-block small-top-buffer')) }}

                    {{ Form::close() }}

                    <p class="top-buffer">{{ Lang::get('general.Already have an account?') }} <strong>{{ HTML::linkroute('user', Lang::get('general.Sign in')) }}</strong>

            </div>
        </div>
    </div>
@stop