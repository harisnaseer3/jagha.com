@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>Jagha - Buy Sell Rent Homes & Properties In Pakistan by https://www.jagha.com</title>
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
                                                    {{--                                                    <div class="col-sm-6 col-md-8">--}}
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
                                                    {{--                                                                                   placeholder="Your Name" data-default="Your name" name="name" type="text" value="Fatia" spellcheck="false"--}}
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
                                                    {{--                                                                                   placeholder="Your Email" data-default="Your Email" name="email" type="email" value="ridafatima477@gmail.com">--}}

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
                                                    {{--                                                    </div>--}}
                                                    {{--                                                    <div class="col-sm-6 col-md-4">--}}
                                                    {{--                                                        <div class="card my-4">--}}
                                                    {{--                                                            <div class="card-header theme-blue text-white">--}}
                                                    {{--                                                                <div class="font-14 font-weight-bold text-white"> Your Package</div>--}}
                                                    {{--                                                            </div>--}}

                                                    {{--                                                            <div class="card-body">--}}
                                                    {{--                                                                <table class="table table-responsive" style="width: 100%">--}}
                                                    {{--                                                                    <thead>--}}
                                                    {{--                                                                    <tr>--}}
                                                    {{--                                                                        <th>Package Detail</th>--}}
                                                    {{--                                                                        <th>Amount (Rs.)</th>--}}
                                                    {{--                                                                    </tr>--}}
                                                    {{--                                                                    </thead>--}}
                                                    {{--                                                                    <tbody>--}}
                                                    {{--                                                                    <tr>--}}
                                                    {{--                                                                        <td> A {{$result['type']}} Package of {{$result['for']}} For {{$result['duration']}} month(s).</td>--}}
                                                    {{--                                                                        <td>{{$result['amount']}}</td>--}}
                                                    {{--                                                                    </tr>--}}
                                                    {{--                                                                    </tbody>--}}
                                                    {{--                                                                </table>--}}
                                                    {{--                                                            </div>--}}

                                                    {{--                                                        </div>--}}
                                                    {{--                                                    </div>--}}
                                                </div>
                                            </div>
                                        </div>

                                        <h1>Please wait you will be redirected soon to <br>Jazzcash Payment Page</h1>
                                        <form name="redirectpost" method="POST" action="{{Config::get('constants.jazzcash.TRANSACTION_POST_URL')}}">
                                            <?php
                                            $post_data = Session::get('post_data');

                                            ?>
                                            @foreach($post_data as $key => $value)
                                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                            @endforeach

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



    <!-- Footer start -->
{{--    @include('website.includes.footer')--}}
@endsection

@section('script')
    {{--    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>--}}
    {{--    <script src="{{asset('plugins/intl-tel-input/js/intlTelInput.js')}}"></script>--}}
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    {{--    <script src="{{asset('website/js/package-form.js')}}"></script>--}}
    <script>
        (function ($) {
            window.onload = function closethisasap() {
                document.forms["redirectpost"].submit();
            }

        })(jQuery);

    </script>
@endsection
