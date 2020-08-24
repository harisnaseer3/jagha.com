<div class="partners">
    <div class="container">
        <div class="main-title">
            <h2><a class="hover-color" href="{{route('featured-partners',['sort'=>'newest'])}}" title="Featured Partners">Our Featured Partners</a></h2></div>
        <div class="slick-slider-area" id="agency-slider">
            <div class="row slick-carousel" data-cycle-fx="carousel" data-cycle-timeout="0" data-cycle-next="slick-next" data-cycle-prev="slick-prev"
                 data-cycle-carousel-horizontal="true"
                 data-slick='{"slidesToShow": 5, "responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 5}}, {"breakpoint": 768,"settings":{"slidesToShow": 3}}]}'>

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
                                     title="{{strtoupper($agency->title)}}">
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
            </div>
            <div class="controls">
                <div class="slick-prev slick-arrow-buton" id="agency-prev">
                    <i class="fas fa-angle-left"></i>
                </div>
                <div class="slick-next slick-arrow-buton" id="agency-next">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
        <div>
            <h2 id="middle-agency-name"></h2>
            <h5 class="pt-1" id="agency-phone"></h5>
            <h5 class="pt-1" id="sale-count"></h5>
        </div>

    </div>
</div>


