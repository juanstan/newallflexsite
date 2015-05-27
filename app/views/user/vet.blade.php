@extends('layouts.user.dashboard')

@section('content')
    <div class="row col-md-12 col-centered top-buffer" >
        @if(Illuminate\Auth\)
        <?php $vetId = ''; ?>
        @foreach ($vets as $vet)
            @foreach ($requests as $request)
                @if($request->vet_id == $vet->id && $vet->id != $vetId)
                    <div class="col-md-4" >
                        <div class="jumbotron dashboard no-overflow text-center" >
                            <div class="vet-overlay collapse fade" id="vet-delete{{ $vet->id }}" >
                                <div class="col-md-12" >
                                    <h3>{{ Lang::get('general.Are you sure you want to remove this vet?') }}</h3>
                                    <div class="col-md-10 float-none col-centered top-buffer" >
                                        <div class="col-md-6 small-padding" >
                                            <a href="#" data-toggle="collapse" data-target="#vet-delete{{ $vet->id }}" >
                                                {{ Form::button(Lang::get('general.No, cancel'), array('class' => 'btn-block btn btn-file btn-md')) }}
                                            </a>
                                        </div>
                                        <div class="col-md-6 small-padding" >
                                            <a href="{{ URL::route('user.dashboard.removeVet', $vet->id) }}" >
                                                {{ Form::button(Lang::get('general.Yes, remove'), array('class' => 'btn-block btn btn-danger btn-md')) }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="#" data-toggle="collapse" data-target="#vet-delete{{ $vet->id }}" >
                                {{ Form::button(Lang::get('general.Remove'), array('class' => 'btn btn-file top-right btn-md')) }}
                            </a>
                            <div class="vet-bg-img" style="background-image: url('@if($vet->image_path != ''){{ $vet->image_path }}@else{{ '/images/vet-image.png' }}@endif');" >
                            </div>
                            <div class="col-md-12 float-none" >
                                <h3>{{ $vet->company_name }}</h3>
                                <address>
                                    {{ $vet->address_1 }}<br>
                                    {{ isset($vet->address_2) ? $vet->address_2 . '<br>' : '' }}
                                    {{ $vet->city }}<br>
                                    {{ $vet->zip }}<br><br>
                                    {{ isset($vet->fax) ? 'Fax: ' . $vet->fax : '' }}
                                    {{ Lang::get('general.Email') }}: <a href="" >{{ $vet->email_address }}</a>
                                </address>
                                @if($vet->latitude != null)
                                    <iframe width="100%" height="150" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q={{ $vet->latitude }}%20{{ $vet->longitude }}&key=AIzaSyD6-_l8AQw9Hyc_Cpi-HX2uZm2MiQuKH3I"></iframe>
                                @endif
                            <div class="col-md-12 float-none text-left" >
                                <h3 class="bottom-none" >{{ Lang::get('general.Approved pets') }}</h3>
                            </div>
                            @foreach ($requests as $petRequest)
                                @foreach ($pets as $pet)
                                    @if($petRequest->animal_id == $pet->id && $petRequest->vet_id == $vet->id && $petRequest->approved == 1)
                                    <a href="{{ URL::route('user.dashboard.deactivatePet', $petRequest->animal_request_id) }}" >
                                        <div class="col-sm-3 text-center small-padding request-pet" >
                                            {{ HTML::image('/images/deleted.png', '', array('class' => 'deactive hidden img-responsive img-circle', 'width' => '100%')) }}
                                            {{ HTML::image(isset($pet->image_path) ? $pet->image_path : '/images/pet-image.png', $pet->name, array('class' => 'img-responsive img-circle', 'width' => '100%')) }}
                                            <h4>{{ $pet->name }}</h4>
                                        </div>
                                    </a>
                                    @elseif($petRequest->animal_id == $pet->id && $petRequest->vet_id == $vet->id && $petRequest->approved == 0)
                                    <a href="{{ URL::route('user.dashboard.activatePet', $petRequest->animal_request_id) }}" >
                                        <div class="col-sm-3 text-center small-padding relative" >
                                            {{ HTML::image('/images/deleted.png', '', array('class' => 'deactive img-responsive img-circle', 'width' => '100%')) }}
                                            {{ HTML::image(isset($pet->image_path) ? $pet->image_path : '/images/pet-image.png', $pet->name, array('class' => 'img-responsive img-circle', 'width' => '100%')) }}
                                            <h4>{{ $pet->name }}</h4>
                                        </div>
                                    </a>
                                    @endif
                                @endforeach
                            @endforeach
                            </div>
                        </div>
                    </div>
                    <?php  $vetId = $vet->id; ?>
                @endif
            @endforeach
        @endforeach
        <div class="col-md-4" >
            <div class="tab-content ">
                <div  class="tab-pane active fade in" id="newPet">
                    <div class="jumbotron dashboard add-new-pet large-top-buffer" >
                        <div class="row" >
                            <div class="col-md-12 text-center" >
                                <a href="#newPetDetails" data-toggle="pill" data-target="" >
                                    <h2>
                                    <span class="fa-stack">
                                        <i class="fa fa-circle-thin fa-stack-2x"></i>
                                        <i class="fa fa-plus fa-stack-1x"></i>
                                    </span>
                                    </h2>
                                    <h3 class="top-none" >{{ Lang::get('general.Add vet') }}</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div  class="tab-pane fade in" id="newPetDetails">
                    <div class="jumbotron dashboard large-top-buffer" >
                        <div class="top-buffer col-md-12 col-centered">
                            <a href="#newPet" data-toggle="pill" data-target="" >
                                {{ Form::button('Cancel', array('class' => 'btn btn-file top-left btn-md')) }}
                            </a>
                            <div class="text-center" >
                            <p class="top-buffer">{{ Lang::get('general.To find your vet practice, search below') }}</p>
                            {{ HTML::image('/images/arrow.png', '', array('class' => '')) }}
                            </div>
                            <div class="input-group top-buffer">
                                <span class="input-group-addon">
                                    <i class="fa fa-search"></i>
                                </span>
                                {{ Form::text('vet-search', null, array('placeholder' => Lang::get('general.Search for vet'), 'id' => 'vetsearch', 'class' => 'form-control text-left', 'autocomplete' => 'off')) }}
                            </div>
                            <div class="top-buffer" ></div>
                            @foreach ($vets as $vet)
                                <div class="row vetname small-top-buffer" data-text="{{ $vet->company_name }}">
                                    <div class="col-xs-3 small-padding" >
                                        {{ HTML::image(isset($vet->image_path) ? $vet->image_path : '/images/vet-image.png', $vet->company_name, array('class' => 'img-responsive img-circle', 'width' => '100%')) }}
                                    </div>
                                    <div class="col-xs-6" >
                                        <h4 class="top-none bottom-none">{{ $vet->company_name }}</h4>
                                        <small class="top-none">{{ $vet->city }}</small>
                                    </div>
                                    <div class="col-xs-3 small-padding" >
                                        <a href="{{ URL::route('user.dashboard.addVet', $vet->id) }}" >
                                            {{ Form::button(Lang::get('general.Add'), array('class' => 'btn-block btn btn-default btn-md')) }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop