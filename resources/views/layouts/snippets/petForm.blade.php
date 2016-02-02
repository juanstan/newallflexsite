<div class="row" >
    <div class="col-md-12 mobile" >
        <h3>{!! Lang::get('general.Your pets') !!}</h3>
    </div>
    <div class="col-md-9 col-centered float-none" >
        <div class="form-horizontal top-buffer">
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8 text-left">
                    {!! HTML::image(isset($pet->photo_id) ? $pet->photo->location : '/images/grey-circle.png', $pet->name, array('class' => 'image-placeholder img-responsive img-centered img-circle')) !!}
                </div>
            </div>
            <div class="form-group">
                    {!! Form::label('pet-photo', Lang::get('general.Pet&#39;s photo'), array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8 text-left">
                    {!! Form::button(Lang::get('general.Browse'), array('class' => 'btn btn-file pull-left', 'onclick' => '$("#ufile").click()' )) !!}
                    {!! Form::file('image_path', array('class' => 'hide', 'id'=>'ufile', 'onchange' => 'readURL(this);')) !!}
                    <small class="small-left-buffer">{!! Lang::get('general.JPEG or PNG 4mb file limit') !!}</small>
                </div>
            </div>
            <div class="form-group">
                    {!! Form::label('name', Lang::get('general.Pet&#39;s name'), array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::text('name', $pet->name, array('class' => 'form-control text-left')) !!}
                </div>
            </div>
            <div class="form-group">
                    {!! Form::label('breed_id', Lang::get('general.Breed'), array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::input('name', 'breed_id', $pet->breed_wildcard, array('class' => 'form-control text-left', 'id' => 'breedList'))!!}
                </div>
            </div>
            <div class="form-group">
                    {!! Form::label('date_of_birth', Lang::get('general.Date of birth'), array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-5">
                    {!! Form::input('date', 'date_of_birth', $pet->date_of_birth, array('class' => 'form-control text-left')) !!}
                </div>
            </div>
            <div class="form-group">
                    {!! Form::label('weight', Lang::get('general.Weight'), array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-4">
                    <div class="input-group">
                        {!! Form::text('weight', $pet->weight, array('class' => 'form-control text-left')) !!}
                        <div class="input-group-addon">
                            @if ($user->weight_units)
                                lbs
                            @else
                                kg
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('gender', Lang::get('general.Gender'), array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    <div class="radio-pill-buttons">
                        <label>
                            <input type="radio" name="gender" value="1" <?=$pet->gender?'checked':''?> ><span class="pointer" >{!! Lang::get('general.Male') !!}</span>
                        </label>
                        <label>
                            <input type="radio" name="gender" value="0" <?=$pet->gender?'':'checked'?>><span class="pointer" >{!! Lang::get('general.Female') !!}</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" >
    <div class="col-md-12 col-centered" >
        <div class="form-group">
            <div class="col-sm-12">
                <a href="{!! URL::route('user.register.pet') !!}" >
                    {!! Form::button(Lang::get('general.Back'), array('class' => 'btn btn-file btn-lg pull-left border-none')) !!}
                </a>
                {!! Form::submit(Lang::get('general.Next'), array('class' => 'btn btn-default btn-lg border-none pull-right')) !!}
                <a href="{!! URL::route('user.register.pet') !!}" >
                    {!! Form::button(Lang::get('general.Skip'), array('class' => 'btn btn-file btn-lg pull-right border-none right-buffer')) !!}
                </a>
            </div>
        </div>
    </div>
</div>