<nav class="navbar navbar-default" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header" >
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigationbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

    </div>
    <div class="navbar-brand">{{ HTML::image('images/logo-pet.png', 'Logo', array('width' => '60px')) }}</div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navigationbar">

        <ul class="nav desktop mobile navbar-nav navbar-left">
            <li>{{ HTML::linkroute('user.dashboard', Lang::get('general.My Pets')) }}</li>
            <li class="desktop"><a href="#upload" id="upload-toggle" data-toggle="collapse" data-target="#file-upload"><i class="fa fa-cloud-upload"></i> {{ Lang::get('general.Upload') }}</a></li>
        </ul>
        <ul class="nav navbar-nav desktop mobile navbar-right">
            <li>{{ HTML::linkroute('user.dashboard.help', Lang::get('general.Help')) }}</li>
            <li>{{ HTML::linkroute('user.dashboard.vet', Lang::get('general.My Vet')) }}</li>
            <li>{{ HTML::linkroute('user.dashboard.settings', Lang::get('general.Settings')) }}</li>
            <li>{{ HTML::linkroute('user.logout',Lang::get('general.Logout')) }}</li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>