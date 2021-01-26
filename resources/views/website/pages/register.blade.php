@extends('website.layouts.app')
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection

@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}" async defer>
    <link rel="stylesheet" href="{{asset('plugins/intl-tel-input/css/intlTelInput.min.css')}}" async defer>
@endsection

<!-- Contact section start -->

@section('content')
    <div class="contact-section">
        <div class="container">
            <div class="login-box" style="max-width: 500px;!important;">
                <div class="align-self-center pad-0">
                    <div class="form-section clearfix">
                        <h3>Create an account</h3>

                        <div class="clearfix"></div>
                        @include('website.layouts.flash-message')

                        <form method="POST" action="{{ route('register') }}" class="validatedForm" id="registrationForm">
                            @csrf
                            <div class="form-group form-box">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="register-label">Full Name <span style="color:red">* </span></label>
                                    </div>
                                    <div class="col-12">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name"
                                               autofocus placeholder="Full Name">
                                        @error('name')

                                        <span class="invalid-feedback" role="alert">
                                        <strong style="color: #e3342f">{{ $message }}</strong>
                                    </span>

                                        @enderror
                                    </div>
                                </div>


                            </div>

                            <div class="form-group form-box">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="register-label">Email Address <span style="color:red">* </span></label>
                                    </div>
                                    <div class="col-12">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required
                                               autocomplete="email" placeholder="Email Address">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong style="color: #e3342f">{{ $message }}</strong>
                                    </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-box">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="register-label">Phone <span style="color:red">* </span></label>
                                    </div>
                                    <div class="col-12">
                                        <input id="cell" type="tel" class="form-control
                                        @error('mobile_#') is-invalid @enderror"
                                               name="mobile_#" value="{{ old('mobile') }}" required
                                               autocomplete="mobile">
                                        <span id="valid-msg" class="hide validated mt-2">✓ Valid</span>
                                        <span id="error-msg" class="hide error mt-2"></span>

                                        <input class="form-control" name="mobile" type="hidden" value="{{ old('mobile') }}">

                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                        <strong style="color: #e3342f">{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group form-box clearfix">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="register-label">Password <span style="color:red">* </span></label>
                                    </div>
                                    <div class="col-12">
                                        <input id="password" type="password" class="form-control  mb-1  @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"
                                               placeholder="Password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong style="color: #e3342f">{{ $message }}</strong>
                                    </span>
                                        @enderror
                                        <p id="passwordHelpBlock" class="form-text text-muted font-12">
                                            Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.
                                        </p>

                                    </div>
                                </div>

                            </div>
                            <div class="form-group form-box">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="register-label">Confirm Password <span style="color:red">* </span></label>
                                    </div>
                                    <div class="col-12">
                                        <input id="password-confirm" type="password" class="form-control " name="password_confirmation" required autocomplete="new-password"
                                               placeholder="Confirm Password">

                                    </div>
                                </div>

                            </div>
                            <div class="form-group clearfix mb-0" id="submit-block">
                                <button type="submit" class="btn login-btn btn-theme btn-block" id="reg-form-submit">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/register-user.js')}}"></script>
    <script src="{{asset('plugins/intl-tel-input/js/intlTelInput.js')}}"></script>

@endsection

