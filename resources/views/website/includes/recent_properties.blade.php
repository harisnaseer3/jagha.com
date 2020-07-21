<div class="recently-properties content-area-12">
    <div class="container">
        <!-- Main title -->
        <div class="main-title">
            <h1>Recent Properties</h1>
        </div>
        <div class="slick-slider-area">
            <div class="row slick-carousel"
                 data-slick='{"slidesToShow": 4, "responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}}]}'>
                @foreach($recent_properties as $recent_property)
                    <div class="slick-slide-item">
                        <div class="property-box-5">
                            <div class="property-photo">
                                <img class="img-fluid" src="{{asset('thumbnails/properties/'.explode('.',$recent_property->image)[0].'-450x350.webp')}}" alt="recent-properties"
                                     title=""/>
                                <div class="date-box">{{$recent_property->purpose}}</div>
                            </div>
                            <div class="detail">
                                <div class="heading">
                                    <h3>
                                        <a href="{{route('properties.show',$recent_property->id)}}">{{ \Illuminate\Support\Str::limit($recent_property->title, 15, $end='...') }}</a>
                                    </h3>
                                    <div class="location">
                                        <a href="">
                                            <i class="fas fa-map-marker-alt"></i>{{\Illuminate\Support\Str::limit($recent_property->location, 10, $end='...')}}, {{ $recent_property->city }}
                                        </a>
                                    </div>
                                </div>
                                <div class="properties-listing">
                                    @if($recent_property->bedrooms > 0)
                                        <span>3 {{$recent_property->bedrooms}} Beds</span>
                                    @endif
                                    @if($recent_property->bathrooms > 0)
                                        <span>2 {{$recent_property->bathrooms }} Bath</span>
                                    @endif
                                    <span>{{ number_format($recent_property->land_area) }} {{ $recent_property->area_unit }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="slick-btn">
                <div class="slick-prev slick-arrow-buton-2"></div>
                <div class="slick-next slick-arrow-buton-2"></div>
            </div>
        </div>
    </div>
</div>
