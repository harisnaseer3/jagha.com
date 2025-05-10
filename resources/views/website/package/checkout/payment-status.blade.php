@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>Jagha - Buy Sell Rent Homes & Properties In Pakistan by https://www.jagha.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <style>
        .success {
            color: green;
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
                                               <span class="pull-right"><a class="btn btn-sm transition-background color-green mr-2" href="/">
                                                       <i class="fa fa-globe mr-1"></i>Go to property.aboutpakistan.com</a></span>
                                        </div>

                                        <div class="tab-pane fade active show" id="listings-all" role="tabpanel" aria-labelledby="listings-all-tab">
                                            <h6>Packages</h6>
                                            <div class="my-4">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="card my-4">
                                                            <div class="card-header theme-blue text-white">
                                                                <div class="font-14 font-weight-bold text-white"> Payment Info</div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="text-center">
                                                                    <div class="status">
                                                                    <?php $response = Session::get('response');?>

                                                                    @if($response['pp_ResponseCode'] == '000')
                                                                        <!-- --------------------------------------------------------------------------- -->
                                                                            <!-- Payment successful -->
                                                                            <h1 class="success">Your Payment has been Successful</h1>
                                                                            <h4>Payment Information</h4>
                                                                            <div class="container">
                                                                                <table class="table table-bordered" style="width:100%">
                                                                                    <tr>
                                                                                        <td>Reference Number:</td>
                                                                                        <td>{{$response['pp_RetreivalReferenceNo'] }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Transaction ID:</td>
                                                                                        <td>{{$response['pp_TxnRefNo']}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Paid Amount:</td>
                                                                                        <td>{{(int)$response['pp_Amount']/100}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Payment Status:</td>
                                                                                        <td>Success</td>
                                                                                    </tr>
                                                                                </table>

                                                                                <div class="float-right">
                                                                                    <span class="pull-right">
                                                                                        <a class="btn btn-sm transition-background color-green mr-2"  href="{{ route('package.index') }}">
                                                                                            Go To Package Listing
                                                                                        </a>
                                                                                    </span>
                                                                                </div>
                                                                            </div>

                                                                            <!-- --------------------------------------------------------------------------- -->


                                                                            <!-- --------------------------------------------------------------------------- -->
                                                                            <!-- Payment not successful -->
                                                                        @elseif($response['pp_ResponseCode']  == '124')
                                                                            <h1 class="error">Your Payment has been on Waiting satate</h1>
                                                                            <h4>Payment Information</h4>
                                                                            <div class="container">
                                                                                <table class="table table-bordered" style="width:100%">
                                                                                    <tr>
                                                                                        <td>Reference Number:</td>
                                                                                        <td>{{$response['pp_RetreivalReferenceNo'] }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Message:</td>
                                                                                        <td>{{$response['pp_ResponseMessage']}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Voucher Number:</td>
                                                                                        <td>{{$response['pp_RetreivalReferenceNo']}}</td>
                                                                                    </tr>

                                                                                </table>
                                                                            </div>
                                                                            <!-- --------------------------------------------------------------------------- -->


                                                                            <!-- --------------------------------------------------------------------------- -->
                                                                            <!-- Payment not successful -->
                                                                        @else
                                                                            <h1 class="error">Your Payment has Failed</h1>
                                                                            <p><b>Message: </b>{{ $response['pp_ResponseMessage'] }}</p>
                                                                            <h4>Payment Information</h4>
                                                                            <div class="container">
                                                                                <table class="table table-bordered" style="width:100%">
{{--                                                                                    <tr>--}}
{{--                                                                                        <td>Reference Number:</td>--}}
{{--                                                                                        <td>{{$response['pp_RetreivalReferenceNo'] }}</td>--}}
{{--                                                                                    </tr>--}}
                                                                                    <tr>
                                                                                        <td>Message:</td>
                                                                                        <td>{{$response['pp_ResponseMessage']}}</td>
                                                                                    </tr>

                                                                                </table>
                                                                            </div>
                                                                    @endif
                                                                    <!-- --------------------------------------------------------------------------- -->


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
                </div>
            </div>
        </div>
    </div>



    <!-- Footer start -->
{{--        @include('website.includes.footer')--}}
@endsection

@section('script')
    {{--    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>--}}
    {{--    <script src="{{asset('plugins/intl-tel-input/js/intlTelInput.js')}}"></script>--}}
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    {{--    <script src="{{asset('website/js/package-form.js')}}"></script>--}}

@endsection
