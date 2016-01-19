@extends('layouts.user.dashboard')

@section('content')
    <div class="row col-md-11 float-none col-centered collapse-group" >
        <div class="collapse" id="file-upload">
            {!! Form::open(array('files'=> 'true', 'route' => 'user.dashboard.readingUpload', 'class'=>'dropzone', 'method' => 'post')) !!}
            {!! Form::close() !!}
        </div>
    </div>
    <div class="col-xs-12 col-centered top-buffer" >
        <?php $vetId = ''; ?>
        <div class="row container-vet-pill">
        @foreach ($vets as $vet)
            <div class="col-xs-12 col-sm-6 col-md-4" >
                <div class="jumbotron dashboard no-overflow text-center" >
                    <div class="vet-overlay collapse fade" id="vet-delete{!! $vet->id !!}" >
                        <div class="col-xs-12" >
                            <h3>{!! Lang::get('general.Are you sure you want to remove this vet?') !!}</h3>
                            <div class="col-xs-10 float-none col-centered top-buffer" >
                                <div class="col-xs-6 small-padding" >
                                    <a href="#" data-toggle="collapse" data-target="#vet-delete{!! $vet->id !!}" >
                                        {!! Form::button(Lang::get('general.No, cancel'), array('class' => 'btn-block btn btn-file btn-md')) !!}
                                    </a>
                                </div>
                                <div class="col-xs-6 small-padding" >
                                    <a href="{!! URL::route('user.dashboard.removeVet', $vet->id) !!}" >
                                        {!! Form::button(Lang::get('general.Yes, remove'), array('class' => 'btn-block btn btn-danger btn-md')) !!}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#" data-toggle="collapse" data-target="#vet-delete{!! $vet->id !!}" >
                        {!! Form::button(Lang::get('general.Remove'), array('class' => 'btn btn-file top-right btn-md')) !!}
                    </a>
                    <div class="vet-bg-img" style="background-image: url('@if($vet->image_path != ''){!! $vet->image_path !!}@else{!! '/images/vet-image.png' !!}@endif');" >
                    </div>
                    <div class="col-xs-12 float-none vet-content" >
                        <h3>{!! $vet->company_name !!}</h3>
                        <address>
                            {!! $vet->address_1 !!}<br>
                            {!! isset($vet->address_2) ? $vet->address_2 . '<br>' : '' !!}
                            {!! $vet->city !!}<br>
                            {!! $vet->zip !!}<br><br>
                            {!! isset($vet->fax) ? 'Fax: ' . $vet->fax : '' !!}
                            {!! Lang::get('general.Email') !!}: <a href="" >{!! $vet->email !!}</a>
                        </address>
                        @if($vet->latitude != null)
                            <iframe width="100%" height="150" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q={!! $vet->latitude !!}%20{!! $vet->longitude !!}&key=AIzaSyD6-_l8AQw9Hyc_Cpi-HX2uZm2MiQuKH3I"></iframe>
                        @endif
                        <div class="col-xs-12 float-none text-left assigned-title-wrapper npaddingleft" >
                            <h4>{!! Lang::get('general.Assigned pets') !!}</h4>
                        </div>
                        <div class="pets-list">
                            @foreach ($vet->pets()->wherePivot('approved','=',1)->get() as $pet)
                               <a href="{!! URL::route('user.dashboard.deactivatePet', $pet->id.'/'.$vet->id) !!}" >
                                    <div class="col-xs-3 text-center small-padding request-pet" >
                                        {!! HTML::image('/images/deleted.png', '', array('class' => 'deactive hidden img-responsive img-circle', 'width' => '100%')) !!}
                                        {!! HTML::image(isset($pet->image_path) ? $pet->image_path : '/images/pet-image-approved.png', $pet->name, array('class' => 'img-responsive', 'width' => '100%')) !!}
                                        <h4 class="pet-name">{!! $pet->name !!}</h4>
                                    </div>
                                </a>
                            @endforeach
                            @foreach ($vet->pets()->wherePivot('approved','=',0)->get() as $pet)
                                <a href="{!! URL::route('user.dashboard.activatePet', $pet->id.'/'.$vet->id) !!}" >
                                    <div class="col-xs-3 text-center small-padding relative" >
                                        {!! HTML::image('/images/deleted.png', '', array('class' => 'deactive img-responsive img-circle', 'width' => '100%')) !!}
                                        {!! HTML::image(isset($pet->image_path) ? $pet->image_path : '/images/pet-image.png', $pet->name, array('class' => 'img-responsive img-circle', 'width' => '100%')) !!}
                                        <h4 class="pet-name">{!! $pet->name !!}</h4>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-xs-12 col-sm-6 col-md-4" >
            <div class="tab-content ">
                <div  class="tab-pane  fade in" id="newPet">
                    <div class="jumbotron dashboard add-new-pet" >
                        <div class="row" >
                            <div class="col-md-12 text-center" >
                                <a href="#newPetDetails" data-toggle="pill" data-target="" >
                                    <h2>
                                    <span class="fa-stack">
                                        <i class="fa fa-circle-thin fa-stack-2x"></i>
                                        <i class="fa fa-plus fa-stack-1x"></i>
                                    </span>
                                    </h2>
                                    <h3 class="top-none" >{!! Lang::get('general.Add vet') !!}</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div  class="tab-pane active fade in" id="newPetDetails">
                    <div class="jumbotron dashboard" >
                        <div class="top-buffer col-md-12 col-centered">
                            <a href="#newPet" data-toggle="pill" data-target="" >
                                {!! Form::button('Cancel', array('class' => 'btn btn-file top-left btn-md')) !!}
                            </a>
                            <div class="text-center" >
                            <p class="top-buffer">{!! Lang::get('general.To find your vet practice, search below') !!}</p>
                            <p>{!! HTML::image('/images/arrow.png', '', array('class' => '')) !!}</p>
                            </div>

                            <div role="tabpanel small-top-buffer">


                                <ul class="nav mobile-nav nav-pills">
                                    <li class="active "><a href="#vetLocation" aria-controls="vetLocation" role="tab" data-toggle="tab">Location</a></li>
                                    <li class="report-toggle"><a href="#vetName" aria-controls="vetName" role="tab" data-toggle="tab">Vet Practice</a></li>
                                </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane" id="vetName">
                                        <div class="input-group top-buffer">
                                            <span class="input-group-addon">
                                                <i class="fa fa-search"></i>
                                            </span>
                                            {!! Form::text('term', null, array('placeholder' => Lang::get('general.Search for vet'), 'id' => 'searchVetName', 'class' => 'form-control text-left', 'autocomplete' => 'off')) !!}
                                        </div>
                                </div>
                                <div role="tabpanel" class="tab-pane active" id="vetLocation">
                                    <div class="input-group top-buffer">
                                        <span class="input-group-addon">
                                            <i class="fa fa-search"></i>
                                        </span>
                                        {!! Form::text('term', null, array('placeholder' => Lang::get('general.Search in your location'), 'id' => 'searchVetLocation', 'class' => 'form-control text-left', 'autocomplete' => 'off')) !!}
                                    </div>
                                </div>
                            </div>

                            </div>

                            <div class="top-buffer" ></div>
                            <div id="results" ></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@stop