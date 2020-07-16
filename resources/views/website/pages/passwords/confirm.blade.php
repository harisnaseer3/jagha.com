@extends('website.layouts.app')
@section('title', 'Confirm Password')

@section('css')

@endsection

<!-- Contact section start -->

@section('content')
    <div class="contact-section">
        <div class="container">
            <div class="login-box" style="max-width: 500px;!important;">
                <div class="align-self-center pad-0">
                    <div class="form-section clearfix">
                        <h3>{{ __('Confirm Password') }}</h3>

                        <div class="clearfix"></div>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf
                            <div class="form-group form-box clearfix">
                                <input id="password" type="password" class="form-control input-text @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"
                                       placeholder="Password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong style="color: #e3342f">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group clearfix mb-0">
                                <button type="submit" class="btn-md btn-theme btn-block">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
{{--                <div class="col-lg-6 bg-color-15 align-self-center pad-0 none-992 bg-img">--}}
{{--                    <div class="info clearfix">--}}
{{--                        <div class="logo-2">--}}
{{--                            <a href="{{route('home')}}">--}}
{{--                                <img src="{{asset('website/img/logos/logo-with-text-white-309x66.png')}}" class="cm-logo" alt="black-logo">--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        <div class="social-list">--}}
{{--                            <a href="https://www.facebook.com/aboutpk" class="facebook-bg" target="_blank">--}}
{{--                                <i class="fab fa-facebook-f"></i>--}}
{{--                            </a>--}}
{{--                            <a href="https://twitter.com/aboutpk_" class="twitter-bg" target="_blank">--}}
{{--                                <i class="fab fa-twitter"></i>--}}
{{--                            </a>--}}
{{--                            <a href="https://www.linkedin.com/company/cordstones/" class="linkedin-bg" target="_blank">--}}
{{--                                <i class="fab fa-linkedin-in"></i>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
@endsection
