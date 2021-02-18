<div id="carouselControls" class="carousel slide " data-ride="carousel" data-interval="false">
    <div class="carousel-inner property-inner row w-100 mx-auto" role="listbox">

        @foreach($featured_properties as $index => $feature_property)
            <div class="carousel-item property-item col-sm-12 col-md-6 col-lg-4 col-xl-3 @if($index == 0) active @endif">
                <div class="card property-card">
                    <figure>
                        @if($feature_property->user_id !== 1 && $feature_property->image != null)
                            <img class="card-img-top" src="{{asset('thumbnails/properties/'.explode('.',$feature_property->image)[0].'-450x350.webp')}}"
                                 alt="{{\Illuminate\Support\Str::limit($feature_property->title, 20, $end='...')}}" title="{{$feature_property->title}}"
                                 onerror="this.src='{{asset('img/logo/dummy-logo.png')}}'">
                        @else
                            <img class="card-img-top" src="{{asset('img/logo/dummy-logo.png')}}" alt="properties"/>
                        @endif
                        <figcaption class="project-description-overlay p-3 text-center">
                            <h3 class="m-2 mt-3 property-heading-tag">Property For {{ $feature_property->purpose }}</h3>
                            <p class="property-line-height mb-2">
                                Contact us for more details. While calling please mention <a href="https://www.aboutpakistan.com" class="theme-blue">aboutpakistan.com</a>
                            </p>
                            <p><a style="color: #FF8E00" href="{{$feature_property->property_detail_path()}}">Read More</a></p>
                        </figcaption>
                    </figure>
                    <div class="card-body">
                        <div class="card-text">
                        <h2 class="property-title">
                            <!-- method to convert price in number into price in words -->
                            <a href="{{$feature_property->property_detail_path()}}">
                                <span class="font-size-14 color-blue mr-1">PKR</span>{{str_replace('Thousand','K',Helper::getPriceInWords($feature_property->price))}}
                            </a>
                        </h2>
                        <h6 class="card-subtitle mb-2 text-muted page-font">{{\Illuminate\Support\Str::limit(strtolower($feature_property->title), 50, $end='..')}}</h6>
                        <li class="text-capitalize page-font text-muted property-list mb-2">
                            <span class="mr-1"><i class="fas fa-map-marker-alt"></i></span>
                            <span class="text-muted"> {{ \Illuminate\Support\Str::limit($feature_property->location , 12, $end='...')}}, {{ \Illuminate\Support\Str::limit($feature_property->city, 15, $end='...') }}</span></li>

                        </div>
                        <ul class="facilities-list property-ul clearfix">
                            <li style="width: 40%; margin-top: 3px;text-align: center" data-toggle="tooltip" data-placement="top" data-html="true"
                                title='<div class="row mt-1">
                           <div class="col-md-12 color-white"><h6 class="color-white">Area Info</h6> <hr class="solid"></div>
                           <div class="col-md-12 mb-1  mt-1"> {{ number_format($feature_property->area_in_sqft,2) }} Sq.Ft.</div>
                           <div class="col-md-12 mb-1"> {{ number_format($feature_property->area_in_sqyd,2) }} Sq.Yd.</div>
                           <div class="col-md-12 mb-1"> {{ number_format($feature_property->area_in_sqm,2) }} Sq.M.</div>
                           <div class="col-md-12 mb-1"> {{ number_format($feature_property->area_in_new_marla,2) }} Marla</div>
                           <div class="col-md-12 mb-1"> {{ number_format($feature_property->area_in_new_kanal,2) }} Kanal </div>
                           </div>'>
                                <i class="fas fa-arrows-alt"></i>
                                <p>{{ number_format($feature_property->land_area, 2) }}
                                    @if($feature_property->area_unit === 'Square Meters')Sq.M.
                                    @elseif($feature_property->area_unit === 'Square Feet') Sq.F.
                                    @elseif ($feature_property->area_unit === 'Square Yards')Sq.Yd.
                                    @else {{$feature_property->area_unit}} @endif</p>
                            </li>
                            @if($feature_property->bedrooms > 0)
                                <li style="width: 30%; text-align: center">
                                    <i class="fal fa-bed-alt"></i>
                                    <p>{{ number_format($feature_property->bedrooms) }} Beds</p>
                                </li>
                            @endif
                            @if($feature_property->bathrooms > 0)
                                <li style="width: 30%; text-align: center">
                                    <i class="fal fa-bath"></i>
                                    <p>{{ number_format($feature_property->bathrooms) }} Bath</p>
                                </li>
                            @endif
                        </ul>
                        <div class="footer clearfix">
                            <div class="days">
                                <p><i class="flaticon-time"></i> {{ (new \Illuminate\Support\Carbon($feature_property->created_at))->diffForHumans(['parts' => 2]) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


    </div>

    <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon property-prev" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon property-next" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
