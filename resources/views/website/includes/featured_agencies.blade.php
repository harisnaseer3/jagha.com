<div class="partners featured-agencies">
    <div class="container content-area-12">
        <div class="main-title">
            <h2>Key Partners</h2></div>
        <div class="slider"></div>
        <div class="slick-slider-area" id="featured-agency-slider">
            <div class="row slick-carousel" id="feature-agency-row-1" data-cycle-fx="carousel" data-cycle-timeout="0" data-cycle-next="slick-next" data-cycle-prev="slick-prev"
                 data-cycle-carousel-horizontal="true"
                 data-slick='{"slidesToShow": 10, "responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 3}}, {"breakpoint": 768,"settings":{"slidesToShow": 2}}]}'>
                @foreach($key_agencies as $key=>$agency)
                    <div class="slick-slide-item" style="width: auto !important;" aria-label="key agency">
                        @if($agency->logo !== null)
                            <img src="{{asset('thumbnails/agency_logos/'.$agency->logo)}}" alt="{{$agency->title}}" title="{{$agency->title}}" class="img-fluid featured-agency-image"
                                 style="height:100px; width: 100px ;">
                        @else
                            <img src="{{asset('storage/agency_logos/'.'img256by256_1588397752.jpg')}}" alt="{{$agency->title}}" title="{{$agency->title}}" class="img-fluid featured-agency-image"
                                 style="height:100px; width: 100px ;">
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="controls">
                <div class="slick-prev slick-arrow-buton" id="featured-agency-prev">
                    <i class="fas fa-angle-left"></i>
                </div>
                <div class="slick-next slick-arrow-buton" id="featured-agency-next">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
</div>
