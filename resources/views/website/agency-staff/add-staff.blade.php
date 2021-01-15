@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Portfolio : About Pakistan Properties Software By https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/intl-tel-input/css/intlTelInput.min.css')}}" async defer>

@endsection

@section('content')
    @include('website.includes.dashboard-nav')
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>Agency Staff</h1>
            </div>
        </div>
    </div>
    <!-- Submit Property start -->
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" role="tabpanel">
                            <div class="row my-4">
                                <div class="col-md-3">
                                    @include('website.agency-staff.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.flash-message')
                                    <div class="card">
                                        <div class="card-header theme-blue text-white text-capitalize">
                                            Add new Staff
                                        </div>
                                        @include('website.includes.add-staff-form')
                                    </div>
                                </div>
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
    <script src="{{asset('plugins/intl-tel-input/js/intlTelInput.js')}}"></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('website/js/staff-profile.js')}}"></script>
@endsection
