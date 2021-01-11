@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection


@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}" async defer>
@endsection

@section('content')
    @include('website.includes.nav')
    <!-- Properties section body start -->
    <div class="properties-section content-area">
        <div class="container">
            <div class="row count-margin">
                <div class="col-lg-9 col-md-12 pb-3">
                    <!-- Listing -->
                    <div class="card">
                        <div class="card-header">
                            <h1 class="all-cities-header">
                               @if($type === 'homes') Houses @else {{$type}} @endif for {{$purpose}} in All Cities of Pakistan</h1>
                        </div>
                        <div class="card-body">
                            @if(trim(explode('&',$type)[0]) =='Houses')<h2 class="all-cities-header">{{trim(explode('&',$type)[0])}}</h2>@endif
                            <div class="row">
                                @if(isset($cities[trim(strtolower(explode('&',$type)[0]))]))
                                    @foreach($cities[trim(strtolower(explode('&',$type)[0]))] as  $city)
                                        <div class="col-sm-3 my-2">
                                            <a href="{{route('sale.property.search', [
                                                    'sub_type' => lcfirst(isset($city->property_sub_type)? $city->property_sub_type : $city->property_type),
                                                    'city' => lcfirst($city->city_name) ,
                                                    'purpose'=>lcfirst($city->property_purpose),
                                                    'sort'=>'newest',
                                                    'limit'=>15 ]
                                                    )}}"
                                               title="{{isset($city->property_sub_type)?$city->property_sub_type.'s':$city->property_type}}  in {{$city->city_name}}"
                                               class="breadcrumb-link">
                                                {{$city->city_name}} ({{$city->property_count}})
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            @if(isset($cities['flats']))
                                <h2 class="all-cities-header pt-1">Flats</h2>
                                <div class="row">

                                    @foreach($cities['flats'] as  $city2)
                                        <div class="col-sm-3 my-2">

                                            <a href="{{route('sale.property.search', ['sub_type' => lcfirst($city2->property_sub_type), 'city' => lcfirst($city2->city_name) ,
                                                    'purpose'=>lcfirst($city2->property_purpose), 'sort'=>'newest','limit'=>15])}}"
                                               title="{{$city2->property_sub_type.'s'}}  in {{$city2->city_name}}"
                                               class="breadcrumb-link">
                                                {{$city2->city_name}} ({{$city2->property_count}})
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="sidebar-right mt-0">
                            @include('website.includes.subscribe-content')
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
    <script src="{{asset('website/js/jquery.validate.min.js')}}" defer></script>
    <script src="{{asset('website/js/all-cities-page.js')}}" defer></script>
    <script src="{{asset('website/js/cookie.min.js')}}" defer></script>
@endsection
