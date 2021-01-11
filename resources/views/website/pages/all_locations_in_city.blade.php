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
                            <h1 class="all-cities-header">
                                All locations of {{ucfirst($locations_data['sub_type'])}} for {{ucfirst($locations_data['purpose'])}} in {{$locations_data['city']}}</h1>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($locations_data['count'] as $location)
                                    <div class="col-sm-6  mb-3">
                                        <a href="{{route('search.property.at.location',[
                                'type'=>strtolower($locations_data['sub_type']),
                                'purpose'=>lcfirst($locations_data['purpose']),
                                'city' => lcfirst($locations_data['city']),
                                'location'=> str_replace(' ', '-',str_replace('-','_',str_replace('/','BY',$location->location_name))),
                                 'sort'=>'newest','limit'=>15])}}"
                                           class="breadcrumb-link">
                                            {{ \Illuminate\Support\Str::limit($location->location_name , 40, $end='...')}} ({{$location->property_count}})
                                        </a>
                                    </div>
                                @endforeach
                            </div>
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
    <script src="{{asset('website/js/cookie.min.js')}}" defer></script>
    <script src="{{asset('website/js/all-cities-page.js')}}" defer></script>

@endsection
