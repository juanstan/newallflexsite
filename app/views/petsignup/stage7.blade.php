@extends('layouts.pet.signup')

@section('content')
    <div class="row" >
        <div class="col-md-12 col-centered float-none top-buffer text-left" >
            {{--<h3><i class="fa blue right-buffer fa-2x fa-check-circle vcenter"></i> readings uploaded.</h3>--}}
            <?php $i = 0; ?>
            @foreach ($pets as $value)
                @if ($value->name == null && $value->microchip_number != null)
                    <?php $i++; ?>
                @endif
            @endforeach
                    <h4>We found {{ $i }} new microchip numbers</h4>
        </div>
    </div>
    @foreach ($pets as $value)
        @if ($value->name != null && $value->microchip_number != null)
            <div class="row top-buffer" >
                <div class="col-sm-9 text-left">
                    <div class="col-sm-2" >
                        {{ HTML::image(isset($value->image_path) ? $value->image_path : '/images/pet-image.png', $value->name, array('class' => 'img-responsive img-circle', 'width' => '100%')) }}
                    </div>
                    <div class="col-sm-10 text-left" >
                        <h3>{{ $value->microchip_number }}</h3>
                    </div>
                </div>
                <div class="col-sm-3">
                    <h3>{{ $value->name }}</h3>
                </div>
            </div>
        @endif
    @endforeach
    @foreach ($pets as $value)
        @if ($value->name == null)
            {{ Form::open(array('url' => array('/pet/register/reading/assign', $value->id), 'method' => 'post')) }}
            <div class="row top-buffer" >
                <div class="col-sm-9 text-left">
                    <div class="col-sm-2" >
                        {{ HTML::image('images/pet-image.png', 'a Logo', array('class' => '')) }}
                    </div>
                    <div class="col-sm-10 text-left" >
                        <h3>{{ $value->microchip_number }}</h3>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="btn-group btn-input clearfix">
                        <button type="button" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown">
                            <span data-bind="label">Choose pet</span> <span class="caret"></span>
                            <input type="text" class="hidden" name="pet-id" value="" />
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            @foreach ($pets as $value)
                                @if ($value->microchip_number == null)
                                    <li data-id="{{ $value->id }}" ><a href="#">
                                        <div class="row" >
                                            <div class="col-md-3 small-padding" >{{ HTML::image(isset($value->image_path) ? $value->image_path : '/images/pet-image.png', $value->name, array('class' => 'img-responsive img-circle', 'width' => '100%')) }}</div>
                                            <div class="col-md-9 small-padding" >{{ $value->name }}</div>
                                        </div>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        @endif
    @endforeach
    <div class="row top-buffer" >
        <div class="col-md-12 col-centered" >
            <div class="form-group">
                <div class="col-sm-12">
                    
                    <div class="col-sm-7 pull-left">
                        <div class="col-sm-2" >
                            {{ HTML::image('images/scan-icon.png', 'a Logo', array('class' => '')) }}
                        </div>
                        <div class="col-sm-10 text-left" >
                            <p>Scan your pets to see their Microchip numbers on the device to match up above</p>
                        </div>
                    </div>
                    <a href="/pet/register/reading/finish" >{{ Form::button('Finish setup', array('class' => 'btn btn-default btn-lg pull-right')) }}</a>
                </div>
            </div>
        </div>
    </div>
@stop