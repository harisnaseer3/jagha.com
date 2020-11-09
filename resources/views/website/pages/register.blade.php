@extends('website.layouts.app')
@section('title')
    <title> Register Page : Property Portal By https://www.aboutpakistan.com</title>
@endsection

@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}" async defer>
    {{--    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">--}}
    {{--    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">--}}
    {{--    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">--}}
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

                        <form method="POST" action="{{ route('register') }}" class="validatedForm">
                            @csrf
                            <div class="form-group form-box">
                                <input id="name" type="text" class="form-control input-text @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name"
                                       autofocus placeholder="Full Name">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong style="color: #e3342f">{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="form-group form-box">
                                <input id="email" type="email" class="form-control input-text mb-2 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required
                                       autocomplete="email" placeholder="Email Address">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong style="color: #e3342f">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group form-box">
                                <input id="cell" type="tel" class="form-control input-text mb-2 @error('cell') is-invalid @enderror" name="cell" value="{{ old('cell') }}" required
                                       autocomplete="cell" placeholder="Cell Number">

                                @error('cell')
                                <span class="invalid-feedback" role="alert">
                                        <strong style="color: #e3342f">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group form-box clearfix">
                                <input id="password" type="password" class="form-control input-text mb-2  @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"
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
                            <div class="form-group form-box">
                                <input id="password-confirm" type="password" class="form-control input-text" name="password_confirmation" required autocomplete="new-password"
                                       placeholder="Confirm Password">
                            </div>
                            <div class="form-group  clearfix mb-0">
                                <button type="submit" class="btn-md btn-theme btn-block" id="reg-form-submit">
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
    <script>
        (function ($) {
            $(document).ready(function () {

                $("input[name='cell']").keyup(function () {
                    $(this).val($(this).val().replace(/^(\d{1})(\d+)$/, "+92-$2"));
                });
            });
        })(jQuery);

    </script>

@endsection

