@extends('website.layouts.app')

@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}" async defer>
    <link rel="stylesheet" type="text/css" href="{{asset('website/cssverification.css')}}" async defer>

@endsection


<!-- Contact section start -->

@section('content')
    <div class="contact-section">
        <div class="container">
            <div class="row login-box">
                <div class="col-lg-6 align-self-center pad-0">
                    <div class="form-section align-self-center">
                        <h3 class="color-blue">{{ __('Verify Your Email Address') }}</h3>

                        <div class="clearfix"></div>

                        @if (session('resent'))
                            <div class="alert alert-success line-height" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif
                        <div class="mb-3 line-height font-16">{{ __('Before proceeding, please check your email for a verification link.') }}</div>
                        <div class="mb-3 line-height color-red font-14"> {{ __('If you did not receive the email.') }} </div>

                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">

                            @csrf

                            <div class="form-group clearfix mb-0">
                                <button type="submit" class="btn-md btn-theme btn-block" id="reg-form-submit">
                                    {{ __('click here to request another') }}
                                </button>
{{--                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.--}}

                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 bg-color-15 align-self-center pad-0 none-992 bg-img">
                    <div class="info clearfix">
                        <div class="logo-2">
                            <a href="{{route('home')}}">
                                <img src="{{asset('website/img/logos/logo-with-text-white-309x66.png')}}" class="cm-logo" alt="black-logo">
                            </a>
                        </div>
                        <div class="social-list">
                            <a href="https://www.facebook.com/aboutpkofficial" class="facebook-bg" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/aboutpkofficial" class="twitter-bg" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/company/cordstones/" class="linkedin-bg" target="_blank">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

