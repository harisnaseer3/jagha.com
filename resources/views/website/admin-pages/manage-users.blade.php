@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')
    <div id="site" class="left relative">
        <div id="site-wrap" class="left relative">
            @include('website.admin-pages.includes.admin-nav')
            <section class="content-header admin-margin">
            </section>
            <div class="content">
                <div class="clearfix"></div>
                <div class="alert-container mx-5">
                    @include('website.layouts.flash-message')
                </div>
                <div class="clearfix"></div>
                <div class="row mx-4 mt-2">
                    {{-- registered users --}}
                    @include('website.admin-pages.includes.registered-user')
                    {{-- logged in users logs --}}
                    @include('website.admin-pages.includes.user-logs')
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/admin-user-management-page.js')}}"></script>
@endsection
