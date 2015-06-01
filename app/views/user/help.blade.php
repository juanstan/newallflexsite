@extends('layouts.user.dashboard')

@section('content')
    <div class="row col-md-12 col-centered" >
        @foreach($help as $item)
        <div class="col-md-4" >
            <a href="{{ URL::route('user.dashboard.result', $item->id) }}" >
                <div class="jumbotron dashboard help faq-tile" >
                    <div class="col-md-11 float-none" >
                    <h3>{{ $item->title }}</h3>
                    <p>{{ $item->cover }}</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
            <input id="searchterm" name="term" type="text" /> <button id="search">search</button>
        <div id="results" ></div>


    </div>
@stop