@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}" async defer>
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/image-carousel-style.css')}}" async defer>
    <link rel="stylesheet" href="{{asset('plugins/intl-tel-input/css/intlTelInput.min.css')}}" async defer>

@endsection

@section('content')
    {{--    @include('website.includes.main_header')--}}
    <!-- Sub banner start -->
    @include('website.includes.nav')
    @include('website.includes.banner2')
    @include('website.includes.search2')

    {{--    <div class="properties-details-page  content-area-7">--}}
    <div class="properties-page2 properties-details-page content-area-7" id="details-page">
        @php $links = Share::currentPage()
                                        ->facebook()
                                        ->twitter()
                                        ->linkedin('Extra linkedin summary can be passed here')
                                        ->whatsapp()
                                        ->getRawLinks(); @endphp

        <div>
            <div class="container inline-search-area area-width property-detail-bg-style">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-7 col-sm-12 my-auto">
                        <div itemscope itemtype="http://schema.org/BreadcrumbList" aria-label="Breadcrumb" class="breadcrumbs mb-2 breadcrumb-line-height">
                                <span itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                                    <a href="{{asset('https://www.aboutpakistan.com/')}}" title="AboutPakistan" itemprop="item">
                                        <span class="breadcrumb-link" itemprop="name">Home</span></a>
                                    <meta itemprop="position" content="1">
                                </span>
                            <span class="mx-2" aria-label="Link delimiter"> <i class="fal fa-greater-than"></i></span>
                            <span itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                                    <a href="{{asset('/')}}" title="Property Portal" itemprop="item">
                                        <span itemprop="name" class="m-0">Property</span></a>
                                    <meta itemprop="position" content="2"></span>

                            <span class="mx-2"> <i class="fal fa-greater-than"></i></span>

                            <span itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                                    <span
                                        itemprop="name"> {{$property->sub_type}} For {{$property->purpose}}<span> (<strong
                                                class="theme-dark-blue">Property ID: </strong>{{$property->id}})</span></span>
                                    <meta itemprop="position" content="3">
                                </span>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-5 col-sm-12 ">
                        <div class="pull-right social-links">
                            <span style="font-size: 14px;font-weight: 600;">Share To</span>
                            <a href="{{$links['whatsapp']}}" target="_blank">
                                <i class="fab fa-whatsapp fa-2x icon-padding" style="color: #48C458;"></i>
                            </a>
                            <a href="{{$links['facebook']}}" target="_blank">
                                <i class="fab fa-facebook-square fa-2x icon-padding" style="color:#3b5997;"></i>
                            </a>
                            <a href="{{$links['twitter']}}" target="_blank">
                                <i class="fab fa-twitter fa-2x icon-padding" style="color:#00aced;"></i>
                            </a>
                            <a href="{{$links['linkedin']}}" target="_blank">
                                <i class="fab fa-linkedin fa-2x icon-padding" style="color: #069;"></i>
                            </a>
                        </div>

                    </div>
                </div>


                <div class="heading-properties-2">
                    <div class="row">
                        <div class="col-md-12">


                            <div><h1 class="property-detail-title" aria-label="Property header">{{$property->title}}</h1></div>
                            <div class="pull-left">
                                <h2 style="font-weight: 400; font-size:20px;">
                                    @if($property->price != 0)
                                        <span aria-label="currency"> PKR </span> <span aria-label="price"> {{Helper::getPriceInWords($property->price)}}</span>
                                    @endif
                                </h2>
                                <h6 class="color-555" style="font-weight: 400; font-size:14px;"><i class="fa fa-map-marker"></i> {{ $property->location }}, {{ $property->city }}</h6>
                            </div>
                            <div class="pull-right">


                                @if($property->price != 0)
                                    <h3><span class="text-right"> <span aria-label="currency"> PKR </span> <span aria-label="price">  {{$property->price}}</span></span></h3>
                                @endif

                                <div class="ratings stars" data-rating="{{$property->views > 0 ? (($property->favorites/$property->views)*5) : 0}}"
                                     data-num-stars="5" aria-label="rating"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="spinner-border text-primary"></div>
        <div class="container">

            <div class="row">
                <div class="col-lg-8 col-md-12 col-xs-12">

                    <div class="properties-details-section">
                        <div id="propertiesDetailsSlider" class="carousel properties-details-sliders slide mb-40">
                            <!-- Heading properties start -->
                        @if(!$property->images->isEmpty() && $property->user_id !== 1)
                            <!-- main slider carousel items -->
                                @include('website.includes.property_detail_images')
                            @else
                                <div style="text-align: center">
                                    <img src="{{asset("/img/logo/dummy-logo.png")}}" alt="{{$property->title}}" title="{{$property->title}}"/>
                                    <div class="price-ratings-box detail-page-fav" data-id="{{$property->id}}">
                                        @if(\Illuminate\Support\Facades\Auth::guard('web')->guest())
                                            <div class="favorite-property ratings" style="font-size: 20px;">
                                                <a data-toggle="modal" data-target="#exampleModalCenter" style="color: white;" class="favourite">
                                                    <i class="fal fa-heart empty-heart"></i>
                                                </a>
                                            </div>
                                        @else
                                            <div class="favorite-property ratings" style="font-size: 20px;">
                                                <a href="javascript:void(0);"
                                                   style="color: white; display: {{$is_favorite? 'none': 'block'}} ;" class="detail-favorite" data-id="{{$property->id}}">
                                                    <i class="fal fa-heart empty-heart"></i>
                                                </a>
                                                <a href="javascript:void(0);"
                                                   style="color: black; display : {{$is_favorite? 'block': 'none'}};" class="detail-remove-favorite" data-id="{{$property->id}}">
                                                    <i class="fas fa-heart filled-heart" style="color: red;"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            @endif
                        </div>

                        <!-- Modal -->

                        <!-- Tabbing box start -->
                        <div class="tabbing tabbing-box tb-2 mb-40">
                            <ul class="nav nav-tabs detail-tab-style" id="carTab" role="tablist">
                                <li class="nav-item li-detail-page mr-1">
                                    <a class="text-transform nav-link active show detail-nav-style" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="one" aria-selected="true">Overview</a>
                                </li>
                                <li class="nav-item li-detail-page text-transform mr-1">
                                    <a class="nav-link detail-nav-style" id="2-tab" href="#two" role="tab" aria-controls="2" aria-selected="true">Location & Nearby</a>
                                </li>
                                @if(count($property->videos) > 0)
                                    <li class="nav-item li-detail-page text-transform">
                                        <a class="nav-link detail-nav-style" id="3-tab" href="#three" role="tab" aria-controls="3" aria-selected="true">Video</a>
                                    </li>
                                @endif
                                {{--                                @if(count($similar_properties) > 3)--}}
                                {{--                                <li class="nav-item li-detail-page text-transform mr-1">--}}
                                {{--                                    <a class="nav-link detail-nav-style" id="4-tab" href="#four" role="tab" aria-controls="4" aria-selected="true">Similar Properties</a>--}}
                                {{--                                </li>--}}
                                {{--                                @endif--}}
                            </ul>
                        </div>
                        <div class="tab-pane" id="one" role="tabpanel" aria-labelledby="one-tab">
                            <div class="properties-description mb-50">
                                <!-- Properties detail start -->
                                <div class="property-details mb-20 detail-overview-style">
                                    <h5 style="font-weight: 400">Details</h5>
                                    <div class="s-border"></div>
                                    <div class="m-border"></div>
                                    <div class="row">

                                        @if($property->price != 0)
                                            <div class="col-md-4 col-sm-6 mb-3 fs-14">
                                                <strong>Price: </strong>PKR {{ $property->price }}
                                            </div>
                                        @else
                                            <div class="col-md-4 col-sm-6 mb-3 fs-14">
                                                <strong>Price: </strong>Call Us for Price Details
                                            </div>
                                        @endif
                                        <div class="col-md-4 col-sm-6 mb-3 fs-14">
                                            <strong>Property Type: </strong> {{ $property->sub_type }}
                                        </div>
                                        @if($property->city)
                                            <div class="col-md-4 col-sm-6 mb-3 fs-14">
                                                <strong>City: </strong>{{$property->city}}
                                            </div>
                                        @endif
                                        <div class="col-md-4 col-sm-6 mb-3 fs-14">
                                            <strong>Added: </strong>{{ (new \Illuminate\Support\Carbon($property->created_at))->diffForHumans() }}
                                        </div>


                                        @if(isset($property->land_area))
                                            <div class="col-md-4 col-sm-6 mb-3 fs-14">
                                                <strong>Land area: </strong>{{ number_format($property->land_area) }} {{ $property->area_unit }}
                                            </div>
                                        @endif
                                        @if($property->bathrooms > 0)
                                            <div class="col-md-4 col-sm-6 mb-3 fs-14">
                                                <strong>Bathrooms: </strong>{{number_format($property->bathrooms)}}
                                            </div>
                                        @endif
                                        @if($property->bedrooms > 0)
                                            <div class="col-md-4 col-sm-6 mb-3 fs-14">
                                                <strong>Bedrooms: </strong>{{ number_format($property->bedrooms) }}
                                            </div>
                                        @endif
                                        <div class="col-md-4 col-sm-6 mb-3 fs-14">
                                            <strong>Listed By: </strong>{{$property->contact_person}}
                                        </div>
                                        @if(isset($property->phone))
                                            <div class="col-md-4 col-sm-6 mb-3 fs-14">
                                                <strong>Phone: </strong>{{$property->phone}}
                                            </div>
                                        @endif

                                    </div>
                                </div>

                                <!-- Properties description start -->
                                <div class="property-description mb-20 detail-overview-style">
                                    <h5 style="font-weight: 400">Description</h5>
                                    <div class="s-border"></div>
                                    <div class="m-border"></div>
                                    @if($property->user_id != 1)
                                        <p class="description" aria-label="property description">
                                            {{str_replace('While Calling','',str_replace('For More Information Please Contact','',str_replace('Please Mention Zameen. com','', str_replace('Zameen','AboutPakistan',str_replace('zameen','AboutPakistan',$property->description)))))}}</p>
                                    @endif
                                    <p>Contact us for more details. While calling please mention <a class="color-blue" href="https://www.aboutpakistan.com">aboutpakistan.com</a></p>
                                    @if($property->user_id != 1)
                                        <button role="button" class="btn-outline-primary button" style="border: none">Read More</button>@endif
                                </div>
                                <!-- Properties condition start -->
                                <!-- Properties amenities start -->
                                @if($property->features !== null)
                                    <div class="properties-amenities mb-40 detail-overview-style">
                                        <h5 style="font-weight: 400">Features</h5>
                                        <div class="s-border"></div>
                                        <div class="m-border"></div>

                                        <div class="features-list">
                                            <div class="row amenities custom-amenities">
                                                @foreach(json_decode($property->features,true)['features'] as $key => $value)
                                                    @if(!(in_array($value, ['0',  'null', 'no', 'None', null])) && !(in_array($key, ['data-index',  '_method', 'call_for_price_inquiry',  'property_id', 'agency','property_reference','property_subtype_Homes','property_subtype_Plots','property_subtype_Commercial','phone_#','mobile_#'])))

                                                        <div class="col-sm-4 my-2 py-2 icon-list">
                                                            @if(json_decode($property->features,true)['icons'][$key.'-icon'] == 'flaticon-vehicle')
                                                                <i class="fal fa-garage-car"
                                                                   style="color: #274abb; font-size: 16px;"></i>
                                                            @elseif(json_decode($property->features,true)['icons'][$key.'-icon'] == 'flaticon-furniture')
                                                                <i class="fal fa-bed-alt"
                                                                   style="color: #274abb; font-size: 16px;"></i>
                                                            @elseif(json_decode($property->features,true)['icons'][$key.'-icon'] == 'flaticon-technology')
                                                                <i class="fal fa-air-conditioner"
                                                                   style="color: #274abb; font-size: 16px;"></i>
                                                            @elseif(json_decode($property->features,true)['icons'][$key.'-icon'] == 'flaticon-technology')
                                                                <i class="fal fa-air-conditioner"
                                                                   style="color: #274abb; font-size: 16px;"></i>
                                                            @else
                                                                <i class="{{json_decode($property->features,true)['icons'][$key.'-icon']}}"
                                                                   style="color: #274abb; font-size: 16px;"></i>
                                                            @endif
                                                            {{ $value ==='yes' ? '' : $value}} {{str_replace('_',' ',$key)}}
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <button class="btn-outline-primary button2 show-features" style="border: none; margin-top: 5px;display: none">Show More</button>
                                    </div>


                                @endif
                            </div>
                        </div>
                        <div class="tab-pane h-25" id="two" role="tabpanel" aria-labelledby="2-tab">
                            <div class="location mb-50">
                                <h3 class="heading-2">Location and Nearby</h3>
                                @include('website.includes.location_and_nearby')
                            </div>
                        </div>

                        @if(count($property->videos) > 0)
                            <div class="tab-pane " id="three" role="tabpanel" aria-labelledby="3-tab">
                                <div class="inside-properties">
                                    <h3 class="heading-2">
                                        Property Video
                                    </h3>
                                    {{-- TODO: apply check on video link restict user to add video of following 3rd party --}}
                                    @if($property->videos[0]['host'] === 'Youtube')
                                        <iframe src={{"https://www.youtube.com/embed/".explode('#',explode('?v=',$property->videos[0]['name'])[1])[0]}}></iframe>
                                    @elseif($property->videos[0]['host'] === 'Vimeo')
                                        <iframe src={{"https://player.vimeo.com/video/".explode('.com/',$property->videos[0]['name'])[1]}}></iframe>
                                    @else
                                        <iframe src={{"//www.dailymotion.com/embed/video/".explode('?',explode('video/',$property->videos[0]['name'])[1])[0]."?quality=240&info=0&logo=0"}}></iframe>
                                    @endif
                                </div>
                            </div>
                        @endif
                        <div class="tab-pane" id="four" role="tabpanel" aria-labelledby="4-tab">
                            @include('website.includes.similar_properties')
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="sidebar-right mt-0">
                        <!-- Advanced search start -->
                        @include('website.includes.contact_agent')
                        <hr>
                        {{--                        @if(!empty($agency))--}}
                        @if($property->agency)
                            <div class="sidebar widget mb-2 none-992">
                                <h3 class="sidebar-title" data-toggle="popover" data-trigger="hover" title="{{$property->agency->title}}"
                                    data-placement="bottom"
                                    data-html='true'
                                    data-content='<div>
                                                @if($property_count > 0)
                                        <span class="float-left color-blue">Total Properties: {{$property_count}}</span>
                                                @endif
                                        <span class="float-right color-blue">Partner Since: {{ (new \Illuminate\Support\Carbon($property->agency->created_at))->diffForHumans(['parts' => 2]) }}</span>
                                    <br \>
                                    <div>@if($property->user_id !== 1){{$property->agency->description}}@endif</div>'>{{ucwords($property->agency->title)}} </h3>
                                <div class="s-border"></div>
                                <div class="m-border"></div>
                                <div class="row">
                                    {{--                                    {{dd($property->agency_property_count)}}--}}
                                    @if($property->agency->logo !==null)
                                        <div class="col-sm-6 text-center">
                                            <img
                                                src="{{ isset($property->agency->logo) && $property->user_id !== 1? asset('thumbnails/agency_logos/'.explode('.',$property->agency->logo)[0].'-450x350.webp'): asset("/img/logo/dummy-logo.png")}}"
                                                alt="{{ucwords($property->agency->title)}}" style="max-width: 80%" data-toggle="popover" data-trigger="hover" title="{{$property->agency->title}}"
                                                data-placement="bottom"
                                                data-html='true'
                                                data-content='<div>
                                                @if($property_count > 0)
                                                    <span class="float-left color-blue">Total Properties: {{$property_count}}</span>
                                                @endif
                                                    <span class="float-right color-blue">Partner Since: {{ (new \Illuminate\Support\Carbon($property->agency->created_at))->diffForHumans(['parts' => 2]) }}</span>
                                    <br \>
                                    <div>@if($property->user_id !== 1){{$property->agency->description}}@endif</div>'>
                                        </div>
                                    @endif
                                    <div class="col-sm-6 mt-1">
                                        <div style="font-size: 1rem">
                                            @if($property->agency->status === 'verified')
                                                <div class="mb-3">
                                                    <span style="color:green" data-toggle="tooltip" data-placement="top"
                                                          title="{{$property->agency->title}} is our verified partner. To become our trusted partner, simply contact us or call us at +92 51 4862317 OR +92 315 5141959"><i
                                                            class="far fa-shield-check"></i></span>
                                                </div>
                                            @endif
                                            @if($property->agency->featured_listing === 1)
                                                <div class="mb-3">
                                                <span class="premium-badge" style="color:#ffcc00;">
                                                    <i class="fas fa-star"></i>
                                                    <span style="color: white">FEATURED PARTNER</span>
                                                </span>
                                                </div>
                                            @endif
                                            @if($property->agency->key_listing === 1)
                                                <div class="mb-3">
                                                <span class="premium-badge" style="color:#ffcc00;">
                                                    <i class="fas fa-star"></i>
                                                    <span style="color: white">KEY PARTNER</span>
                                                </span>
                                                </div>
                                            @endif
                                            @if($property->agency->ceo_name !== null)
                                                <div style="font-size: 14px !important;"><i class="fas fa-user p-1"></i><span>{{$property->agency->ceo_name}} </span></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer start -->
    @include('website.includes.footer')
    <div class="fly-to-top back-to-top">
        <i class="fa fa-angle-up fa-3"></i>
        <span class="to-top-text">To Top</span>
    </div><!--fly-to-top-->
    <div class="fly-fade">
    </div><!--fly-fade-->
@endsection


@section('script')
    <script src="{{asset('plugins/intl-tel-input/js/intlTelInput.min.js')}}" defer></script>

    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}" defer></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/jssor.slider-28.0.0.min.js')}}"></script>
    <script type="text/javascript" defer>jssor_1_slider_init();  </script>
    <script src="{{asset('website/js/markerclusterer.js')}}" async defer></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&libraries=places" async defer></script>
    <script src="{{asset('website/js/script-custom.min.js')}}" defer></script>
    <script src="{{asset('website/js/cookie.min.js')}}" defer></script>
    <script src="{{asset('website/js/detail-page.js')}}" defer></script>
    <script src="{{ asset('js/share.js') }}"></script>


@endsection
