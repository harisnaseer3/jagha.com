@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Property Management By Property.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')
    @include('website.includes.dashboard-nav')

    <!-- Submit Property start -->
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content" id="ListingsTabContent">
                        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                            <div class="m-4">
                                {{--                                <div class="card">--}}
                                {{--                                    <div class="row">--}}
                                {{--                                        <div class="col-md-12 col-sm-12 mb-5">--}}
                                {{--                                            <div id="post-404" class="left relative">--}}
                                {{--                                                <h1>COMING SOON!</h1>--}}
                                {{--                                                <p>This feature will be available in next update.</p>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="team-2">
                                            <div class="team-photo">
                                                <img src="{{asset('img/logo/dummy-logo.png')}}" alt="agent-2" class="img-fluid">
                                            </div>
                                            <div class="team-details">
                                                <h6>Office Manager</h6>
                                                <h5><a href="#">Maria Blank</a></h5>
                                                <div class="contact">
                                                    <p>
                                                        <a href="mailto:info@themevessel.com"><i class="fa fa-envelope-o"></i>info@themevessel.com</a>
                                                    </p>
                                                    <p>
                                                        <a href="tel:+554XX-634-7071"> <i class="fa fa-phone"></i>+55 4XX-634-7071</a>
                                                    </p>
                                                    <p>
                                                        <a href="#"><i class="fa fa-skype"></i>sales.carshop</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-md-6 col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="panel panel-success">
                                                    <div class="panel-heading"><h3 class="panel-title">User Account Stats</h3></div>
                                                    <div class="panel-body"> Nulla porttitor accumsan tincidunt.</div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="panel panel-success">
                                                    <div class="panel-heading"><h3 class="panel-title">User Account Stats</h3></div>
                                                    <div class="panel-body"> Nulla porttitor accumsan tincidunt.</div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="panel panel-success">
                                                    <div class="panel-heading"><h3 class="panel-title">User Account Stats</h3></div>
                                                    <div class="panel-body"> Nulla porttitor accumsan tincidunt.</div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="panel panel-success">
                                                    <div class="panel-heading"><h3 class="panel-title">User Account Stats</h3></div>
                                                    <div class="panel-body"> Nulla porttitor accumsan tincidunt.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div><h6>Property Listing</h6></div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="theme-blue text-white">
                                        <tr>
                                            <td>ID</td>
                                            <td>Type</td>
                                            <td>Location</td>
                                            <td>Price (PKR)</td>
                                            <td>Area</td>
                                            <td>Purpose</td>
                                            <td>Status</td>
                                            <td>Views</td>
                                            <td>Listed Date</td>
                                            <td>Controls</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>ID</td>
                                            <td>Type</td>
                                            <td>Location</td>
                                            <td>Price (PKR)</td>
                                            <td>Area</td>
                                            <td>Purpose</td>
                                            <td>Status</td>
                                            <td>Views</td>
                                            <td>Listed Date</td>
                                            <td>Controls</td>
                                        </tr>
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

    <!-- Footer start -->
    @include('website.includes.footer')
@endsection

@section('script')
    <script>
        setInterval(function () {
            var docHeight = $(window).height();
            var footerHeight = $('#foot-wrap').height();
            var footerTop = $('#foot-wrap').position().top + footerHeight;
            var marginTop = (docHeight - footerTop);
            if (footerTop < docHeight)
                $('#foot-wrap').css('margin-top', marginTop + 'px'); // padding of 30 on footer
            else
                $('#foot-wrap').css('margin-top', '0px');
        }, 250);
    </script>

@endsection
