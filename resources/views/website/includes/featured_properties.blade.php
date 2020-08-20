<div class="featured-properties content-area-12">
    <div class="container">
        <!-- Main title -->
        <div class="main-title">
            <h2><a class="hover-color" href="{{route('featured',['sort'=>'newest', 'limit'=>15])}}" title="Check out famous of all properties">Popular Properties</a></h2>
        </div>
        <div class="slick-slider-area" aria-label="popular properties">
            <div class="row slick-carousel"
                 data-slick='{"slidesToShow": 4, "responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}}]}'>
                @foreach($featured_properties as $feature_property)
                    <div class="slick-slide-item">
                        <div class="property-box-3" aria-label="listing link">
                            <a href="{{$feature_property->property_detail_path()}}" class="property-img" title="{{$feature_property->title}}">
                                <div class="property-thumbnail">
                                    @if($feature_property->premium_listing == 1)
                                        <div class="tag feature-tag">Premium</div>
                                    @elseif($feature_property->hot_listing == 1)
                                        <div class="tag feature-tag">HOT</div>
                                    @elseif($feature_property->super_hot_listing == 1)
                                        <div class="tag feature-tag">SUPER HOT</div>
                                    @endif
                                    @if($feature_property->image != null)
                                        <img class="d-block w-100" src="{{asset('thumbnails/properties/'.explode('.',$feature_property->image)[0].'-450x350.webp')}}"
                                             alt="{{\Illuminate\Support\Str::limit($feature_property->title, 20, $end='...')}}"
                                             title="{{$feature_property->title}}"/>
                                    @else
                                        <img class="d-block w-100" src="{{asset('img/logo/dummy-logo.png')}}" alt="properties"/>
                                    @endif
                                    <div class="listing-time opening" aria-label="purpose label"><i class="fa fa-eye fa-2 mr-1"></i>{{$feature_property->views}}</div>
                                </div>
                            </a>
                            <div class="details m-0" style="width: 100%">
                                <div class="top">
                                    <h2 class="title">
                                        <!-- method to convert price in number into price in words -->
                                        <a href="{{$feature_property->property_detail_path()}}" title="{{$feature_property->title}}">
                                            <span class="font-size-14 color-blue">PKR</span> {{str_replace('Thousand','K',Helper::getPriceInWords($feature_property->price))}}
                                        </a>
                                    </h2>
                                    <div class="location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{\Illuminate\Support\Str::limit($feature_property->location, 20, $end='...')}}
                                        <div class="grid-area mt-2 ml-3">{{\Illuminate\Support\Str::limit($feature_property->city, 20, $end='...')}}</div>
                                        <div class="mt-2 property-description">
                                            <a href="{{$feature_property->property_detail_path()}}" title="{{$feature_property->sub_type}} for {{$feature_property->purpose}}"
                                               class="color-blue text-transform">
                                                {{\Illuminate\Support\Str::limit(strtolower($feature_property->title), 27, $end='..')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <ul class="facilities-list clearfix">
                                    <li style="width: 40%; margin-top: 3px;text-align: center">
                                        <i class="fas fa-arrows-alt"></i>
                                        <p>{{ number_format($feature_property->land_area, 2) }}
                                            @if($feature_property->area_unit === 'Square Meters')Sq.M.
                                            @elseif($feature_property->area_unit === 'Square Feet') Sq.F.
                                            @elseif ($feature_property->area_unit === 'Square Yards')Sq.Yd.
                                            @else {{$feature_property->area_unit}} @endif</p>
                                    </li>
                                    @if($feature_property->bedrooms > 0)
                                        <li style="width: 30%; text-align: center">
                                            <i class="flaticon-furniture"></i>
                                            <p>{{ number_format($feature_property->bedrooms) }} Beds</p>
                                        </li>
                                    @endif
                                    @if($feature_property->bathrooms > 0)
                                        <li style="width: 30%; text-align: center">
                                            <i class="flaticon-holidays"></i>
                                            <p>{{ number_format($feature_property->bathrooms) }} Bath</p>
                                        </li>
                                    @endif

                                </ul>
                                <div class="footer clearfix">
                                    <ul class="float-right">
                                        @if(\Illuminate\Support\Facades\Auth::check())
                                            <li>
                                                <div class="favorite-property" style="font-size: 20px;">
                                                    <a href="javascript:void(0);" title="Add to favorite"
                                                       style="display: {{$feature_property->user_favorite === \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()? 'none':'block' }}"
                                                       class="favorite" data-id="{{$feature_property->id}}">
                                                        <i class="fal fa-heart empty-heart color-black"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" title="Add to favorite"
                                                       style="display : {{$feature_property->user_favorite === \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier() ? 'block':'none'}}"
                                                       class="remove-favorite color-black" data-id="{{$feature_property->id}}">
                                                        <i class="fas fa-heart filled-heart color-red"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        @else
                                            <li>
                                                <div class="favorite-property font-20">
                                                    <a data-toggle="modal" data-target="#exampleModalCenter" class="favourite color-black" title="Add to favorite">
                                                        <i class="fal fa-heart empty-heart"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                    <div class="days">
                                        <p><i class="flaticon-time"></i> {{ (new \Illuminate\Support\Carbon($feature_property->created_at))->diffForHumans(['parts' => 2]) }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="slick-btn">
                <div class="slick-prev slick-arrow-buton">
                    <i class="fa fa-angle-left"></i>
                </div>
                <div class="slick-next slick-arrow-buton">
                    <i class="fa fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
</div>
