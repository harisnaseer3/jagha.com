@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    {{--    <link rel="stylesheet" type="text/css" href="{{asset('website/css/bootstrap.min.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')
    @include('website.includes.dashboard-nav')
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>My Account Settings</h1>
            </div>
        </div>
    </div>

    <!-- Submit Property start -->
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="account_profile-tab">
                            <div class="row my-4">
                                <div class="col-md-3">
                                    @include('website.wallet.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.flash-message')
                                    <div class="card">
                                        <div class="card-header theme-blue text-white text-capitalize">My Wallet</div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <div class="text-center">
                                                        <span class="mr-5" style=" font-weight: bold;">Available Balance: </span>
                                                        <span>Rs. {{number_format($wallet)}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card my-4">
                                        <div class="card-header theme-blue text-white text-capitalize">Credit History</div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    {{--                                                    <div class="text-center">--}}
                                                    {{--                                                        <span class="mr-5" style=" font-weight: bold;">Available Balance: </span>--}}
                                                    {{--                                                        <span>Rs. {{number_format($wallet)}}</span>--}}
                                                    {{--                                                    </div>--}}
                                                    <table class="display" style="width: 100%" id="balance">
                                                        <thead>
                                                        <tr>
                                                            <th>Sr.</th>
                                                            <th>Credit</th>
                                                            <th>Debt</th>
                                                            <th>Dated</th>

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
    <script>$('#balance').DataTable(
            {
                "scrollX": true,
                "ordering": false,
                responsive: true
            }
        );</script>
@endsection
