@extends('layouts.user.signup')

@section('content')
    {!! Form::model($pet, array('files'=> 'true', 'route' => array('user.register.pet.{pet_id}.edit',$pet->id), 'method' => 'post')) !!}
        @include('layouts.snippets.petForm')
    {!! Form::close() !!}
    <div class="top-buffer mobile" ></div>
@stop