@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset("website/fonts/font-awesome/css/font-awesome.min.css")}}">
@endsection
@section('css_library')
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')
    {{--    @include('website.includes.main_header')--}}
    <!-- Sub banner start -->
    @include('website.includes.top_header2')
    @include('website.includes.banner2')
    @include('website.includes.search2')
    <div class="properties-details-page content-area-7">
        <div class="container">
            <div class="row">

                <div class="col-lg-8 col-md-12 col-xs-12">
                    <div class="properties-details-section">
                        <div id="propertiesDetailsSlider" class="carousel properties-details-sliders slide mb-40">
                            <!-- Heading properties start -->
                            <div itemscope itemtype="http://schema.org/BreadcrumbList" aria-label="Breadcrumb" class="breadcrumbs mb-2">
                        <span itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                        <a href="{{asset('/')}}" title="PropertyManagement" itemprop="item">
                            <span itemprop="name" class="m-0">PropertyManagement</span></a>
                            <meta itemprop="position" content="1"></span>
                                <span class="mx-2"> <i class="fal fa-greater-than"></i></span>
                                <span itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                            <a href="javascript:void(0)" title="{{$property->title}}" itemprop="item"><span itemprop="name"> {{$property->title}}</span></a>
                            <meta itemprop="position" content="2">
                        </span>
                            </div>
                            <div class="heading-properties-2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div><h1 class="property-detail-title" aria-label="Property header">{{$property->title}}</h1></div>
                                        <div class="pull-left">
                                            <h2 style="font-weight: 400; font-size:20px;">
                                                <span aria-label="currency"> PKR </span> <span aria-label="price"> {{Helper::getPriceInWords($property->price)}}</span>
                                            </h2>
                                            <h6 class="color-555" style="font-weight: 400; font-size:14px;"><i class="fa fa-map-marker"></i> {{ $property->location }}, {{ $property->city }}</h6>
                                        </div>
                                        <div class="pull-right">
                                            <h3><span class="text-right"> <span aria-label="currency"> PKR </span> <span aria-label="price">  {{$property->price}}</span></span></h3>
                                            <div class="ratings stars" data-rating="{{$property->views > 0 ? (($property->favorites/$property->views)*5) : 0}}"
                                                 data-num-stars="5" aria-label="rating"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container mt-5">
                                <div class="carousel-container position-relative row">

                                    <!-- Sorry! Lightbox doesn't work - yet. -->

                                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active" data-slide-number="0">
                                                <div class="price-ratings-box">
                                                    @if(\Illuminate\Support\Facades\Auth::guest())
                                                        <div class="favorite-property ratings" style="font-size: 20px;">
                                                            <a data-toggle="modal" data-target="#exampleModalCenter" style="color: white;" class="favourite">
                                                                <i class="fal fa-heart empty-heart"></i>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="favorite-property ratings" style="font-size: 20px;">
                                                            <a href="javascript:void(0);"
                                                               style="color: black; display: {{$is_favorite? 'none': 'block'}} ;" class="favorite" data-id="{{$property->id}}">
                                                                <i class="fal fa-heart empty-heart"></i>
                                                            </a>
                                                            <a href="javascript:void(0);"
                                                               style="color: black; display : {{$is_favorite? 'block': 'none'}};" class="remove-favorite" data-id="{{$property->id}}">
                                                                <i class="fas fa-heart filled-heart" style="color: red;"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                                <img src="https://source.unsplash.com/Pn6iimgM-wo/1600x900/" class="d-block w-100" alt="..." data-remote="https://source.unsplash.com/Pn6iimgM-wo/" data-type="image"  data-toggle="lightbox" data-gallery="example-gallery">

                                            </div>
                                            <div class="carousel-item" data-slide-number="1">
                                                <img src="https://source.unsplash.com/tXqVe7oO-go/1600x900/" class="d-block w-100" alt="..." data-remote="https://source.unsplash.com/tXqVe7oO-go/" data-type="image" data-toggle="lightbox" data-gallery="example-gallery">
                                            </div>
                                            <div class="carousel-item" data-slide-number="2">
                                                <img src="https://source.unsplash.com/qlYQb7B9vog/1600x900/" class="d-block w-100" alt="..." data-remote="https://source.unsplash.com/qlYQb7B9vog/" data-type="image" data-toggle="lightbox" data-gallery="example-gallery">
                                            </div>
                                            <div class="carousel-item" data-slide-number="3">
                                                <img src="https://source.unsplash.com/QfEfkWk1Uhk/1600x900/" class="d-block w-100" alt="..." data-remote="https://source.unsplash.com/QfEfkWk1Uhk/" data-type="image" data-toggle="lightbox" data-gallery="example-gallery">
                                            </div>
                                            <div class="carousel-item" data-slide-number="4">
                                                <img src="https://source.unsplash.com/CSIcgaLiFO0/1600x900/" class="d-block w-100" alt="..." data-remote="https://source.unsplash.com/CSIcgaLiFO0/" data-type="image" data-toggle="lightbox" data-gallery="example-gallery">
                                            </div>
                                            <div class="carousel-item" data-slide-number="5">
                                                <img src="https://source.unsplash.com/a_xa7RUKzdc/1600x900/" class="d-block w-100" alt="..." data-remote="https://source.unsplash.com/a_xa7RUKzdc/" data-type="image" data-toggle="lightbox" data-gallery="example-gallery">
                                            </div>
                                            <div class="carousel-item" data-slide-number="6">
                                                <img src="https://source.unsplash.com/uanoYn1AmPs/1600x900/" class="d-block w-100" alt="..." data-remote="https://source.unsplash.com/uanoYn1AmPs/" data-type="image" data-toggle="lightbox" data-gallery="example-gallery">
                                            </div>
                                            <div class="carousel-item" data-slide-number="7">
                                                <img src="https://source.unsplash.com/_snqARKTgoc/1600x900/" class="d-block w-100" alt="..." data-remote="https://source.unsplash.com/_snqARKTgoc/" data-type="image" data-toggle="lightbox" data-gallery="example-gallery">
                                            </div>
                                            <div class="carousel-item" data-slide-number="8">
                                                <img src="https://source.unsplash.com/M9F8VR0jEPM/1600x900/" class="d-block w-100" alt="..." data-remote="https://source.unsplash.com/M9F8VR0jEPM/" data-type="image" data-toggle="lightbox" data-gallery="example-gallery">
                                            </div>
                                            <div class="carousel-item" data-slide-number="9">
                                                <img src="https://source.unsplash.com/Q1p7bh3SHj8/1600x900/" class="d-block w-100" alt="..." data-remote="https://source.unsplash.com/Q1p7bh3SHj8/" data-type="image" data-toggle="lightbox" data-gallery="example-gallery">
                                            </div>
                                        </div>
                                        <!--Controls-->
                                        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                                            <i class="fa fa-angle-left fa-2x" style="padding-left:30px;"></i>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                                            <i class="fa fa-angle-right fa-2x" style="padding-right:30px;"></i>
                                            <span class="sr-only">Next</span>
                                        </a>
                                        <!--/.Controls-->

                                    </div>



                                </div> <!-- /row -->
                            </div> <!-- /container -->
                            <!-- Carousel Navigation -->
                            <div id="carousel-thumbs" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="row mx-0">
                                            <div id="carousel-selector-0" class="thumb col-4 col-sm-2 px-1 py-2 selected" data-target="#myCarousel" data-slide-to="0">
                                                <img src="https://source.unsplash.com/Pn6iimgM-wo/600x400/" class="img-fluid" alt="...">
                                            </div>
                                            <div id="carousel-selector-1" class="thumb col-4 col-sm-2 px-1 py-2" data-target="#myCarousel" data-slide-to="1">
                                                <img src="https://source.unsplash.com/tXqVe7oO-go/600x400/" class="img-fluid" alt="...">
                                            </div>
                                            <div id="carousel-selector-2" class="thumb col-4 col-sm-2 px-1 py-2" data-target="#myCarousel" data-slide-to="2">
                                                <img src="https://source.unsplash.com/qlYQb7B9vog/600x400/" class="img-fluid" alt="...">
                                            </div>
                                            <div id="carousel-selector-3" class="thumb col-4 col-sm-2 px-1 py-2" data-target="#myCarousel" data-slide-to="3">
                                                <img src="https://source.unsplash.com/QfEfkWk1Uhk/600x400/" class="img-fluid" alt="...">
                                            </div>
                                            <div id="carousel-selector-4" class="thumb col-4 col-sm-2 px-1 py-2" data-target="#myCarousel" data-slide-to="4">
                                                <img src="https://source.unsplash.com/CSIcgaLiFO0/600x400/" class="img-fluid" alt="...">
                                            </div>
                                            <div id="carousel-selector-5" class="thumb col-4 col-sm-2 px-1 py-2" data-target="#myCarousel" data-slide-to="5">
                                                <img src="https://source.unsplash.com/a_xa7RUKzdc/600x400/" class="img-fluid" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="row mx-0">
                                            <div id="carousel-selector-6" class="thumb col-4 col-sm-2 px-1 py-2" data-target="#myCarousel" data-slide-to="6">
                                                <img src="https://source.unsplash.com/uanoYn1AmPs/600x400/" class="img-fluid" alt="...">
                                            </div>
                                            <div id="carousel-selector-7" class="thumb col-4 col-sm-2 px-1 py-2" data-target="#myCarousel" data-slide-to="7">
                                                <img src="https://source.unsplash.com/_snqARKTgoc/600x400/" class="img-fluid" alt="...">
                                            </div>
                                            <div id="carousel-selector-8" class="thumb col-4 col-sm-2 px-1 py-2" data-target="#myCarousel" data-slide-to="8">
                                                <img src="https://source.unsplash.com/M9F8VR0jEPM/600x400/" class="img-fluid" alt="...">
                                            </div>
                                            <div id="carousel-selector-9" class="thumb col-4 col-sm-2 px-1 py-2" data-target="#myCarousel" data-slide-to="9">
                                                <img src="https://source.unsplash.com/Q1p7bh3SHj8/600x400/" class="img-fluid" alt="...">
                                            </div>
                                            <div class="col-2 px-1 py-2"></div>
                                            <div class="col-2 px-1 py-2"></div>
                                        </div>
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carousel-thumbs" role="button" data-slide="prev">
                                    <i class="fa fa-angle-left fa-2x carousel-control-style" style="padding-left:30px;"></i>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carousel-thumbs" role="button" data-slide="next">
                                    <i class="fa fa-angle-right fa-2x carousel-control-style" style="padding-right:30px;"></i>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <!--Carousel Wrapper-->
                            <br>
                            <!--/.Carousel Wrapper-->
                        @if(!empty($images))
                            <!-- main slider carousel items -->
                                <div class="carousel-inner">
                                    @foreach($images as $key => $value)
                                        <div class="{{ $key===0 ? 'active' : '' }} item carousel-item" data-slide-number="{{$key}}">
                                            <img src="{{asset('storage/img/properties/'.$value)}}" class="img-fluid" alt="{{$property->title}}" title="{{$property->title}}"
                                                 onerror="this.src='{{asset('storage/img/properties/logo.jpg')}}'"/>
                                            <div class="price-ratings-box">
                                                @if(\Illuminate\Support\Facades\Auth::guest())
                                                    <div class="favorite-property ratings" style="font-size: 20px;">
                                                        <a data-toggle="modal" data-target="#exampleModalCenter" style="color: white;" class="favourite">
                                                            <i class="fal fa-heart empty-heart"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="favorite-property ratings" style="font-size: 20px;">
                                                        <a href="javascript:void(0);"
                                                           style="color: black; display: {{$is_favorite? 'none': 'block'}} ;" class="favorite" data-id="{{$property->id}}">
                                                            <i class="fal fa-heart empty-heart"></i>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                           style="color: black; display : {{$is_favorite? 'block': 'none'}};" class="remove-favorite" data-id="{{$property->id}}">
                                                            <i class="fas fa-heart filled-heart" style="color: red;"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- main slider carousel nav controls -->
                                <ul class="carousel-indicators smail-properties list-inline nav nav-justified">

                                    @foreach($images as $key => $value)
                                        <li class="list-inline-item {{$key===0?'active':''}}">
                                            <a id="{{'carousel-selector-'.strval((intval($key)+1))}}" class="{{$key===0?'selected':'' }}" data-slide-to="{{$key}}"
                                               data-target="#propertiesDetailsSlider">
                                                <img src="{{asset('storage/img/properties/'.$value)}}" class="img-fluid" alt="properties-small"
                                                     onerror="this.src='{{asset('storage/img/properties/logo.jpg')}}'"/>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="carousel-inner">
                                    <div class="active item carousel-item" data-slide-number="0">
                                        <img src="{{asset("storage/img/properties/default-image.png")}}" class="img-fluid" alt="slider-properties"/>
                                        <div class="price-ratings-box">
                                            @if (\Illuminate\Support\Facades\Auth::guest())
                                                <div class="favorite-property ratings" style="font-size: 20px;" aria-label="add to favourite">
                                                    <a data-toggle="modal" data-target="#exampleModalCenter" style="color: white;" class="favourite">
                                                        <i class="fal fa-heart empty-heart"></i>
                                                    </a>
                                                </div>
                                            @else
                                                <div class="favorite-property ratings" style="font-size: 20px;">
                                                    <a href="javascript:void(0);"
                                                       style="color: black; display: {{$is_favorite? 'none': 'block'}};" class="favorite" data-id="{{$property->id}}">
                                                        <i class="fal fa-heart empty-heart"></i>
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                       style="color: black; display : {{$is_favorite? 'block': 'none'}};" class="remove-favorite" data-id="{{$property->id}}" aria-label="add to favourite">
                                                        <i class="fas fa-heart filled-heart" style="color: red;"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- main slider carousel nav controls -->
                                <ul class="carousel-indicators smail-properties list-inline nav nav-justified">
                                    <li class="list-inline-item active">
                                        <a id="carousel-selector-1" class="selected" data-slide-to="0"
                                           data-target="#propertiesDetailsSlider">
                                            <img src="{{asset("storage/img/properties/default-image.png")}}" class="img-fluid" alt="slider-properties"/>
                                        </a>
                                    </li>
                                </ul>
                                <!-- main slider carousel items -->
                            @endif
                        </div>
                        <!-- Modal -->
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

                        <!-- Tabbing box start -->
                        <div class="tabbing tabbing-box tb-2 mb-40">
                            <ul class="nav nav-tabs" id="carTab" role="tablist" style="padding:5px; background-color: black">
                                <li class="nav-item li-detail-page">
                                    <a class="text-transform nav-link active show" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="one"
                                       aria-selected="true">Overview</a>
                                </li>
                                @if(!empty($video))
                                    <li class="nav-item li-detail-page text-transform">
                                        <a class="nav-link" id="4-tab" href="#four" role="tab" aria-controls="4" aria-selected="true">Video</a>
                                    </li>
                                @endif
                                <li class="nav-item li-detail-page text-transform">
                                    <a class="nav-link" id="5-tab" href="#five" role="tab" aria-controls="5" aria-selected="true">Location & Nearby</a>
                                </li>
                                @if(count($similar_properties))
                                    <li class="nav-item li-detail-page text-transform">
                                        <a class="nav-link" id="6-tab" href="#six" role="tab" aria-controls="6" aria-selected="true">Similar Properties</a>
                                    </li>
                                @endif
                            </ul>
                            <div class="tab-pane" id="one" role="tabpanel" aria-labelledby="one-tab">
                                <div class="properties-description mb-50">
                                    <h3 class="heading-2 text-transform">
                                        Overview
                                    </h3>
                                    <!-- Properties detail start -->
                                    <div class="property-details mb-40">
                                        <h5 style="font-weight: 400">Details</h5>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6">
                                                <ul>
                                                    <li aria-label="value"><strong>Price: </strong>PKR {{ $property->price }}</li>
                                                    <li aria-label="value"><strong>Property Type: </strong> {{ $property->sub_type }}</li>
                                                    @if($property->city)
                                                        <li aria-label="value"><strong>City: </strong>{{$property->city}}</li>
                                                    @endif
                                                    <li aria-label="value"><strong>Added: </strong>{{ (new \Illuminate\Support\Carbon($property->created_at))->diffForHumans() }}</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <ul>
                                                    @if(isset($property->land_area))
                                                        <li aria-label="value"><strong>Land area: </strong>{{ number_format($property->land_area) }} {{ $property->area_unit }} </li>
                                                    @endif
                                                    @if($property->bathrooms > 0)
                                                        <li aria-label="value"><strong>Bathrooms: </strong>{{number_format($property->bathrooms)}} </li>
                                                    @endif
                                                    @if($property->bedrooms > 0)
                                                        <li aria-label="value"><strong>Bedrooms: </strong>{{ number_format($property->bedrooms) }}</li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <ul>
                                                    <li aria-label="value"><strong>Property Owner: </strong>{{$property->contact_person}}</li>
                                                    @if(isset($property->phone))
                                                        <li aria-label="value"><strong>Phone: </strong>{{$property->phone}}</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Properties description start -->
                                    <div class="property-description mb-40">
                                        <h5 style="font-weight: 400">Description</h5>
                                        <p style="white-space: pre-line" class="description" aria-label="property description">{{$property->description}}</p>
                                        <button role="button" class="btn-outline-primary button" style="border: none">Read More</button>
                                    </div>
                                    <!-- Properties condition start -->
                                    <!-- Properties amenities start -->
                                    @if($property->features !== null)
                                        <div class="properties-amenities mb-40">
                                            <h3 class="heading-2">
                                                Features
                                            </h3>
                                            <div>
                                                <div class="features-list">
                                                    <ul class="amenities custom-amenities">
                                                        {{--   {{dd(json_decode($property->features,true)['features'])}}--}}
                                                        @foreach(json_decode($property->features,true)['features'] as $key => $value)
                                                            @if($value !== null && $value !== 'None' && $value !=='no' && $key !== '_method' && $key !== 'data-index' && $value !== '0')
                                                                <li class="mb-5">
                                                                    <i class="{{json_decode($property->features,true)['icons'][$key.'-icon']}}"></i>
                                                                    {{ $value ==='yes' ? '' : $value}} {{str_replace('_',' ',$key)}}
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <button class="btn-outline-primary button2" style="border: none; margin-top: 5px">Show More</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if(!empty(array_filter($floor_plans)))
                            <div class="tab-pane" id="two" role="tabpanel" aria-labelledby="two-tab">
                                <div class="floor-plans mb-50">
                                    <h3 class="heading-2">Floor Plan</h3>
                                    @foreach($floor_plans as $key => $value)
                                        <div class="mb-10">
                                            <h5 style="font-weight: 400">{{$value['title']. ( $key+1)}}</h5>
                                            <img src="{{asset('storage/img/floor_plans/'.$value['name'])}}" alt="floor-plans" class="img-fluid">
                                        </div>
                                        <hr>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if(!empty(array_filter($video)))
                            <div class="tab-pane " id="four" role="tabpanel" aria-labelledby="4-tab">
                                <div class="inside-properties mb-50">
                                    <h3 class="heading-2">
                                        Property Video
                                    </h3>
                                    {{-- TODO: apply check on video link restict user to add video of following 3rd party --}}
                                    @if($video[0]['host'] === 'Youtube')
                                        <iframe src={{"https://www.youtube.com/embed/".explode('#',explode('?v=',$video[0]['name'])[1])[0]}}></iframe>
                                    @elseif($video[0]['host'] === 'Vimeo')
                                        <iframe src={{"https://player.vimeo.com/video/".explode('.com/',$video[0]['name'])[1]}}></iframe>
                                    @else
                                        <iframe src={{"//www.dailymotion.com/embed/video/".explode('?',explode('video/',$video[0]['name'])[1])[0]."?quality=240&info=0&logo=0"}}></iframe>
                                    @endif
                                </div>
                            </div>
                        @endif
                        <div class="tab-pane" id="five" role="tabpanel" aria-labelledby="5-tab">
                            <div class="location mb-50">
                                <h3 class="heading-2">Location and Nearby</h3>
                                @include('website.includes.location_and_nearby')
                            </div>
                        </div>
                    </div>
                    @if (count($similar_properties))
                        <div class="tab-pane" id="six" role="tabpanel" aria-labelledby="6-tab">
                            @include('website.includes.similar_properties')
                        </div>
                    @endif
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="sidebar-right">
                        <!-- Advanced search start -->
                        @include('website.includes.contact_agent')
                        <hr>
                        @if(!empty($agency))
                            <div class="sidebar widget mb-2 none-992">
                                <h3 class="sidebar-title">{{$agency->title}} </h3>
                                <div class="s-border"></div>
                                <div class="m-border"></div>
                                <div class="row">
                                    @if($agency->logo !==null)
                                        <div class="col-sm-6 text-center">
                                            <img src="{{asset('storage/img/agency_logos/'.$agency->logo)}}" alt="brand" style="max-width: 40%">
                                        </div>
                                    @else
                                        <div class="col-sm-6 text-center">
                                            <img src="{{asset('img/default_company.jpg')}}" alt="brand" style="max-width: 50%">
                                        </div>
                                    @endif
                                    <div class="col-sm-6 mt-1">
                                        <div style="font-size: 1rem">
                                            @if($agency->status === 'verified')
                                                <span style="color:green"><i class="far fa-shield-check"></i> Verified</span>
                                            @endif
                                            @if($agency->featured_listing === 1)
                                                <div>
                                                <span class="premium-badge" style="color:#ffcc00;">
                                                    <i class="fas fa-star"></i>
                                                    <span style="color: white">FEATURED AGENCY</span>
                                                </span>
                                                </div>
                                            @endif
                                            <div class="mt-1" style="font-size: 14px !important;"><i class="fas fa-user p-1"></i><span>Company CEO </span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        @endif

                        {{--                    @include('website.includes.advance_search')--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="EmailConfirmModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Contact Dealer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12" style="text-align: center">
                                <div><span style="font-weight: bold">Contact Person : </span><span>  {{ ucwords($property->contact_person) }}</span></div>
                                <div><span style="font-weight: bold">Phone No :   </span><span>  {{$property->phone}}</span></div>
                                {{--                                <div><span style="font-weight: bold">Mobile No :   </span><span>  {{$property->mobile}}</span></div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer start -->
    @include('website.includes.footer')
@endsection

@section('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script>
        let map;
        let service;
        var infowindow;
        var get_location;
        let image;
        let _markers = [];
        let container = $('#school');
        var latitude = container.data('lat');
        var longitude = container.data('lng');

        function initMap(value) {
            map = '';
            service = '';
            _markers = [];

            let place;

            if (value === 'school') place = 'school college and university';
            else if (value === 'park') place = 'park';
            else if (value === 'hospital') place = 'hospital, medical center and  Naval Hospital'
            else if (value === 'restaurant') place = 'restaurant and cafe'

            get_location = new google.maps.LatLng(latitude, longitude);
            infowindow = new google.maps.InfoWindow();

            map = new google.maps.Map(
                document.getElementById(value), {center: get_location, zoom: 15});

            var request = {
                location: get_location,
                radius: '500',
                query: place,
            };

            service = new google.maps.places.PlacesService(map);
            service.textSearch(request, callback);

            function callback(results, status) {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    for (let i = 0; i < results.length; i++) {
                        createMarker(results[i], value);
                    }
                    const markerCluster = new MarkerClusterer(map, _markers,
                        {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});

                }
            }
        }

        function createMarker(place, value) {
            var marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location,
                icon: {url: '../website/img/marker/' + value + '.png', scaledSize: new google.maps.Size(45, 45)},
            });
            _markers.push(marker);
            google.maps.event.addListener(marker, 'click', function () {
                infowindow.setContent(place.name);
                infowindow.open(map, this);
            });
        }

        (function ($) {
            $(document).ready(function () {
                $('.map-canvas').on('click', function () {
                    initMap($(this).data('value'));
                });
                $.fn.stars = function () {
                    return $(this).each(function () {
                        let rating = $(this).data("rating");
                        rating = rating > 5 ? 5 : rating

                        const numStars = $(this).data("numStars");
                        const fullStar = '<i class="fas fa-star"></i>'.repeat(Math.floor(rating));
                        const halfStar = (rating % 1 !== 0) ? '<i class="fas fa-star-half-alt"></i>' : '';
                        const noStar = '<i class="far fa-star"></i>'.repeat(Math.floor(numStars - rating));
                        $(this).html(`${fullStar}${halfStar}${noStar}`);
                    });
                }
                $('.stars').stars();

                $('select option:first-child').css('cursor', 'default').prop('disabled', true);

                $('.select2').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === 'en' ? 'ltr' : 'rtl'}}',
                });
                $('.select2bs4').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === 'en' ? 'ltr' : 'rtl'}}',
                    theme: 'bootstrap4',
                });

                $('.property-type-select2').on('change', function (e) {
                    const selectedValue = $(this).val();
                    $('[id^=property_subtype-]').attr('disable', 'true').slideUp();
                    $('#property_subtype-' + selectedValue).attr('disable', 'true').slideDown();
                });
                // TODO: Change this method of scroll
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function (e) {
                        e.preventDefault();

                        document.querySelector(this.getAttribute('href')).scrollIntoView({
                            behavior: 'smooth'
                        });
                    });
                });

                if ($('.properties-amenities ').find('li').length === 0)
                    $('.properties-amenities').hide();
                //    description show more and less
                let defaultHeight = 50; // height when "closed"
                let text = $('.description');
                let textHeight = text[0].scrollHeight; // the real height of the element
                let button = $(".button");

                text.css({"max-height": defaultHeight, "overflow": "hidden"});

                button.on("click", function () {
                    var newHeight = 0;
                    if (text.hasClass("active")) {
                        newHeight = defaultHeight;
                        button.text('Read More');
                        text.removeClass("active");
                    } else {
                        newHeight = textHeight;
                        button.text('Read Less');
                        text.addClass("active");
                    }
                    text.animate({
                        "max-height": newHeight
                    }, 500);
                });
                let features = $('.features-list');
                if (features.length > 0) {
                    let text2 = features;
                    let textHeight2 = text2[0].scrollHeight; // the real height of the element
                    let button2 = $(".button2");
                    text2.css({"max-height": defaultHeight, "overflow": "hidden"});

                    button2.on("click", function () {
                        let newHeight2 = 0;
                        if (text2.hasClass("active")) {
                            newHeight2 = defaultHeight;
                            button2.text('Show More');
                            text2.removeClass("active");
                        } else {
                            newHeight2 = textHeight2;
                            button2.text('Show Less');
                            text2.addClass("active");
                        }
                        text2.animate({
                            "max-height": newHeight2
                        }, 500);
                    });
                }
            });
            let form = $('#email-contact-form');
            $.validator.addMethod("regx", function (value, element, regexpr) {
                return regexpr.test(value);
            }, "Please enter a valid value. (+92-300-1234567)");

            form.validate({
                rules: {
                    name: {
                        required: true,
                    },
                    phone: {
                        required: true,
                        regx: /^\+92-3\d{2}-\d{7}$/,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    message: {
                        required: true,
                    },
                },
                messages: {},
                errorElement: 'small',
                errorClass: 'help-block text-red',
                submitHandler: function (form) {
                    form.preventDefault();
                },
                invalidHandler: function (event, validator) {
                    // 'this' refers to the form
                    const errors = validator.numberOfInvalids();
                    if (errors) {
                        let error_tag = $('div.error.text-red');
                        error_tag.hide();
                        const message = errors === 1
                            ? 'You missed 1 field. It has been highlighted'
                            : 'You missed ' + errors + ' fields. They have been highlighted';
                        $('div.error.text-red span').html(message);
                        error_tag.show();
                    } else {
                        $('div.error.text-red').hide();
                    }
                }
            });

            $('#send-mail').click(function (event) {
                if (form.valid()) {
                    event.preventDefault();
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        type: 'post',
                        url: 'http://127.0.0.1/propertymanagement/public/contactAgent',
                        data: form.serialize(),
                        dataType: 'json',
                        success: function (data) {
                            if (data.status === 200) {
                                console.log(data.data);
                                $('#EmailConfirmModel').modal('show');

                            } else {
                                console.log(data.data);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(error);
                            console.log(status);
                            console.log(xhr);
                        },
                        complete: function (url, options) {
                        }
                    });
                }
            })
        })
        (jQuery);
    </script>
    <script src="{{asset('website/js/markerclusterer.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&libraries=places" async defer></script>
    <script src="{{asset('website/js/script-custom.js')}}"></script>
    <script>
        $('#myCarousel').carousel({
            interval: false
        });
        $('#carousel-thumbs').carousel({
            interval: false
        });

        // handles the carousel thumbnails
        // https://stackoverflow.com/questions/25752187/bootstrap-carousel-with-thumbnails-multiple-carousel
        $('[id^=carousel-selector-]').click(function() {
            var id_selector = $(this).attr('id');
            var id = parseInt( id_selector.substr(id_selector.lastIndexOf('-') + 1) );
            $('#myCarousel').carousel(id);
        });
        // Only display 3 items in nav on mobile.
        if ($(window).width() < 575) {
            $('#carousel-thumbs .row div:nth-child(4)').each(function() {
                var rowBoundary = $(this);
                $('<div class="row mx-0">').insertAfter(rowBoundary.parent()).append(rowBoundary.nextAll().addBack());
            });
            $('#carousel-thumbs .carousel-item .row:nth-child(even)').each(function() {
                var boundary = $(this);
                $('<div class="carousel-item">').insertAfter(boundary.parent()).append(boundary.nextAll().addBack());
            });
        }
        // Hide slide arrows if too few items.
        if ($('#carousel-thumbs .carousel-item').length < 2) {
            $('#carousel-thumbs [class^=carousel-control-]').remove();
            $('.machine-carousel-container #carousel-thumbs').css('padding','0 5px');
        }
        // when the carousel slides, auto update
        $('#myCarousel').on('slide.bs.carousel', function(e) {
            var id = parseInt( $(e.relatedTarget).attr('data-slide-number') );
            $('[id^=carousel-selector-]').removeClass('selected');
            $('[id=carousel-selector-'+id+']').addClass('selected');
        });
        // when user swipes, go next or previous
        $('#myCarousel').swipe({
            fallbackToMouseEvents: true,
            swipeLeft: function(e) {
                $('#myCarousel').carousel('next');
            },
            swipeRight: function(e) {
                $('#myCarousel').carousel('prev');
            },
            allowPageScroll: 'vertical',
            preventDefaultEvents: false,
            threshold: 75
        });
        /*
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
          event.preventDefault();
          $(this).ekkoLightbox();
        });
        */

        $('#myCarousel .carousel-item img').on('click', function(e) {
            var src = $(e.target).attr('data-remote');
            if (src) $(this).ekkoLightbox();
        });
    </script>

@endsection
