@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" href="{{asset('plugins/intl-tel-input/css/intlTelInput.min.css')}}" async defer>
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <style type="text/css" id="custom-background-css">
        body.custom-background {
            background-color: #eeeeee;
        }

        .card {
            background-color: white;
            margin: 5%;
            padding: 5%;
        }

        .heading-support {
            font-weight: 500;
            font-size: xx-large;
            color: black;
            text-align: center;

        }

        .mid-heading {
            color: black;
            text-align: center;
            font-stretch: expanded;
            font-size: 18px;

        }

        hr.new2 {
            border-top: 2px dashed #999999;
        }

        hr.new1 {
            border-top: 2px solid #999999;
        }

        .padding-left {
            padding-left: 15%;
        }

        .contact-info {
            color: black;
            font-size: 15px;

        }

        .color-white {
            color: black;
        }

        .padding-right {
            padding-right: 15%;;
        }

        .padding-top {
            padding-top: 10%;
        }

        hr {
            clear: both;
            display: block
        }

        .divider {
            display: inline-block;
            border-bottom: #999999 1px solid;
            width: 100%;
        }

        .container-fluid {
            padding: 0% !important;
        }

        .media-hover .fa-2x:hover {
            color: black;
        }

        .div-center {
            display: flex;
            justify-content: center;
        }

        .media-padding {
            padding: 0% !important;
        }

        .fa-2x {
            color: #999;
            font-size: 17px;
        }

        .mt-support {
            margin-top: 40px;
        }

    </style>
@endsection

@section('content')
    @include('website.includes.nav')

    <!-- Submit Property start -->
    <div class="submit-property mt-support">
        <div class="mt-5">
            <div class="card">
                <div class="row">
                    <div class="col-md-12 col-sm-12 mb-5">
                        <h2 class="heading-support">SUPPORT CENTER</h2>
                        <hr class="new2">

                        <p class="mid-heading">We'd <i class="fa fa-heart-o color-white"></i> to help!</p>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 padding-left mb-3">

                    </div>
                    <div class="col-md-6  padding-left padding-right padding-top">
                        <p class="contact-info mb-4 pr-15"><i class="fa fa-phone mr-2 color-white"></i>+92 51 4862317</p>
                        <p class="contact-info mb-4 pr-15"><i class="fa fa-mobile mr-2" style="font-size:24px;"></i>+92 315 5141959</p>
                        <p class="contact-info mb-4 pr-15"><i class="fa fa-envelope mr-2"></i>info@aboutpakistan.com</p>
                        <div class="divider"></div>
                        <div class="div-center color-white mt-2"> Join us on Social</div>
                        <div class="div-center color-white mt-2">
                            <a class="media-hover mr-2" href="https://www.facebook.com/aboutpkofficial" target="_blank"><i class="fab fa-facebook-f fa-2x"></i></a>
                            <a class="media-hover mr-2" href="https://twitter.com/aboutpkofficial" target="_blank"><i class="fab fa-twitter fa-2x"></i> </a>
                            <a class="media-hover mr-2" href="https://www.linkedin.com/company/aboutpkofficial" target="_blank"><i class="fab fa-linkedin in fa-2x"></i> </a>
                            <a class="media-hover mr-2" href="https://www.instagram.com/aboutpakofficial/" target="_blank"><i class="fab fa-instagram fa-2x"></i> </a>
                            <a class="media-hover mr-2" href="https://www.youtube.com/channel/UCfarVSSCib1eZ6sjFR3-gnA" target="_blank"><i class="fab fa-youtube fa-2x"></i> </a>
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
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('plugins/intl-tel-input/js/intlTelInput.js')}}"></script>
    <script src="{{asset('website/js/support-page.js')}}"></script>

@endsection
