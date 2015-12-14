<nav class="navbar navbar-default" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

    </div>
    <div class="navbar-brand">{!! HTML::image('images/suresensevetconnect-logo.png', 'Logo', array('width' => '197px')) !!}</div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar-collapse-1">

        <ul class="nav desktop mobile navbar-nav navbar-left">
            <li>{!! HTML::linkroute('vet.dashboard', Lang::get('general.Overview')) !!}</li>
            <li class="desktop" ><a href="#upload" id="upload-toggle" data-toggle="collapse" data-target="#file-upload"><i class="fa fa-cloud-upload"></i> {!! Lang::get('general.Upload') !!}</a></li>
        </ul>
        <ul class="nav desktop mobile navbar-nav navbar-right">
            <li>{!! HTML::linkroute('vet.dashboard.help', Lang::get('general.Help')) !!}</li>
            <li>{!! HTML::linkroute('vet.dashboard.settings', Lang::get('general.Settings')) !!}</li>
            <li>{!! HTML::linkroute('vet.logout', Lang::get('general.Logout')) !!}</li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>

<div class="row col-md-11 float-none col-centered collapse-group" >
    <div class="collapse" id="file-upload">
        {!! Form::open(array('files'=> 'true', 'route' => 'user.dashboard.readingUpload', 'class'=>'dropzone', 'method' => 'post')) !!}
        {!! Form::close() !!}
    </div>
</div>
