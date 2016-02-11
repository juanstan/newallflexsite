@foreach($vets as $vet)
    <div class='row vetname results-vets small-top-buffer' data-text='" + item.company_name + "' >
        <div class='col-xs-3 small-padding' >
            <img src='/images/vet-image.png' class='img-responsive img-circle' width='100%' />
        </div>
        <div class='col-xs-6' >
            <h4 class='top-none bottom-none'>{{$vet->company_name}}</h4>
            <small class='top-none'>{{$vet->city}}</small>
        </div>
        <div class='col-xs-3 small-padding' >
            <a href='/user/dashboard/add-vet/{{$vet->id}}' >
                <button class='btn-block btn btn-default btn-md' >Add</button>
            </a>
        </div>
    </div>
@endforeach