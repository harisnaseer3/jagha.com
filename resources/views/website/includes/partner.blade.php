<div class="partners">
    <div class="container content-area-12">
        <div class="main-title">
            <h2>Our Featured Partners</h2></div>
        <div class="slick-slider-area" id="agency-slider">
            <div class="row slick-carousel" data-cycle-fx="carousel" data-cycle-timeout="0" data-cycle-next="slick-next" data-cycle-prev="slick-prev"
                 data-cycle-carousel-horizontal="true"
                 data-slick='{"slidesToShow": 6, "responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 3}}, {"breakpoint": 768,"settings":{"slidesToShow": 2}}]}'>
                @foreach($featured_agencies as $agency)
                    <div class="slick-slide-item" aria-label="featured agency">
                        @if($agency->logo !== null)
                            <img src="{{asset('thumbnails/agency_logos/'.$agency->logo)}}" alt="{{strtoupper($agency->title)}}" width="40%" height="30%" class="img-fluid"
                                 title="{{strtoupper($agency->title)}}">
                        @else
                            <img src="{{asset('img/agency.png')}}" alt="{{strtoupper($agency->title)}}" width="40%" height="30%" class="img-fluid" title="{{strtoupper($agency->title)}}">
                        @endif
                        <h2 class="agency-name mt-3 text-transform">{{$agency->title}}</h2>
                        <div class="mt-1">{{implode(', ', json_decode($agency->city))}}</div>
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
    </div>
</div>
