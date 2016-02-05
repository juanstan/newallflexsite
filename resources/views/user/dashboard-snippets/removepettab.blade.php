<div class="vet-overlay collapse fade" id="pet-delete{!! $pet->id !!}" >
    <div class="col-xs-12 text-center" >
        <h3>{!! Lang::get('general.Are you sure you want to remove this pet?') !!}</h3>
        <div class="col-xs-10 float-none col-centered top-buffer" >
            <div class="col-xs-6 small-padding" >
                <a href="#" data-toggle="collapse" data-target="#pet-delete{!! $pet->id !!}" >
                    {!! Form::button(Lang::get('general.No, cancel'), array('class' => 'btn-block btn btn-file btn-md')) !!}
                </a>
            </div>
            <div class="top-buffer mobile" ></div>
            <div class="col-xs-6 small-padding" >
                <a href="{!! URL::route('user.dashboard.removePet', $pet->id) !!}" >
                    {!! Form::button(Lang::get('general.Yes, remove'), array('class' => 'btn-block btn btn-danger btn-md')) !!}
                </a>
            </div>
        </div>
    </div>
</div>