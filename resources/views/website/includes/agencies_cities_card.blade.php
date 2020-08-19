<div class="card mb-3">
    <div class="card-header bg-white">
        <h2 class="pull-left all-cities-header title">{{ucwords(str_replace('-',' ', request()->segment(1)))}}</h2>
        <span class="btn btn-sm btn-outline pull-right clickable" id="close-icon" data-effect="fadeOut">close</span>
    </div>
    <div class="card-body" id="cities-card">
        <div class="row">
            @foreach($agencies_count as $agency)
                <div class="col-sm-3 my-2">
                    <a href="{{route('city.wise.partners',['agency'=>explode('-', request()->segment(1))[0],'city'=> strtolower(Str::slug($agency->city)),'sort'=> 'newest'])}}"
                       title="agencies in {{$agency->city}}"
                       class="breadcrumb-link">
                        {{$agency->city}} ({{$agency->agency_count}})
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
