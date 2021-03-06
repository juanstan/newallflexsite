@if (count($errors->all()) > 0)
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Error</h4>
        @foreach ($errors->all() as $error)
            <div>{!! $error !!}</div>
        @endforeach
    </div>
@endif

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Success</h4>
        @if(is_array($message))
            @foreach ($message as $m)
                {!! $m !!}
            @endforeach
        @else
            {!! $message !!}
        @endif
    </div>
@endif


@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Error</h4>
        @if(is_array($message))
            @foreach ($message as $m)
                {!! $m !!}
            @endforeach
        @else
            {!! $message !!}
        @endif
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Warning</h4>
        @if(is_array($message))
            @foreach ($message as $m)
                {!! $m !!}
            @endforeach
        @else
            {!! $message !!}
        @endif
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-info alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Info</h4>
        @if(is_array($message))
            @foreach ($message as $m)
                {!! $m !!}
            @endforeach
        @else
            {!! $message !!}
        @endif
    </div>
@endif

@if ($message = Session::get('reminder'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Password Reset</h4>
        @if(is_array($message))
            @foreach ($message as $m)
                {!! $m !!}
            @endforeach
        @else
            {!! $message !!}
        @endif
    </div>
@endif

@if ($message = Session::get('verified'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Account confirmed!</h4>
        @if(is_array($message))
            @foreach ($message as $m)
                {!! $m !!}
            @endforeach
        @else
            {!! $message !!}
        @endif
    </div>
@endif