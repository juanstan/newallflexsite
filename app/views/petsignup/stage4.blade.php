@extends('layouts.pet.signup')

@section('content')
    <div class="row" >
        <div class="col-md-12 col-centered float-none" >
            <div class="form-horizontal top-buffer">
                <div class="row col-centered float-none top-buffer vcenterwrap" >
                    <div class="col-md-5 vcenter right-none left-none" >
                        {{ HTML::image('images/vet-stock.png', 'Springer', array('class' => '', 'width' => '100%')) }}
                    </div>
                    <div class="col-md-7 vcenter" >
                        <h2 class="top-none text-left">Connect with your vet</h2>
                        <div class="row" >
                            
                            <div class="col-md-12 text-left" >
                                <h4><i class="orange right-buffer fa fa-share-alt"></i> Easily share your readings with your vet</h4>
                            </div>
                        </div>
                        <div class="row" >
                            
                            <div class="col-md-12 text-left" >
                                <h4><i class="fa red right-buffer fa-file-text"></i> Store important vet details for emergencies</h4>
                            </div>
                        </div>
                        <div class="row top-buffer" >
                            <div class="col-md-6" >
                                <a href="/pet/register/vet/add" >{{ HTML::decode(Form::button('<i class="fa fa-search"></i> Find my vet', array('class' => 'btn border-none btn-default btn-lg pull-left btn-block'))) }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row top-buffer" >
        <div class="col-md-12 col-centered" >
            <div class="form-group">
                    <div class="col-sm-12">
                        
                        <a href="/pet/register/pet" >{{ Form::button('Back', array('class' => 'btn btn-file btn-lg pull-left border-none')) }}</a>
                        
                        <a href="/pet/register/reading" >{{ Form::button('No thanks, skip', array('class' => 'btn btn-default btn-lg border-none pull-right')) }}</a>

                        {{ Form::close() }}

                    </div>
                </div>
        </div>
    </div>
@stop