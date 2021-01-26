@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
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
                                    @include('website.layouts.flash-message')
                                    {{ Form::open(['route' => ['settings.update', $account], 'method' => 'put', 'role' => 'form']) }}
                                    <div class="card">
                                        <div class="card-header theme-blue text-white text-capitalize">User Settings</div>
                                        <div class="card-body">
                                            <!-- {{ Form::bsTextArea('message_signature', isset($account->message_signature)?$account->message_signature:null) }} -->
                                            {{ Form::bsRadio('email_notification', isset($account->email_notification)?$account->email_notification:'Subscribe', ['required' => true, 'list' => ['Subscribe', 'Unsubscribe']]) }}
                                            {{ Form::bsRadio('newsletter', isset($account->newsletter)?$account->newsletter:'Subscribe', ['required' => true, 'list' => ['Subscribe', 'Unsubscribe']]) }}
                                            {{ Form::bsRadio('automated_reports', isset($account->automated_reports)?$account->automated_reports:'Subscribe', ['required' => true, 'list' => ['Subscribe', 'Unsubscribe']]) }}
                                            {{ Form::bsRadio('email_format', isset($account->email_format)?$account->email_format:'Text', ['required' => true, 'list' => ['HTML', 'Text']]) }}
                                        </div>

                                        <div class="card-header theme-blue text-white text-capitalize">General Settings</div>
                                        <div class="card-body">
                                            {{ Form::bsText('default_currency', isset($account->default_currency)?$account->default_currency:'Pakistan (PKR)', ['required' => true, 'readonly' => 'readonly']) }}


                                            {{ Form::bsSelect2('default_area_unit', ['Square Feet' => 'Square Feet', 'Square Meters' => 'Square Meters', 'Square Yards' => 'Square Yards','Marla' => 'Marla', 'Kanal'=>'Kanal'],
                                            isset($account->default_area_unit)?$account->default_area_unit:'Square Feet', ['required' => true]) }}
                                            {{ Form::bsText('default_language', isset($account->default_language)?$account->default_language:'English', ['required' => true, 'readonly' => 'readonly']) }}

                                        </div>

                                        <div class="card-header theme-blue text-white text-capitalize">SMS Settings</div>
                                        <div class="card-body">
                                            {{ Form::bsRadio('sms_notification', isset($account->sms_notification)?$account->sms_notification:'Off', ['required' => true, 'list' => ['On', 'Off']]) }}
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
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        (function ($) {
            $(document).ready(function () {
                // Initialize Select2 Elements
                $('.select2').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === 'en' ? 'ltr' : 'rtl'}}',
                });
                $('.select2bs4').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === 'en' ? 'ltr' : 'rtl'}}',
                    theme: 'bootstrap4',
                });
                $('[name=default_area_unit]').parent().children().css({'border': '1px solid #ced4da','border-radius': '.25rem'});
            });
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
                    url: window.location.origin  + '/dashboard/agencies/accept-invitation',
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
                    url: window.location.origin  + '/dashboard/agencies/reject-invitation',
                    data: {'notification_id': notification_id},
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
                    url: window.location.origin  + '/dashboard/property-notification',
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
        })(jQuery);
    </script>
@endsection
