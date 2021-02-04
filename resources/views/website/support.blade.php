@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/intl-tel-input/css/intlTelInput.min.css')}}" async defer>
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
    @include('website.includes.dashboard-nav')



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
                @include('website.layouts.flash-message')
                <form id="supportform" name="sendMessage" action="{{route('support.mail')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-sm-12 padding-left mb-3">
                            <div class="form-group row">
                                <label for="i am" class="col-12" style="font-size:1rem;">
                                    <strong>
                                        Account Details


                                    </strong>
                                </label>
                            </div>
                            <div class="form-group">
                                <input class="form-control" id="name" name="name" type="text" readonly value="{{Auth::guard('web')->user()->name}}" required="required">
                                <p class="help-block text-danger" id="nameHelp" style="display:none;">Please specify your name</p>
                            </div>
                            <div class="form-group">
                                <input class="form-control" id="your-email" type="email" readonly name="email" value="{{Auth::guard('web')->user()->email}}" required="required">
                                <p class="help-block text-danger" id="emailHelp" style="display:none;">Please specify your email</p>
                            </div>
                            <div class="form-group">
                                <input id="cell" type="tel" class="form-control" name="mobile_#" value="{{ Auth::guard('web')->user()->phone }}" required autocomplete="mobile">
                                <span id="valid-msg" class="hide validated mt-2">✓ Valid</span>
                                <span id="error-msg" class="hide error mt-2"></span>

                                <input class="form-control" name="mobile" type="hidden" value="{{ Auth::guard('web')->user()->phone }}">
                            </div>
                            <div class="form-group row">
                                <label for="i am" class="col-12" style="font-size:1rem;">
                                    <strong>
                                        Inquire About

                                    </strong>
                                </label>
                            </div>
                            <div class="form-group row">

                                <div class=" col-md-6 col-lg-4 col-xl-3">
                                    <div class="custom-control custom-radio custom-control-inline align-items-center">
                                        <input class="custom-control-input" type="radio" name="inquire_type" id="property_radio" value="Property" checked="">
                                        <label class="custom-control-label" style="line-height:1.2rem;" for="property_radio">
                                            Property </label>
                                    </div>

                                </div>
                                <div class=" col-md-6 col-lg-4 col-xl-3">
                                    <div class="custom-control custom-radio custom-control-inline align-items-center">
                                        <input class="custom-control-input" type="radio" name="inquire_type" id="agency_radio" value="Agency">
                                        <label class="custom-control-label" style="line-height:1.2rem;" for="agency_radio">
                                            Agency </label>
                                    </div>
                                </div>
                                <div class=" col-md-6 col-lg-4 col-xl-3">
                                    <div class="custom-control custom-radio custom-control-inline align-items-center">
                                        <input class="custom-control-input" type="radio" name="inquire_type" id="other_radio" value="Other">
                                        <label class="custom-control-label" style="line-height:1.2rem;" for="other_radio">
                                            Other </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="property-div">
                                <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible property-select2"
                                        style="width: 100%;border:0" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false"
                                        name="property_id" id="property-id" >
                                    <option disabled selected>Select property</option>
                                    @if(count($properties) > 0)
                                        @foreach($properties as $property)

                                            <option value="{{$property->id}}">{{$property->id}}</option>
                                        @endforeach
                                    @endif

                                </select>

                            </div>
                            <p class="help-block text-danger" id="propertyHelp" style="display:none;">Please select property</p>
                            <div class="form-group" style="display:none;" id="agency-div">
                                <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible agency-select2"
                                        style="width: 100%;border:0;" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false"
                                        name="agency_id" id="agency-id">
                                    <option disabled selected>Select Agency</option>
                                    @if(count($agencies) > 0)
                                        @foreach($agencies as $key => $value)
                                            @php $agency = \App\Models\Agency::getAgencyById($value)   @endphp

                                            <option value="{{$value}}">{{$value}} - {{$agency->title}}</option>
                                        @endforeach
                                    @endif

                                </select>

                            </div>
                            <div class="form-group" style="display:none;" id="other-div">
                                <input class="form-control" id="topic" name="topic" type="text" placeholder="Support Topic">
                                <p class="help-block text-danger" id="topicHelp" style="display:none;">Please specify Topic</p>
                            </div>
                            <p class="help-block text-danger" id="agencyHelp" style="display:none;">Please select agency</p>

                            <div class="form-group">
                                <input class="form-control" id="url" name="url" type="url" placeholder="Url">
                                <p class="help-block text-danger" id="urlHelp" style="display:none;">Please specify url</p>
                            </div>

                            <div class="form-group">
                                <textarea class="form-control" id="message" name="message" placeholder="Your Message *" rows="8" required="required"></textarea>
                                <p class="help-block text-danger" id="messageHelp" style="display:none;">Please specify your message</p>
                            </div>

                            <div class="form-group text-center">
                                <button id="sendMessageButton" class="btn btn-primary btn-xl text-uppercase" type="submit">Send Message</button>
                            </div>

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
                </form>
            </div>
        </div>
    </div>


    <!-- Footer start -->
    @include('website.includes.footer')
@endsection

@section('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('plugins/intl-tel-input/js/intlTelInput.js')}}"></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/support-page.js')}}"></script>

@endsection
