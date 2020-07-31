<div class="similar-properties mb-30 detail-page-similar-properties" style="margin-top: 100px">
    <!-- Main title -->
    <h3 class="heading-2">Similar Properties</h3>
    <div class="row similar-properties">
        <div class="container-fluid">
            <div class="slick-slider-area">
                <div class="row slick-carousel"
                     data-slick='{"slidesToShow": 3, "responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}}]}'>
                    @foreach($similar_properties as $feature_property)
                        <div class="slick-slide-item">
                            <div class="property-box-3">
                                <div class="property-thumbnail">
                                    <a href="{{$feature_property->property_detail_path()}}" class="property-img">
                                        @if($feature_property->premium_listing === 1)
                                            <div class="tag feature-tag">Premium</div>
                                        @elseif($feature_property->hot_listing === 1)
                                            <div class="tag feature-tag">HOT</div>
                                        @elseif($feature_property->super_hot_listing === 1)
                                            <div class="tag feature-tag">SUPER HOT</div>
                                        @endif
                                        @if($feature_property->image != null)
                                            <img class="d-block w-100" src="{{asset('storage/properties/'.$feature_property->image)}}" alt="properties"
                                                 onerror="this.src='{{asset('storage/properties/default-image.png')}}'"/>
                                        @else
                                            <img class="d-block w-100" src="{{asset('storage/properties/default-image.png')}}" alt="properties"
                                                 onerror="this.src='{{asset('storage/properties/default-image.png')}}'"/>
                                        @endif
                                    </a>
                                </div>
                                <div class="details" style="margin: 0; width: 100%">
                                    <div class="top">
                                        <h2 class="title">
                                            <a href="{{$feature_property->property_detail_path()}}">
                                                PKR {{ \Illuminate\Support\Str::limit(explode(',',Helper::getPriceInWords($feature_property->price))[0], 10, $end='...') }}
                                            </a></h2>
                                        <div class="location">
                                            <a href="javascript:void(0);" tabindex="0">
                                                <i class="fas fa-map-marker-alt"></i> {{\Illuminate\Support\Str::limit($feature_property->location, 10, $end='...')}}, <span
                                                    class="grid-area">{{\Illuminate\Support\Str::limit($feature_property->city, 5, $end='...')}}</span>
                                            </a>
                                        </div>
                                    </div>
                                    <ul class="facilities-list clearfix">
                                        @if($feature_property->bedrooms > 0)
                                            <li style="width: 25%" class="grid-area">
                                                <i class="flaticon-furniture"></i>
                                                <p>{{ number_format($feature_property->bedrooms) }} Beds</p>
                                            </li>
                                        @endif
                                        @if($feature_property->bathrooms > 0)
                                            <li style="width: 25%; text-align: right" class="grid-area">
                                                <i class="flaticon-holidays"></i>
                                                <p>{{ number_format($feature_property->bathrooms) }} Bath</p>
                                            </li>
                                        @endif
                                        <li style="width: 50%; margin-top: 3px" class="area-md">
                                            <i class="fas fa-arrows-alt"></i>
                                            <p>{{ number_format($feature_property->land_area) }} @if($feature_property->area_unit === 'Square Meters')
                                                    Sq.M. @elseif($feature_property->area_unit === 'Square Feet') Sq.F. @elseif ($feature_property->area_unit === 'Square Yards')
                                                    Sq.Yd. @else {{$feature_property->area_unit}} @endif</p>
                                        </li>
                                    </ul>
                                    <div class="footer clearfix">
                                        <div class="float-left days">
                                            <p><i class="flaticon-time"></i> {{ (new \Illuminate\Support\Carbon($feature_property->created_at))->diffForHumans() }}</p>
                                        </div>
                                        <ul class="float-right">
                                            @if(\Illuminate\Support\Facades\Auth::check())
                                                <li>
                                                    <div class="favorite-property" style="font-size: 20px;">
                                                        <a href="javascript:void(0);"
                                                           style="color: black; display: {{$feature_property->user_favorite === \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()? 'none':'block' }}"
                                                           class="favorite" data-id="{{$feature_property->id}}">
                                                            <i class="fal fa-heart empty-heart"></i>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                           style="color: black; display : {{$feature_property->user_favorite === \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier() ? 'block':'none'}}"
                                                           class="remove-favorite" data-id="{{$feature_property->id}}">
                                                            <i class="fas fa-heart filled-heart" style="color: red;"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                            @else
                                                <li>
                                                    <div class="favorite-property " style="font-size: 20px;">
                                                        <a data-toggle="modal" data-target="#exampleModalCenter" style="color: black;" class="favourite">
                                                            <i class="fal fa-heart empty-heart"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Modal -->

{{--                <div class="slick-btn">--}}
                {{--                    <div class="slick-prev slick-arrow-buton">--}}
                {{--                        <i class="fa fa-angle-left"></i>--}}
                {{--                    </div>--}}
                {{--                    <div class="slick-next slick-arrow-buton">--}}
                {{--                        <i class="fa fa-angle-right"></i>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="width:80%">
            <div class="modal-body">
                <button type="button" class="close pt-0" data-dismiss="modal" aria-label="Close"
                        style="padding: 1rem; margin: -1rem -1rem -1rem auto;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="container mt-2">
                    <a href="{{route('login')}}" class="btn btn-block btn-outline">Login</a>
                    <a href="{{route('register')}}" class="btn btn-block btn-outline">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
