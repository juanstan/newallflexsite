<div class="col-xs-12 col-sm-6 col-md-4" >
    <div class="tab-content ">
        <div  class="tab-pane active fade in" id="newPet">
            <div class="jumbotron dashboard add-new-pet large-top-buffer" >
                <a href="#newPetDetails" data-toggle="pill" data-target="" >
                    <h2>
                            <span class="fa-stack">
                                <i class="fa fa-circle-thin fa-stack-2x"></i>
                                <i class="fa fa-plus fa-stack-1x"></i>
                            </span>
                    </h2>
                    <h3 class="top-none" >{!! Lang::get('general.New pet') !!}</h3>
                </a>
            </div>
        </div>
        <div  class="tab-pane fade in" id="newPetDetails">
            <div class="jumbotron dashboard large-top-buffer" >
                <div class="row" >
                    <div class="col-xs-12" >
                        <ul class="nav nav-pills text-left">
                            <li class="disabled"><a href="#latest" data-target="" >{!! Lang::get('general.Latest') !!}</a></li>
                            <li class="disabled" ><a href="#reports" data-target="">{!! Lang::get('general.Reports') !!}</a></li>
                            <li class="disabled pull-right active" ><a href="#edit" data-target=""><i class="fa fa-plus"></i> {!! Lang::get('general.<i class="fa fa-cog"></i> Edit') !!}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="form-horizontal float-none  top-buffer col-md-12 col-centered">
                    {!! Form::open(array('files'=> 'true', 'route' => 'user.dashboard.createPet', 'method' => 'post')) !!}
                    <div class="form-group">
                        <div class="col-xs-3 text-left">
                            {!! HTML::image('/images/pet-image.png', '', array('class' => 'image-placeholder img-responsive img-circle', 'width' => '100%')) !!}
                        </div>
                        <div class="col-xs-6 text-left">
                            {!! Form::button(Lang::get('general.Browse'), array('class' => 'btn btn-file pull-left', 'onclick' => '$("#ufile").click()' )) !!}
                            {!! Form::file('image_path', array('class' => 'hide', 'id'=>'ufile', 'onchange' => 'readURL(this);')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('name', Lang::get('general.Name'), array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-xs-9">
                            {!! Form::text('name', '', array('class' => 'form-control text-left')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('breed', Lang::get('general.Breed'), array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-xs-9">
                            {!! Form::text('breed_id', '', array('class' => 'form-control text-left breed-list')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 small-padding" >
                        <div class="form-group">
                            {!! Form::label('weight', Lang::get('general.Weight'), array('class' => 'col-xs-4 control-label')) !!}
                            <div class="col-xs-8">
                                <div class="input-group">
                                    {!! Form::text('weight', '', array('class' => 'form-control text-left')) !!}
                                    <div class="input-group-addon">{!! Lang::get('general.kg') !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('age', Lang::get('general.Date of birth'), array('class' => 'col-xs-5 control-label')) !!}
                        <div class="col-xs-7">
                            {!! Form::input('date', 'date_of_birth', '', array('class' => 'form-control text-left')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('gender', Lang::get('general.Gender'), array('class' => 'col-xs-3 control-label')) !!}
                        <div class="col-xs-9">
                            <div class="radio-pill-buttons">
                                <label><input type="radio" name="gender" value="1"><span class="pointer" >{!! Lang::get('general.Male') !!}</span></label>
                                <label><input type="radio" name="gender" value="0"><span class="pointer" >{!! Lang::get('general.Female') !!}</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12" >
                            {!! Form::submit(Lang::get('general.Save changes'), array('class' => 'btn btn-block btn-default btn-md')) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>