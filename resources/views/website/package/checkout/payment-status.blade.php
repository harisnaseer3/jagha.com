@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <style>
        .pay-method-item {
            float: left;
            margin: 0 4px 5px 0;
            width: 128px;
            height: 128px;
            text-align: center;
            background-color: #f5f6f9;
        }
    </style>

@endsection

@section('content')
{{--    @include('website.includes.dashboard-nav')--}}
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>Packages</h1>
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
                                    @include('website.package.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.flash-message')
                                    <div class="tab-content" id="listings-tabContent">
                                        <div class="float-right">
                                               <span class="pull-right"><a class="btn btn-sm theme-blue text-white mr-2" href="/">
                                                       <i class="fa fa-globe mr-1"></i>Go to property.aboutpakistan.com</a></span>
                                        </div>

                                        <div class="tab-pane fade active show" id="listings-all" role="tabpanel" aria-labelledby="listings-all-tab">
                                            <h6>Packages</h6>
                                            <div class="my-4">
                                                <div class="row">
                                                    <div class="container">
                                                        <div class="status">
                                                        <?php $post_data = Session::get('post_data');?>

                                                        @if($response['pp_ResponseCode'] == '000')
                                                            <!-- --------------------------------------------------------------------------- -->
                                                                <!-- Payment successful -->
                                                                <h1 class="success">Your Payment has been Successful</h1>
                                                                <h4>Payment Information</h4>
                                                                <p><b>Reference Number:</b> {{ $response['pp_RetreivalReferenceNo'] }}</p>
                                                                <p><b>Transaction ID:</b> {{ $response['pp_TxnRefNo'] }}</p>
                                                                <p><b>Paid Amount:</b> {{ $response['pp_Amount'] }}</p>
                                                                <p><b>Payment Status:</b> Success</p>
                                                                <!-- --------------------------------------------------------------------------- -->


                                                                <!-- --------------------------------------------------------------------------- -->
                                                                <!-- Payment not successful -->
                                                            @elseif($ResponseCode == '124')
                                                                <h1 class="error">Your Payment has been on Waiting satate</h1>
                                                                <p><b>Message: </b>{{ $response['pp_ResponseMessage'] }}</p>
                                                                <p><b>Voucher Number: </b>{{ $response['pp_RetreivalReferenceNo'] }}</p>
                                                                <!-- --------------------------------------------------------------------------- -->


                                                                <!-- --------------------------------------------------------------------------- -->
                                                                <!-- Payment not successful -->
                                                            @else
                                                                <h1 class="error">Your Payment has Failed</h1>
                                                                <p><b>Message: </b>{{ $response['pp_ResponseMessage'] }}</p>
                                                        @endif
                                                        <!-- --------------------------------------------------------------------------- -->


                                                        </div>
                                                        <a href="index.php" class="btn-link">Back to Products</a>
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
    {{--    @include('website.includes.footer')--}}
@endsection

@section('script')
    {{--    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>--}}
    {{--    <script src="{{asset('plugins/intl-tel-input/js/intlTelInput.js')}}"></script>--}}
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    {{--    <script src="{{asset('website/js/package-form.js')}}"></script>--}}

@endsection
