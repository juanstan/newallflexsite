@extends('layouts.signup')

@section('content')
    <div class="row large-top-buffer" >
        <div class="col-md-6 col-centered float-none" >
            <div class="jumbotron text-center" >
                {{ HTML::image('images/logo-pet.png', 'a Logo', array('class' => 'signup-logo')) }}
                <h2>{{ Lang::get('general.Password reset') }}</h2>

                {{ Form::open(array('route' => 'user.password.request', 'method' => 'post', 'class' => 'top-buffer')) }}

                {{  Form::text('email', '', array('class' => 'form-control', 'placeholder' => 'Email address')) }}

                {{ Form::submit(Lang::get('general.Submit'), array('class' => 'btn btn-lg btn-default btn-block small-top-buffer')) }}

                {{ Form::close() }}

            </div>
        </div>
    </div>
@stop