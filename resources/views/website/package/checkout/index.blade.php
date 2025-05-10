@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>Jagha - Buy Sell Rent Homes & Properties In Pakistan by https://www.jagha.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <style>
        .pay-method-item {
            float: left;
            margin: 0 4px 5px 0;
            width: 128px;
            height: 128px;
            text-align: center;
            background-color: #f5f6f9;
            border: 10px #f5f6f9;
        }

        .paymentWrap {
            padding: 50px;
        }

        .paymentWrap .paymentBtnGroup {
            max-width: 800px;
            margin: auto;
        }

        .paymentWrap .paymentBtnGroup .paymentMethod {
            padding: 40px;
            box-shadow: none;
            position: relative;
        }

        .paymentWrap .paymentBtnGroup .paymentMethod.active {
            outline: none !important;
        }

        .paymentWrap .paymentBtnGroup .paymentMethod.active .method {
            border-color: #4cd264;
            outline: none !important;
            box-shadow: 0px 3px 22px 0px #7b7b7b;
        }

        .paymentWrap .paymentBtnGroup .paymentMethod .method {
            position: absolute;
            right: 3px;
            top: 3px;
            bottom: 3px;
            left: 3px;

            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            border: 2px solid transparent;
            transition: all 0.5s;

            margin: -15px;
        }

        .paymentWrap .paymentBtnGroup .paymentMethod .method.visa {
            background-image: url("{{asset('img/jazz cash.png')}}");
            background-color: white;
        }

        /*.paymentWrap .paymentBtnGroup .paymentMethod .method.master-card {*/
        /*    background-image: url('')*/
        /*}*/

        /*.paymentWrap .paymentBtnGroup .paymentMethod .method.amex {*/
        /*    background-image: url("http://www.paymentscardsandmobile.com/wp-content/uploads/2015/08/Amex-icon.jpg");*/
        /*}*/

        /*.paymentWrap .paymentBtnGroup .paymentMethod .method.vishwa {*/
        /*    background-image: url("http://i.imgur.com/VkiM7PL.jpg");*/
        /*}*/

        /*.paymentWrap .paymentBtnGroup .paymentMethod .method.ez-cash {*/
        /*    background-image: url("http://www.busbooking.lk/img/carousel/BusBooking.lk_ezCash_offer.png");*/
        /*}*/


        .paymentWrap .paymentBtnGroup .paymentMethod .method:hover {
            border-color: #4cd264;
            outline: none !important;
        }
        .jazzCashTxt{
            margin-top: 23%;
        } .easyPasaTxt{
            margin-top: 5%;
        }
    </style>

@endsection

