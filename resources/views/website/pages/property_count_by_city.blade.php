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
    <div class="properties-section content-area pt-3">
        <div class="container">
            <div class="row cities-margin">
                <div class="col-lg-9 col-md-12 pb-3">
                    <!-- Listing -->
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="all-cities-header">
                                        @if($type === 'homes') Houses @else {{ucwords($type)}} @endif for Sale in All Cities of Pakistan</h1>
                                    <input type="hidden" name="type" id="type" value="{{$type}}" />
                                </div>
                            </div>


                        </div>
                        <div class="card-body" id="all-cities-count-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="pull-right">
                                        <strong>Sort Alphabetically</strong>
                                        <label class="switch">
                                            <input name="alpha-switch" id="alpha-switch" type="checkbox">
                                            <span class="slider round"></span>
                                        </label>

                                    </div>
                            </div>
                            </div>
                            @if($properties)
                                <div class="row">
                                    @foreach($properties as  $property)
                                        <div class=" col-sm-6  col-md-3 my-2">
                                            <a href="{{route('sale.property.search', ['sub_type' => lcfirst($property->property_type),
                                                                                      'city' => lcfirst($property->city_name) ,
                                                                                      'purpose'=>lcfirst($property->property_purpose), 'sort'=>'newest','limit'=>15])}}"
                                               title="{{$property->property_type}}  in {{$property->city_name}}"
                                               class="breadcrumb-link">
                                                {{$property->city_name}} ({{$property->property_count}})
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
