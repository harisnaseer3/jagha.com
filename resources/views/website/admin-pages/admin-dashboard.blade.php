@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">

@endsection

@section('content')
    <div id="site" class="left relative">
        <div id="site-wrap" class="left relative">
            @include('website.admin-pages.includes.admin-nav')

            <!-- Submit Property start -->
            <div class="row admin-margin">
                <div class="col-md-12">
                    <div class="tab-content" id="ListingsTabContent">
                        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                            <div class="m-4">
                                <div class="row">
                                    <div class="col-lg-2 col-md-4 col-sm-6">
                                        <div class="team-1">
                                            <div class="team-photo">
                                                @if(isset($admin->image) && $admin->image != null)
                                                    <img src="{{ asset('thumbnails/user_images/'.explode('.',$admin->image)[0].'-450x350.webp')}}"
                                                         alt="{{$admin->name}}" title="{{$admin->name}}" class="img-fluid image-padding rounded-circle" aria-label="user photo">
                                                @else
                                                    <img src="{{asset('img/logo/profile.png')}}"
                                                         alt="{{$admin->name}}" title="{{$admin->name}}" class="img-fluid image-padding rounded-circle" aria-label="user photo">
                                                @endif
                                            </div>
                                            <div class="team-details">
                                                @if(count($admin->roles) > 0)
                                                    <h6 class="proper-case">{{ucwords($admin->roles[0]->name)}}</h6>
                                                @endif
                                                <h5>{{ucwords($admin->name)}}</h5>
                                                <div class="contact">
                                                    <p class="m-0">
                                                        <i class="fa fa-envelope-o mr-1"></i> {{$admin->email}}
                                                    </p>
                                                    @if($admin->cell !== null)
                                                        <p class="m-0">
                                                            <i class="fa fa-phone mr-1"></i>{{$admin->cell}}
                                                        </p>
                                                    @endif
                                                    @if($admin->phone !== null)
                                                        <p class="m-0">
                                                            <i class="fa fa-phone mr-1"></i>{{$admin->phone}}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-10 col-md-8 col-sm-6">
                                        @include('website.layouts.flash-message')

                                        <div class="row">
                                            <div class="col-2 mb-4">
                                                <button class="btn theme-blue color-white task-btn" id="execute-tasks">Execute Tasks</button>
                                            </div>
                                            <div class="col-10 mt-2"><i class="fa fa-spinner fa-spin " style="font-size:20px;display:none"></i>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 mb-4">
                                                    <button class="btn theme-blue color-white task-btn" id="property-count">Update Property Count</button>
                                                    <i class="fa fa-spinner fa-spin" id="loading-spinner" style="font-size:20px; display:none; margin-left: 10px;"></i>
                                                    <span id="status-message" style="margin-left: 10px;"></span>
                                                </div>
                                            </div>

                                            <div class="row">
                                                @can('Manage Users')
                                                    @include('website.admin-pages.includes.admin-logs')
                                                @endcan
                                                @can('Manage Property')
                                                    @include('website.admin-pages.includes.property-logs')
                                                @endcan
                                                @can('Manage Agency')
                                                    @include('website.admin-pages.includes.agency-logs')
                                                @endcan
                                                @can('Manage Users')
                                                    <div class="col-12 mb-4">
                                                        <canvas id="myChart" class="w-100" height="300px"></canvas>
                                                    </div>
                                                    @include('website.admin-pages.includes.visit-logs')
                                                @endcan
                                                @can('Manage Packages')
                                                    @include('website.admin-pages.includes.package-logs')
                                                @endcan
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
            <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
            <script type="text/javascript" charset="utf8" src="{{asset('website/js/chart.js')}}"></script>
            <script type="text/javascript" charset="utf8" src="{{asset('website/js/admin-dashboard-page.js')}}"></script>

        @endsection


