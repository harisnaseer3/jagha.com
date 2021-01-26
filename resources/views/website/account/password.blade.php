@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')
    @include('website.includes.dashboard-nav')
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>My Account Settings</h1>
            </div>
        </div>
    </div>

    <!-- Submit Property start -->
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content" id="portfolioTabContent">

                        <div class="tab-pane fade show active" id="account_profile" role="tabpanel" aria-labelledby="account_profile-tab">
                            <div class="row my-4">
                                <div class="col-md-3">
                                    @include('website.account.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.flash-message')
                                    {{ Form::open(['route' => 'user.password.update', 'method' => 'put', 'class'=> 'data-insertion-form', 'role' => 'form']) }}
                                    <div class="card">
                                        <div class="card-header theme-blue text-white text-capitalize">Change Current Password</div>

                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <ul class="square-list-style">
                                                        <li class="square-list-li">You can change your current password.</li>
                                                        <li class="square-list-li">New password will be used your account logon.</li>
                                                    </ul>

                                                </div>

                                            </div>
                                            {{ Form::bsPassword('current_password', ['required' => true]) }}
                                            {{ Form::bsPassword('new_password', ['required' => true, 'id'=>'new_password', 'data-default'=>' Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.']) }}
                                            {{ Form::bsPassword('confirm_new_password', ['required' => true]) }}
                                        </div>
                                        <div class="card-footer">
                                            {{ Form::submit('Submit', ['class' => 'btn btn-primary btn-md search-submit-btn']) }}
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
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
                // Initialize Select2 Elements
                $('.btn-accept').on('click', function () {
                    let alert = $(this);
                    let agency_id = alert.attr('data-agency');
                    let user_id = alert.attr('data-user');
                    let notification_id = alert.attr('data-id');

                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        type: 'post',
                        url: window.location.origin + '/dashboard/agencies/accept-invitation',
                        data: {'agency_id': agency_id, 'user_id': user_id, 'notification_id': notification_id},
                        dataType: 'json',
                        success: function (data) {
                            // console.log(data);
                            if (data.status === 200) {
                                alert.closest('.alert').remove();
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                        },
                        complete: function (url, options) {

                        }
                    });
                });
                $('.btn-reject').on('click', function () {
                    let alert = $(this);
                    let notification_id = alert.attr('data-id');

                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        type: 'post',
                        url: window.location.origin + '/dashboard/agencies/reject-invitation',
                        data: {'notification_id': notification_id},
                        dataType: 'json',
                        success: function (data) {
                            // console.log(data);
                            if (data.status === 200) {
                                alert.closest('.alert').remove();
                            }
                        },
                        error: function (xhr, status, error) {
                            // console.log(xhr);
                            // console.log(status);
                            // console.log(error);
                        },
                        complete: function (url, options) {

                        }
                    });
                });
                $('.mark-as-read').on('click', function () {
                    let alert = $(this);
                    let notification_id = alert.attr('data-id');

                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        type: 'post',
                        url: window.location.origin + '/dashboard/property-notification',
                        data: {'notification_id': notification_id},
                        dataType: 'json',
                        success: function (data) {
                            // console.log(data);
                            if (data.status === 200) {
                                // console.log(alert);
                                alert.closest('.alert').remove();
                            }
                        },
                        error: function (xhr, status, error) {
                            // console.log(xhr);
                            // console.log(status);
                            // console.log(error);
                        },
                        complete: function (url, options) {

                        }
                    });
                });

                let form = $('.data-insertion-form');
                form.validate({
                    rules: {
                        'current_password': {
                            required: true,
                        },
                        'new_password': {
                            required: true,
                            minlength: 8,
                            maxlength: 20,
                            checklower: true,
                            checkupper: true,
                            checkdigit: true,
                            checkspecialchr: true,
                        },
                        'confirm_new_password': {
                            equalTo: "#new_password"
                        }
                    },
                    messages: {
                        'new_password': {
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