@section('content')
    @include('website.includes.dashboard-nav')
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
                                <div class="col-md-9 my-3">
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
                                                        {{--                                                        <div class="card my-4 ">--}}
                                                        {{--                                                            <div class="card-header theme-blue text-white">--}}
                                                        {{--                                                                <div class="font-14 font-weight-bold text-white"> Payment Details</div>--}}
                                                        {{--                                                            </div>--}}
                                                        {{--                                                            <div class="card-body">--}}
                                                        {{--                                                                --}}{{--                                                                {{ Form::open(['route' => ['package.store'], 'method' => 'post', 'class'=> 'package-form']) }}--}}
                                                        {{--                                                                --}}{{--                                                                {{ Form::bsText('name', \Illuminate\Support\Facades\Auth::user()->name,['required' => true, 'placeholder' => 'Your Name','data-default'=>'Your name']) }}--}}
                                                        {{--                                                                --}}{{--                                                                {{ Form::bsEmail('email', \Illuminate\Support\Facades\Auth::user()->email,['required' => true, 'placeholder' => 'Your Email','data-default'=>'Your Email']) }}--}}

                                                        {{--                                                                --}}{{--                                                                {{ Form::submit('Pay With JazzCash',--}}
                                                        {{--                                                                --}}{{--                                                                ['class' => 'btn btn-primary btn-md search-submit-btn',--}}
                                                        {{--                                                                --}}{{--                                                                'src'=> asset('img/google-icon.png'),  'alt'=>'Submit', 'width'=>'48', 'height'=>'48','type'=>'image'--}}
                                                        {{--                                                                --}}{{--                                                                ]) }}--}}
                                                        {{--                                                                --}}{{--                                                                {{ Form::close() }}--}}

                                                        {{--                                                                <form method="POST" action="{{route('do.checkout')}}" accept-charset="UTF-8" id="checkout-form">--}}
                                                        {{--                                                                    @csrf--}}
                                                        {{--                                                                    <div class="form-group row">--}}
                                                        {{--                                                                        <label for="name" class="col-sm-4 col-md-3 col-lg-2 col-xl-2 col-form-label col-form-label-sm">--}}
                                                        {{--                                                                            Name--}}

                                                        {{--                                                                            <span class="text-danger">*</span>--}}
                                                        {{--                                                                        </label>--}}

                                                        {{--                                                                        <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">--}}
                                                        {{--                                                                            <input class="form-control form-control-sm" aria-describedby="name-error" aria-invalid="false" required=""--}}
                                                        {{--                                                                                   placeholder="Your Name" data-default="Your name" name="name" type="text" value="{{\Illuminate\Support\Facades\Auth::user()->name}}" spellcheck="false"--}}
                                                        {{--                                                                                   data-ms-editor="true">--}}


                                                        {{--                                                                        </div>--}}
                                                        {{--                                                                        <div--}}
                                                        {{--                                                                            class="offset-xs-4 col-xs-8 offset-sm-4 col-sm-8 offset-md-0 col-md-4 col-lg-4 col-xl-5 text-muted data-default-line-height my-sm-auto">--}}
                                                        {{--                                                                            Your name--}}
                                                        {{--                                                                        </div>--}}

                                                        {{--                                                                    </div>--}}

                                                        {{--                                                                    <div class="form-group row">--}}
                                                        {{--                                                                        <label for="email" class="col-sm-4 col-md-3 col-lg-2 col-xl-2 col-form-label col-form-label-sm">--}}
                                                        {{--                                                                            Email--}}

                                                        {{--                                                                            <span class="text-danger">*</span>--}}
                                                        {{--                                                                        </label>--}}

                                                        {{--                                                                        <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">--}}
                                                        {{--                                                                            <input class="form-control form-control-sm" aria-describedby="email-error" aria-invalid="false" required=""--}}
                                                        {{--                                                                                   placeholder="Your Email" data-default="Your Email" name="email" type="email" value="{{\Illuminate\Support\Facades\Auth::user()->email}}">--}}

                                                        {{--                                                                        </div>--}}

                                                        {{--                                                                        <div--}}
                                                        {{--                                                                            class="offset-xs-4 col-xs-8 offset-sm-4 col-sm-8 offset-md-0 col-md-4 col-lg-4 col-xl-5 text-muted data-default-line-height my-sm-auto">--}}
                                                        {{--                                                                            Your Email--}}
                                                        {{--                                                                        </div>--}}
                                                        {{--                                                                    </div>--}}
                                                        {{--                                                                    <input type="hidden" value="{{$result['pack-id']}}" name="pack-id">--}}


                                                        {{--                                                                    --}}{{--                                                                    <input class="btn btn-outline-dark btn-md search-submit-btn" src="{{asset('img/jazz cash.png')}}" alt="Submit"--}}
                                                        {{--                                                                    --}}{{--                                                                           width="100" height="90"--}}
                                                        {{--                                                                    --}}{{--                                                                            type="image">--}}
                                                        {{--                                                                    <div class="pay-method-item mt-2">--}}
                                                        {{--                                                                        <a class="form-submit-btn"> <img class="mt-2" src="{{asset('img/jazz cash.png')}}" alt="Submit"--}}
                                                        {{--                                                                                                         width="100" height="90"></a>--}}
                                                        {{--                                                                        <div class="mt-3 font-weight-bold">--}}
                                                        {{--                                                                            Jazz Cash--}}
                                                        {{--                                                                        </div>--}}
                                                        {{--                                                                    </div>--}}
                                                        {{--                                                                    <div class="pay-method-item mt-2">--}}
                                                        {{--                                                                        <a class="form-submit-btn">--}}
                                                        {{--                                                                            <img class="mt-2" src="{{asset('img/easy-pasa.png')}}" alt="Submit"--}}
                                                        {{--                                                                                 width="90" height="70" disabled></a>--}}
                                                        {{--                                                                        <div class="mt-3 font-weight-bold">--}}
                                                        {{--                                                                            EasyPasa--}}
                                                        {{--                                                                        </div>--}}
                                                        {{--                                                                    </div>--}}
                                                        {{--                                                                </form>--}}
                                                        {{--                                                            </div>--}}

                                                        {{--                                                        </div>--}}
                                                        <div class="card my-4">
                                                            <div class="card-header theme-blue text-white">
                                                                <div class="font-14 font-weight-bold text-white"> Your Package</div>
                                                            </div>

                                                            <div class="card-body">
                                                                <div class="text-center">
                                                                    <table class="table" style="width: 100%">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Package Detail</th>
                                                                            <th>Amount (Rs.)</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td> A {{$result['type']}} Package of {{$result['for']}} For {{$result['duration']}} month(s).</td>
                                                                            <td>{{$result['amount']}}</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                                <div>
                                                                    <h6>Select an Option to Pay</h6>
                                                                    <div class="flex-self-center">
                                                                        <form method="POST" action="{{route('do.checkout')}}" accept-charset="UTF-8" id="checkout-form">
                                                                            @csrf
                                                                            <a class="form-submit-btn" title="Pay with Jazz Cash" data-title="JazzCash">
                                                                                <div class="pay-method-item">
                                                                                    <img class="mt-4" src="{{asset('img/jazz cash.png')}}" alt="Jazz Cash"
                                                                                         width="100" height="100">
                                                                                    <div class="font-weight-bold jazzCashTxt">
                                                                                        Jazz Cash
                                                                                    </div>
                                                                                </div>
                                                                            </a>

                                                                            <div class="pay-method-item">
                                                                                <div class="form-submit-btn" style="opacity: 0.5;" title="Pay with EasyPasa" data-title="EasyPasa">
                                                                                    <img class="mt-2" src="{{asset('img/easy-pasa.png')}}" alt="EasyPasa"
                                                                                         width="90" height="50" disabled title="Pay with EasyPasa"></div>
                                                                                <div class="font-weight-bold easyPasaTxt">
                                                                                    EasyPasa
                                                                                </div>
                                                                            </div>
                                                                            <input type="hidden" name="method">
                                                                            <input type="hidden" name="dateTime" value="{{$result['dateTime']}}">
                                                                        </form>
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
    </div>



    <!-- Footer start -->
        @include('website.includes.footer')
@endsection

@section('script')
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script>
        (function ($) {
            $(document).ready(function () {
                $('.form-submit-btn').on('click', function (event) {
                    event.preventDefault();
                    $('input[name=method]').val($(this).attr('data-title'));
                    $('#checkout-form').submit();
                });
            });
        })(jQuery);

    </script>
@endsection
