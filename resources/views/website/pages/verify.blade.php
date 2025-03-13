@extends('website.layouts.app')

@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}" async defer>
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/verification.css')}}" async defer>

@endsection


<!-- Contact section start -->

@section('content')
    @include('website.includes.nav')
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
                        @if(!is_null(\Illuminate\Support\Facades\Auth::user()->email))
                            <div class="mb-3 line-height color-red font-14"> {{ __('If you did not receive the email.') }} </div>
                        @endif

                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <div class="form-group clearfix mb-0">
                                @if(is_null(\Illuminate\Support\Facades\Auth::user()->email))
                                    <input type="email" class="form-control input-text mb-1 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required
                                           autocomplete="email" autofocus placeholder="Email Address" style="padding: 13px 50px 13px 50px; height:40px">

                                    @error('email')
                                    <span class="invalid-feedback font-12 my-2" role="alert">
                                        <strong style="color: #e3342f">{{ $message }}</strong>
                                    </span>
                                    @enderror

                                    <button type="submit" class="btn-md btn-theme btn-block mt-2" id="reg-form-submit">
                                        {{ __('click here to request link') }}
                                    </button>
                                @else
                                    <button type="submit" class="btn-md btn-theme btn-block mt-2" id="reg-form-submit">
                                        {{ __('click here to request another') }}
                                    </button>
                                @endif
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
                            <a href="https://www.facebook.com//people/Jaghacom/61570901009233/" class="facebook-bg" target="_blank">
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
@section('script')
    <script>
        (function ($) {
            $(document).ready(function () {
                $('#snackbar').hide();
            });
        })(jQuery);

    </script>

@endsection

