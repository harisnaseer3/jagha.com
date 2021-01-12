@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Portfolio : About Pakistan Properties Software By https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">

@endsection

@section('content')
    @include('website.includes.dashboard-nav')
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>Message Center</h1>
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
                                <div class="col-12 mb-2">
                                    <div class="float-right">
                                               <span class="pull-right"><a class="btn btn-sm theme-blue text-white mr-2" href="/"><i
                                                           class="fa fa-globe mr-1"></i>Go to property.aboutpakistan.com</a></span>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    @include('website.message-center.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.flash-message')

                                    <div class="row">
                                        <div class="col-12">


                                            <div class="card">
                                                <div class="card-header theme-blue text-white">
                                                    Inbox
                                                </div>
                                                <div class="card-body">
                                                    <table id="customer-mails" class="display" style="width: 100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Sr.</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Mobile #</th>
                                                            <th>Type</th>
                                                            <th>Location</th>
                                                            <th>Message</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
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
    @include('website.includes.footer')
@endsection

@section('script')
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/script-message-center.js')}}"></script>
@endsection
