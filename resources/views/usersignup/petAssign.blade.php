@extends('layouts.user.signup')

@section('content')
    <div class="row" >
        <div class="col-md-12 col-centered float-none top-buffer text-left" >
            <?php $i = 0; ?>
            @foreach ($pets as $pet)
                @if ($pet->name == null && $pet->microchip_number != null)
                    <?php $i++; ?>
                @endif
            @endforeach
            <h4>{!! Lang::get('general.We found') !!} {!! $i !!} {!! Lang::get('general.new microchip numbers') !!}</h4>
        </div>
    </div>
    @foreach ($pets as $pet)
        @if ($pet->name != null && $pet->microchip_number != null)
            <div class="row top-buffer" >
                <div class="col-sm-9 text-left">
                    <div class="col-sm-2" >
                        {!! HTML::image(isset($pet->photo_id) ? $pet->photo->location : '/images/pet-image.png', $pet->name, array('class' => 'img-responsive img-circle', 'width' => '100%')) !!}
                    </div>
                    <div class="col-sm-10 text-left" >
                        <h3>{!! $pet->microchip_number !!}</h3>
                    </div>
                </div>
                <div class="col-sm-3">
                    <h3>{!! $pet->name !!}</h3>
                </div>
            </div>
        @endif
    @endforeach
    @foreach ($pets as $pet)
        @if ($pet->name == null)
            {!! Form::open(array('route' => array('user.register.reading.assign', $pet->id), 'method' => 'post')) !!}
            <div class="row top-buffer" >
                <div class="col-sm-9 text-left">
                    <div class="col-sm-2" >
                        {!! HTML::image('images/pet-image.png', 'a Logo', array('class' => '')) !!}
                    </div>
                    <div class="col-sm-10 text-left" >
                        <h3>{!! $pet->microchip_number !!}</h3>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="btn-group btn-input clearfix">
                        <button type="button" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown">
                            <span data-bind="label">{!! Lang::get('general.Choose pet') !!}</span> <span class="caret"></span>
                            {!! Form::hidden('pet_id') !!}
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            @foreach ($pets as $pet)
                                @if ($pet->microchip_number == null)
                                    <li data-id="{!! $pet->id !!}" ><a href="#">
                                        <div class="row" >
                                            <div class="col-md-3 small-padding" >
                                                {!! HTML::image(isset($pet->photo_id) ? $pet->photo->location : '/images/pet-image.png', $pet->name, array('class' => 'img-responsive img-circle', 'width' => '100%')) !!}
                                            </div>
                                            <div class="col-md-9 small-padding" >
                                                {!! $pet->name !!}
                                            </div>
                                        </div>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        @endif
    @endforeach
    <div class="row top-buffer" >
        <div class="col-md-12 col-centered" >
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="col-sm-7 pull-left">
                        <div class="col-sm-2" >
                            {!! HTML::image('images/scan-icon.png', 'a Logo', array('class' => '')) !!}
                        </div>
                        <div class="col-sm-10 text-left" >
                            <p>{!! Lang::get('general.Scan your pets to see their Microchip numbers on the device to match up above') !!}</p>
                        </div>
                    </div>
                    <a href="{!! URL::route('user.register.reading.finish') !!}" >
                        {!! Form::button(Lang::get('general.Finish setup'), array('class' => 'btn btn-default btn-lg pull-right')) !!}
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop