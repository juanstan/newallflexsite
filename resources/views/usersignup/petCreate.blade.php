@extends('layouts.user.signup')

@section('content')

{!! Form::open(array('files'=> 'true', 'route' => 'user.register.pet.create', 'method' => 'post')) !!}
    @include('layouts.snippets.petForm')
{!! Form::close() !!}

@stop