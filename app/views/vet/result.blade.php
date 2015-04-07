@extends('layouts.vet.dashboard')

@section('content')
    <div class="row col-md-8 float-none col-centered" >
         <h4><i class="blue fa fa-angle-left"></i> <a href="/vet/help" >Back</a></h4>
        <div class="jumbotron dashboard faq-result-tile" >
            <div class="col-md-11 float-none" >
            <h3>This is a title for a FAQ</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec turpis massa. Aliquam posuere est a justo elementum posuere. Vestibulum ipsum tortor, imperdiet vel erat et, ullamcorper sodales purus. Nunc consequat turpis nulla, a porta ligula mollis non. Etiam aliquet diam eget ligula viverra, a sollicitudin est aliquam.</p>
             {{ HTML::image('images/graphic-copy.png', 'a Logo', array()) }}
             <ol class="top-buffer">
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
            </ol>
            </div>
            <div class="row top-buffer" >
                <div class="col-sm-10 float-none col-centered ">
                    <div class="col-sm-6 ">
                        <p class="pull-left"><i class="blue fa fa-angle-left"></i> <a href="" >This is a title for another FAQ</a></p>
                    </div>
                    <div class="col-sm-6 ">
                        <p class="pull-right"><a href="" >This is a title for another FAQ</a> <i class="blue fa fa-angle-right"></i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop