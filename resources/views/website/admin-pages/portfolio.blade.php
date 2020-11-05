@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    @if ($current_route_name === 'properties.create')   <title> Post New Listing : Property Management Software By https://www.aboutpakistan.com</title>
    @elseif ($current_route_name === 'properties.edit') <title> Edit Listing : Property Management Software By https://www.aboutpakistan.com </title>
    @endif
@endsection

@section('css_library')
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">

@endsection

@section('content')
    <div id="site" class="left relative">
        <div id="site-wrap" class="left relative">
        @include('website.admin-pages.includes.admin-nav')
        <!-- Top header start -->
            <div style="min-height:90px"></div>
            <!-- Submit Property start -->
            <div class="submit-property">
                <div class="container-fluid container-padding">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content" id="portfolioTabContent">
                                <div class="tab-pane fade show active" id="property_management" role="tabpanel" aria-labelledby="property_management-tab">
                                    <div class="row my-4">
                                        <div class="col-md-3">
                                            @include('website.admin-pages.includes.sidebar')
                                        </div>
                                        <div class="col-md-9">
                                            @include('website.admin-pages.property_management')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('website/js/script-modal-features.js')}}"></script>
    <script src="{{asset('website/js/admin-portfolio.js')}}"></script>
@endsection
