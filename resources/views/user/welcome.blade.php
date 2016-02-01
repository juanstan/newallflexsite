@extends('layouts.signup')

@section('content')
    <div class="row large-top-buffer" >
        <div class="col-md-6 col-centered float-none" >
            <div class="jumbotron text-center" >
                {!! HTML::image('images/suresenselogo.png', 'a Logo', array('class' => 'signup-logo')) !!}
                <h2>{!! Lang::get('general.Sign in to SureSense') !!}</h2>

                <ul class="nav desktop mobile nav-pills top-buffer">
                    <li class="active">{!! HTML::linkRoute('user', Lang::get('general.Pet owner')) !!}</li>
                    <li>{!! HTML::linkRoute('vet', Lang::get('general.Vet practice')) !!}</li>
                </ul>
                    {!! Form::open(array('route' => 'user.login', 'method' => 'post', 'class' => 'top-buffer')) !!}

                    {!!  Form::text('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'Email address')) !!}

                    {!! Form::password('password', array('class' => 'small-top-buffer form-control', 'placeholder' => 'Password')) !!}

                    {!! Form::submit(Lang::get('general.Sign in'), array('class' => 'btn btn-lg btn-default btn-block small-top-buffer')) !!}

                    {!! Form::close() !!}

                    <h4>or</h4>

                    <a href="{!! URL::route('user.auth.external.redirect', array('provider' => 'facebook')) !!}" >
                        {!! Form::button(Lang::get('general.Sign in with Facebook'), array('class' => 'btn btn-lg btn-primary btn-block small-top-buffer')) !!}
                    </a>

                    <a href="{!! URL::route('user.auth.external.redirect', array('provider' => 'twitter')) !!}" >
                        {!! Form::button(Lang::get('general.Sign in with Twitter'), array('class' => 'btn btn-lg btn-info btn-block small-top-buffer')) !!}
                    </a>

                    <p class="top-buffer">{!! Lang::get('general.Forgot your password?') !!} <strong>{!! HTML::linkRoute('user.password.request', Lang::get('general.Reset password')) !!}</strong>

                    <p class="top-buffer">{!! Lang::get('general.Don&#39;t have an account?') !!} <strong>{!! HTML::linkRoute('user.register', Lang::get('general.Sign up')) !!}</strong>
            </div>
        </div>
    </div>
@stop