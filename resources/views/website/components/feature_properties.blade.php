@foreach($featured_properties as $feature_property)
    <div class="slick-slide-item">
        <div class="property-box-3" aria-label="listing link">
            @if($feature_property->id < 104280)
                <a href="{{$feature_property->property_detail_path()}}" class="property-img" title="{{$feature_property->title}}">
                    @else
                        <a href="{{route('properties.show',[
                    'slug'=>Str::slug($feature_property->city) . '-' .Str::slug($feature_property->location) . '-' . Str::slug($feature_property->title) . '-' . $feature_property->reference,
                    'property'=>$feature_property->id])}}" class="property-img" title="{{$feature_property->title}}">
                            @endif


                            <div class="property-thumbnail">
                                {{--                    @if($feature_property->platinum_listing)--}}
                                {{--                        <div class="tag feature-tag">Platinum</div>--}}
                                {{--                    @elseif($feature_property->silver_listing)--}}
                                {{--                        <div class="tag feature-tag">Silver</div>--}}
                                {{--                    @elseif($feature_property->golden_listing)--}}
                                {{--                        <div class="tag feature-tag">Golden</div>--}}
                                {{--                    @elseif($feature_property->bronze_listing)--}}
                                {{--                        <div class="tag feature-tag">Bronze</div>--}}
                                {{--                    @endif--}}
                                @if($feature_property->user_id !== 1 && $feature_property->image != null)
                                    <img class="d-block w-100" src="{{asset('thumbnails/properties/'.explode('.',$feature_property->image)[0].'-450x350.webp')}}"
                                         alt="{{\Illuminate\Support\Str::limit($feature_property->title, 20, $end='...')}}"
                                         title="{{$feature_property->title}}" onerror="this.src='{{asset('img/logo/dummy-logo.png')}}'"/>
                                @else
                                    <img class="d-block w-100" src="{{asset('img/logo/dummy-logo.png')}}" alt="properties"/>
                                @endif
                                <div class="listing-time opening" aria-label="purpose label">For {{ $feature_property->purpose }}</div>
                                <div class="price-ratings-box">
                                    <p class="price price-line">
                                        <span class="color-white" aria-label="price"><i class="fas fa-eye"></i> {{ $feature_property->views}}</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                        <div class="details m-0" style="width: 100%">
                            <div class="top">
                                <h2 class="title">
                                    <!-- method to convert price in number into price in words -->

                                    @if($feature_property->id < 104280)
                                        <a href="{{route('properties.show',[
                                        'slug'=>Str::slug($feature_property->location) . '-' . Str::slug($feature_property->title) . '-' . $feature_property->reference,
                                        'property'=>$feature_property->id])}}"
                                    @else
                                        <a href="{{route('properties.show',[
                                        'slug'=>Str::slug($feature_property->city) . '-' .Str::slug($feature_property->location) . '-' . Str::slug($feature_property->title) . '-' . $feature_property->reference,
                                        'property'=>$feature_property->id])}}" @endif

                                        data-bs-toggle="popover" data-bs-placement="right" data-bs-html="true"
                                           data-bs-content='<div class="row mt-1">
                                                <div class="col-md-12 color-white"><h6 class="color-white">Area Info</h6> <hr class="solid"></div>
                                                <div class="col-md-12 mb-1 mt-1">{{ number_format($feature_property->area_in_sqft,2) }} Sq.Ft.</div>
                                                <div class="col-md-12 mb-1">{{ number_format($feature_property->area_in_sqyd,2) }} Sq.Yd.</div>
                                                <div class="col-md-12 mb-1">{{ number_format($feature_property->area_in_sqm,2) }} Sq.M.</div>
                                                <div class="col-md-12 mb-1">{{ number_format($feature_property->area_in_new_marla,2) }} Marla </div>
                                                <div class="col-md-12 mb-1">{{ number_format($feature_property->area_in_new_kanal,2) }} Kanal </div>
                                           </div>'

                                        @if($feature_property->price !== 0 || $feature_property->price !== null)
                                            <span class="font-size-14 color-yellow">PKR</span> {{str_replace('Thousand','K',Helper::getPriceInWords($feature_property->price))}}
                                        @else
                                            <span class="font-size-14 color-blue">Call Us to Get More Details</span>
                    @endif
                </a>
                </h2>
                <div class="location">
                    <a href="javascript:void(0)" aria-label="Listing location">
                        <i class="fa fa-map-marker"></i>
                        {{ \Illuminate\Support\Str::limit($feature_property->location , 12, $end='...')}}
                        <span class="grid-area hidden-md">, {{ \Illuminate\Support\Str::limit($feature_property->city, 11, $end='...') }}</span>
                    </a>
                    <div class="mt-3 property-description">
                        @if($feature_property->id < 104280)
                            <a href="{{route('properties.show',[
                                        'slug'=>Str::slug($feature_property->location) . '-' . Str::slug($feature_property->title) . '-' . $feature_property->reference,
                                        'property'=>$feature_property->id])}}"
                        @else
                            <a href="{{route('properties.show',[
                                        'slug'=>Str::slug($feature_property->city) . '-' .Str::slug($feature_property->location) . '-' . Str::slug($feature_property->title) . '-' . $feature_property->reference,
                                        'property'=>$feature_property->id])}}" @endif
                            title="{{$feature_property->sub_type}} for {{$feature_property->purpose}}"
                               class="color-blue text-transform">
                                {{\Illuminate\Support\Str::limit(strtolower($feature_property->title), 27, $end='..')}}
                            </a>
                    </div>
                </div>
        </div>
        <ul class="facilities-list clearfix">
            <li style="width: 40%; margin-top: 3px;text-align: center" data-toggle="tooltip" data-placement="top" data-html="true"
{{--                title='<div class="row mt-1">--}}
{{--                           <div class="col-md-12 color-white"><h6 class="color-white">Area Info</h6> <hr class="solid"></div>--}}
{{--                           <div class="col-md-12 mb-1  mt-1"> {{ number_format($feature_property->area_in_sqft,2) }} Sq.Ft.</div>--}}
{{--                           <div class="col-md-12 mb-1"> {{ number_format($feature_property->area_in_sqyd,2) }} Sq.Yd.</div>--}}
{{--                           <div class="col-md-12 mb-1"> {{ number_format($feature_property->area_in_sqm,2) }} Sq.M.</div>--}}
{{--                           <div class="col-md-12 mb-1"> {{ number_format($feature_property->area_in_new_marla,2) }} Marla</div>--}}
{{--                           <div class="col-md-12 mb-1"> {{ number_format($feature_property->area_in_new_kanal,2) }} Kanal </div>--}}
{{--                           </div>'--}}
            >
                <i class="fas fa-arrows-alt"></i>
                <p>{{ number_format($feature_property->land_area, 2) }}
                    @if($feature_property->area_unit === 'Square Meters')
                        Sq.M.
                    @elseif($feature_property->area_unit === 'Square Feet')
                        Sq.F.
                    @elseif ($feature_property->area_unit === 'Square Yards')
                        Sq.Yd.
                    @else
                        {{$feature_property->area_unit}}
                    @endif</p>
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
            <ul class="float-right fav-section-index">
                @if(\Illuminate\Support\Facades\Auth::guard('web')->check())
                    <li>
                        <div class="favorite-property" style="font-size: 20px;">
                            <a href="javascript:void(0);" title="Add to favorite"
                               style="display: {{$feature_property->user_favorite === \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()? 'none':'block' }}"
                               class="favorite" data-id="{{$feature_property->id}}">
                                <i class="fal fa-heart empty-heart color-black"></i>
                            </a>
                            <a href="javascript:void(0);" title="Add to favorite"
                               style="display : {{$feature_property->user_favorite === \Illuminate\Support\Facades\Auth::guard('web')->user()->getAuthIdentifier() ? 'block':'none'}}"
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
                <p><i class="flaticon-time"></i> {{ (new \Illuminate\Support\Carbon($feature_property->activated_at))->diffForHumans(['parts' => 2]) }}</p>
            </div>
        </div>

    </div>
    </a>
    </div>
    </div>
@endforeach
