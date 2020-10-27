@foreach($featured_agencies as $agency)
    <div class="slick-slide-item" aria-label="featured agency">
        @if($agency->logo !== null)

            <a href="{{route('agents.ads.listing',
                                            [ 'city'=>strtolower(Str::slug($agency->city)),
                                               'slug'=>\Illuminate\Support\Str::slug($agency->title),
                                               'agency'=> $agency->id ,
                                               ])}}">
                <img src="{{asset('thumbnails/agency_logos/'.explode('.',$agency->logo)[0].'-100x100'.'.webp')}}" alt="{{strtoupper($agency->title)}}" width="50%" height="50%"
                     class="img-fluid"
                     title="{{strtoupper($agency->title)}}" onerror="this.src='http://localhost/img/logo/dummy-logo.png'">
            </a>
        @else
            <a href="{{route('agents.ads.listing',
                                            [ 'city'=>strtolower(Str::slug($agency->city)),
                                               'slug'=>\Illuminate\Support\Str::slug($agency->title),
                                               'agency'=> $agency->id ,
                                               ])}}">
                <img src="{{asset('img/agency.png')}}" alt="{{strtoupper($agency->title)}}" width="50%" height="50%" class="img-fluid" title="{{strtoupper($agency->title)}}">
            </a>
        @endif
        <h2 class="agency-name mt-3 text-transform d-none">{{$agency->title}}</h2>
        <h2 class="agency-phone mt-3 text-transform d-none">{{$agency->phone}}</h2>
        <h2 class="sale-count mt-3 text-transform d-none">{{$agency->count}}</h2>
        <div class="mt-1 agency-city d-none">{{$agency->city}}</div>
    </div>

@endforeach
