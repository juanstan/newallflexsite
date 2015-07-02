@extends('layouts.user.dashboard')

@section('content')
    @foreach($help as $item)
    <div class="row col-md-8 float-none col-centered" >
         <h4><i class="blue fa fa-angle-left"></i> <a href="{!! URL::route('user.dashboard.help') !!}" >{!! Lang::get('general.Back') !!}</a></h4>
        <div class="jumbotron dashboard faq-result-tile" >
            <div class="col-md-11 float-none" >
            <h3>{!! $item->title !!}</h3>
            <p>{!! $item->content !!}</p>
            </div>
            <div class="row top-buffer" >
                <div class="col-sm-10 float-none col-centered ">
                    <div class="col-sm-6 ">
                        <p class="pull-left"><i class="blue fa fa-angle-left"></i> <a href="" >{!! Lang::get('general.This is a title for another FAQ') !!}</a></p>
                    </div>
                    <div class="col-sm-6 ">
                        <p class="pull-right"><a href="" >{!! Lang::get('general.This is a title for another FAQ') !!}</a> <i class="blue fa fa-angle-right"></i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@stop