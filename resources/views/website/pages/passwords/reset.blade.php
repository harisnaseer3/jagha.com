@extends('website.layouts.app')
@section('title')
    <title> Password Reset Page : About Pakistan Properties https://www.properties.aboutpakistan.com</title>
@endsection

@section('css')
@endsection

<!-- Contact section start -->

@section('content')
    <div class="contact-section">
        <div class="container">
            <div class="login-box" style="max-width: 500px;!important;">
                <div class="align-self-center pad-0">
                    <div class="form-section clearfix">
                        <h3>Reset Password</h3>
                        <div class="clearfix"></div>
                        <form method="POST" action="{{ route('password.update') }}" id="reset-password-form">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group form-box">

                                <input id="email" type="email" class="form-control input-text  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required
                                       autocomplete="email" placeholder="Email Address">
                                @error('email')

                                <span class="invalid-feedback" role="alert">
                                        <strong style="color: #e3342f">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group form-box clearfix">
                                <input id="password" type="password" class="form-control input-text  @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"
                                       placeholder="Password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong style="color: #e3342f">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group form-box">
                                <input id="password-confirm" type="password" class="form-control input-text" name="password_confirmation" required autocomplete="new-password"
                                       placeholder="Confirm Password">
                            </div>

                            <div class="form-group clearfix mb-0">

                                <button type="submit" class="btn-md btn-theme float-left">
                                    {{ __('Reset Password') }}
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
    <script>
        (function ($) {

            $.validator.addMethod("checklower", function (value) {
                return /[a-z]/.test(value);
            });
            $.validator.addMethod("checkupper", function (value) {
                return /[A-Z]/.test(value);
            });
            $.validator.addMethod("checkdigit", function (value) {
                return /[0-9]/.test(value);
            });
            $.validator.addMethod("checkspecialchr", function (value) {
                return /[#?!@$%^&*-]/.test(value);
            });
            $(document).ready(function () {

                let form = $('#reset-password-form');
                form.validate({
                    rules: {
                        'email': {
                            required: true,
                            email: true
                        },

                        'password': {
                            required: true,
                            minlength: 8,
                            maxlength: 20,
                            checklower: true,
                            checkupper: true,
                            checkdigit: true,
                            checkspecialchr: true,
                        },
                        'password_confirmation': {
                            equalTo: "#password"
                        }
                    },
                    messages: {
                        'password': {
                            pwcheck: "Password is not strong enough",
                            checklower: "Need atleast 1 lowercase alphabet",
                            checkupper: "Need atleast 1 uppercase alphabet",
                            checkdigit: "Need atleast 1 digit",
                            checkspecialchr: "Need atleast 1 special character"
                        },
                    },
                    errorElement: 'small',
                    errorClass: 'help-block text-red',
                    submitHandler: function (form) {
                        form.submit();
                    },
                    invalidHandler: function (event, validator) {
                        // 'this' refers to the form
                        const errors = validator.numberOfInvalids();
                        if (errors) {
                            let error_tag = $('div.error.text-red.invalid-feedback');
                            error_tag.hide();
                            const message = errors === 1
                                ? 'You missed 1 field. It has been highlighted'
                                : 'You missed ' + errors + ' fields. They have been highlighted';
                            $('div.error.text-red.invalid-feedback strong').html(message);
                            error_tag.show();
                        } else {
                            $('#submit-block').show();
                            $('div.error.text-red.invalid-feedback').hide();
                        }
                    }
                });

            });
        })(jQuery);
    </script>

@endsection
