@extends('layouts.user.dashboard')

@section('content')
<?php
$temperaturePref = $user->units;
?>
<div class="row col-md-11 float-none col-centered collapse-group" >
    <div class="collapse" id="file-upload">
        {!! Form::open(array('files'=> 'true', 'route' => 'user.dashboard.readingUpload', 'class'=>'dropzone', 'method' => 'post')) !!}
        {!! Form::close() !!}
    </div>
</div>


<div class="row col-md-12 col-centered float-none top-buffer" >
    <div class="row">
    @foreach ($pets as $k=>$pet)
        <!--Grouping Pets in different rows -->
        @if (!fmod($k,3))
            </div><div class="row">
        @endif

        <div class="col-xs-12 col-sm-6 col-md-4" >

            <div class="top-buffer mobile" ></div>
            @include('user.dashboard-snippets.headerpetdetailstab')

            <div class="jumbotron dashboard @if(!$pet->name && !$petNoMicrochips->isEmpty()) select-pet-microchip @endif top-buffer" >

                @include('user.dashboard-snippets.removepettab')

                @include('user.dashboard-snippets.symptomslistpettab')

                @include('user.dashboard-snippets.conditionlistpettab')

                <div class="row" >
                    <div class="col-xs-12" >
                        <ul class="nav mobile-nav nav-pills text-left">
                            <li class="active"><a href="#latest{!! $pet->id !!}" data-toggle="pill" data-target="#pet-name{!! $pet->id !!}, #latest{!! $pet->id !!}, #pet-photo-hide{!! $pet->id !!}" >{!! Lang::get('general.Latest') !!}</a></li>
                            <li class="report-toggle" ><a href="#reports{!! $pet->id !!}" data-toggle="pill" data-target="#pet-name{!! $pet->id !!}, #reports{!! $pet->id !!}, #image_path-hide{!! $pet->id !!}">{!! Lang::get('general.Reports') !!}</a></li>
                            <li class="pull-right" ><a href="#edit{!! $pet->id !!}" data-toggle="pill" data-target="#pet-photo{!! $pet->id !!}, #edit{!! $pet->id !!}"  >{!! ($pet->name == NULL ? Lang::get('general.<i class="fa fa-cog"></i> Edit') : Lang::get('general.<i class="fa fa-cog"></i> Edit') ); !!}</a></li>
                        </ul>
                    </div>
                </div>

                @include('user.dashboard-snippets.latestinfopettab')

            </div>

        </div>

    @endforeach

    @include('user.dashboard-snippets.newpettab')


    </div>

</div>
<div class="large-top-buffer" ></div>
@stop