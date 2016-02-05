<div class="row" >
    <div class="col-xs-12" >
        <div class="col-xs-3" >
            {!! HTML::image(isset($pet->photo_id) ? $pet->photo->location : '/images/pet-image.png', $pet->name, array('class' => 'img-responsive img-circle', 'width' => '100%')) !!}
        </div>
        <div class="tab-content ">
            <div class="col-xs-9 active tab-pane fade in small-padding margintop0-25" id="pet-name{!! $pet->id !!}" >
                <h3 class="top-none bottom-none text-left color73">{!! isset($pet->name) ? $pet->name : 'Unknown' !!}</h3>
                <h4 class="top-none text-left">{!! isset($pet->microchip_number) ? $pet->microchip_number : Null !!}</h4>
            </div>
            <div class="col-xs-9 tab-pane fade in small-padding top-buffer" id="pet-photo{!! $pet->id !!}" >
                {!! Form::open(array('files'=> 'true', 'route' => array('user.dashboard.updatePetPhoto', $pet->id), 'method' => 'post')) !!}
                <p class="pointer" onclick="$('#ufile{!! $pet->id !!}').click()" ><i class="fa fa-camera"></i> {!! Lang::get('general.Change photo') !!}</p>
                <input class="hide" id="ufile{!! $pet->id !!}" onchange="this.form.submit()"  name="image_path" type="file">
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>