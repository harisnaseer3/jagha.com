@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">
    <style>
        .custom-select {
        'border: '1px solid #ced4da',
        'border-radius': '.25rem'
        }


    </style>

@endsection

@section('content')
    <div id="site" class="left relative">
        <div id="site-wrap" class="left relative">
            @include('website.admin-pages.includes.admin-nav')
            <div style="min-height:90px"></div>
            <div class="submit-property">
                <div class="container-fluid container-padding">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" role="tabpanel">
                                    <div class="row my-4">
                                        <div class="col-md-3">
                                            @include('website.admin-pages.package.sidebar')
                                        </div>
                                        <div class="col-md-9">
                                            @include('website.layouts.flash-message')
                                            <div class="tab-content" id="listings-tabContent">
                                                <div class="float-right"><span class="pull-right"><a class="btn btn-sm theme-blue text-white mr-2" href="/"><i class="fa fa-globe mr-1"></i>Go to property.aboutpakistan.com</a></span>
                                                </div>

                                                <div class="tab-pane fade active show" id="listings-all" role="tabpanel"
                                                     aria-labelledby="listings-all-tab">
                                                    <h6>Complementary Packages</h6>
                                                    <div class="my-4">
                                                        <div class="card my-4">
                                                            <div class="card-header theme-blue text-white">
                                                                <div class="font-14 font-weight-bold text-white">Email</div>
                                                            </div>
                                                            <div class="card-body">
                                                                {{ Form::open(['method' => 'post', 'class'=> 'package-user-form']) }}
                                                                {{ Form::bsEmail('user_email', null, ['required' => true,'data-default' => 'Enter User Email','placeholder'=>'example@example.com']) }}
                                                                {{ Form::submit('Get Details', ['class' => 'btn btn-sm btn-primary btn-md search-submit-btn']) }}
                                                                <span class="ml-2"><i class="fa fa-spinner fa-spin package-spinner" style="font-size:20px; display:none"></i></span>
                                                                {{ Form::close() }}


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="details_tab" style="display: none">
                                                        @include('website.admin-pages.components.complementary-package')
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
            </div>
        </div>
    </div>

    <!-- Footer start -->

@endsection

@section('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script src="{{asset('website/js/admin-complementary.js')}}"></script>
@endsection
