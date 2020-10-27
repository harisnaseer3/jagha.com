@foreach($key_agencies as $agency)
    <div class="slick-slide-item" aria-label="key agency">
        @if($agency->logo !== null)
            <div class="service-box">
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <a href="{{route('agents.ads.listing',[ 'city'=>strtolower(Str::slug($agency->city)),'slug'=>\Illuminate\Support\Str::slug($agency->title),'agency'=> $agency->id])}}">{{\Illuminate\Support\Str::limit($agency->title, 25, $end='..')}}</a>
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <a href="{{route('agents.ads.listing',
                                            [ 'city'=>strtolower(Str::slug($agency->city)),
                                               'slug'=>\Illuminate\Support\Str::slug($agency->title),
                                               'agency'=> $agency->id ,
                                               ])}}">
                            <img src="{{asset('thumbnails/agency_logos/'.explode('.',$agency->logo)[0].'-100x100'.'.webp')}}" loading="lazy" alt="{{$agency->title}}"
                                 class="img-fluid featured-agency-image" onerror="this.src='http://localhost/img/logo/dummy-logo.png'" style="height:53px; width: 60px ;">
                        </a>
                    </div>
                    <div class="col-8">
                        <p><i class="fa fa-map-marker mr-1 mt-1 fa-2x" aria-hidden="true"></i>{{$agency->city}}</p>
                        <p>
                            @if($agency->cell == null || preg_match('/\+92$/', $agency->cell))
                            @else
                                <i class="fa fa-phone mr-1 fa-2x" aria-hidden="true"></i>{{explode('-+92',$agency->cell)[0]}}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @else
            <a href="{{route('agents.ads.listing', [ 'city'=>strtolower(Str::slug($agency->city)), 'slug'=>\Illuminate\Support\Str::slug($agency->title), 'agency'=> $agency->id])}}">
                <img src="{{asset('storage/agency_logos/'.'img256by256_1588397752.jpg')}}" loading="lazy" alt="{{$agency->title}}"
                     title='<div class="row p-2"><div class="col-md-12"><p class="color-white mb-2">{{$agency->title}}</p><p class="color-white"> <i class="fa fa-map-marker mr-2" aria-hidden="true"></i>{{$agency->city}}</p><p class="color-white mb-2"><i class="fa fa-phone mr-2" aria-hidden="true"></i>{{$agency->phone}}</p></div></div>'
                     data-toggle="tooltip" data-html="true" data-placement="top" class="img-fluid featured-agency-image" style="height:53px; width: 53px ;">
            </a>
        @endif
    </div>
@endforeach
