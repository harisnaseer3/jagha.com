@extends('website.layouts.app')

@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection

@section('css')




@endsection


<!-- Contact section start -->

@section('content')
    <div class="contact-section">
        <div class="container">
            <div class="login-box" style="max-width: 500px;!important;">
                <div class="align-self-center pad-0">
                    <div class="form-section align-self-center">
                        <h3>Sign into your account</h3>
{{--                        <div class="btn-section clearfix">--}}
{{--                            <a href="{{ route('login') }}" class="link-btn active btn-1 active-bg">Login</a>--}}
{{--                            <a href="{{ route('register') }}" class="link-btn btn-2 default-bg">Register</a>--}}
{{--                        </div>--}}
                        <div class="mb-4">
                            <a href="{{url('/redirect')}}" class="btn btn-block btn-outline sign-in sign-card color-black" style="text-align: left;">
                                <img class="mr-4" src="{{asset('img\facebook-icon.png')}}" alt="facebook-icon" aria-label="facebook-login">Login with Facebook</a>

                            <a href="{{url('google/redirect')}}" class="btn btn-block btn-outline sign-in sign-card color-black" style="text-align: left;">
                                <img class="mr-4" src="{{asset('img\google-icon.png')}}" alt="google-icon" aria-label="google-login">Login with Google</a>
                        </div>
                        <div class="clearfix"></div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group form-box">
                                <input id="email" type="email" class="form-control input-text @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required
                                       autocomplete="email" placeholder="Email Address" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong style="color: #e3342f; margin-top: 0.25rem">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group form-box clearfix">
                                <input id="password" type="password" class="form-control input-text @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"
                                       placeholder="Password">
                                <span toggle="#password" class="fa fa-fw fa-eye  field-icon toggle-password" style="margin-top:-33px;"></span>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong style="color: #e3342f">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <div class="form-check" style="padding-left: 0">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label text-transform" for="remember" style="color: black; font-size:12px">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix mb-0">
                                <button type="submit" class="transition-background btn-md btn-theme float-left">
                                    {{ __('Login') }}
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



