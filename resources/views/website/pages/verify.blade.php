@extends('website.layouts.app')
@section('title', 'Login')

@section('css')
    {{--        <script src="{{ asset('js/app.js') }}" defer></script>--}}

@endsection

<!-- Contact section start -->

@section('content')
    <div class="contact-section">
        <div class="container">
            <div class="row login-box">
                <div class="col-lg-6 align-self-center pad-0">
                    <div class="form-section align-self-center">
                        <h3>{{ __('Verify Your Email Address') }}</h3>

                        <div class="clearfix"></div>

                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},

                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">

                            @csrf
                            <div class="form-group clearfix mb-0">
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.

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
                            <a href="https://www.facebook.com/aboutpk" class="facebook-bg" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/aboutpk_" class="twitter-bg" target="_blank">
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

