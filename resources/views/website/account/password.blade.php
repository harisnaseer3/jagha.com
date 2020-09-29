@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Portfolio : Property Portal Software By https://www.aboutpakistan.com</title>
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
                <h1>My Account &amp; Profiles</h1>
            </div>
        </div>
    </div>

    <!-- Submit Property start -->
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">


                    <div class="tab-content" id="portfolioTabContent">
                        <div class="tab-pane fade" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                            <div class="my-4">
                                Dashboard
                            </div>
                        </div>
                        <div class="tab-pane fade" id="property_management" role="tabpanel" aria-labelledby="property_management-tab">
                            <div class="my-4">
                                Property Management
                            </div>
                        </div>
                        <div class="tab-pane fade" id="message_center" role="tabpanel" aria-labelledby="message_center-tab">
                            <div class="my-4">
                                Message Center
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="account_profile" role="tabpanel" aria-labelledby="account_profile-tab">
                            <div class="row my-4">
                                <div class="col-md-3">
                                    @include('website.account.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.user_notification')
                                    @include('website.layouts.flash-message')
                                    {{ Form::open(['route' => 'user.password.update', 'method' => 'put', 'class'=> 'data-insertion-form', 'role' => 'form']) }}
                                    <div class="card">
                                        <div class="card-header theme-blue text-white text-capitalize">Change Password</div>
                                        <div class="card-body">
                                            {{ Form::bsPassword('current_password', ['required' => true]) }}
                                            {{ Form::bsPassword('new_password', ['required' => true,'data-default'=>' Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.']) }}
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
                        <div class="tab-pane fade" id="reports" role="tabpanel" aria-labelledby="reports-tab">
                            <div class="my-4">
                                Reports
                            </div>
                        </div>
                        <div class="tab-pane fade" id="agency_staff" role="tabpanel" aria-labelledby="agency_staff-tab">
                            <div class="my-4">
                                Agency Staff
                            </div>
                        </div>
                        <div class="tab-pane fade" id="clients_leads" role="tabpanel" aria-labelledby="clients_leads-tab">
                            <div class="my-4">
                                Clients &amp; Leads
                            </div>
                        </div>
                        <div class="tab-pane fade" id="agency_website" role="tabpanel" aria-labelledby="agency_website-tab">
                            <div class="my-4">
                                Agency Website
                            </div>
                        </div>
                        <div class="tab-pane fade" id="advertise" role="tabpanel" aria-labelledby="advertise-tab">
                            <div class="my-4">
                                Advertise
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
    <script>
        (function ($) {
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
                        url: window.location.origin + '/property' + '/dashboard/agencies/accept-invitation',
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
                        url: window.location.origin + '/property' + '/dashboard/agencies/reject-invitation',
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
                        url: window.location.origin + '/property' + '/dashboard/property-notification',
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
            });
        })(jQuery);
    </script>
@endsection
