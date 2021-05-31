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
                                    {{ Form::open(['route' => ['user_roles.update'], 'method' => 'put', 'role' => 'form']) }}
                                    <div class="card">
                                        <div class="card-header theme-blue text-white text-capitalize">Current User Role</div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <ul class="square-list-style">
                                                        <li class="square-list-li">You can change your current role.</li>
                                                        <li class="square-list-li">Role will be displayed on your dashboard along with profile details.</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- TODO: $role get the user role name not id-->
                                            {{--                                            {{ Form::bsRadio('role', '', ['list'=> ['Investor','Owner/Tenant'],'display' => 'block']) }}--}}
                                            @if(!empty($role))
                                                @if(in_array($role, ['Investor','Owner/Tenant','Agent/Broker','Appraiser','Architect','Builder','Corporate Investor','Developer','Listing Administrator',
                                                              'Mortgage Broker','Partner','Property/Asset Manager','Researcher'] ))
                                                    {{ Form::bsRadio('user_roles', $role, ['list' => ['Investor','Owner/Tenant','Agent/Broker','Appraiser','Architect','Builder','Corporate Investor','Developer','Listing Administrator',
                                                                  'Mortgage Broker','Partner','Property/Asset Manager','Researcher','Other'],'display' => 'block','class'=>'mt-3']) }}
                                                    <div class="other-textbox" style="display: none">
                                                        {{ Form::bsText('new_role',null,['id'=>'new_role']) }}
                                                    </div>
                                                @else
                                                    {{ Form::bsRadio('user_roles','Other', ['list' => ['Investor','Owner/Tenant','Agent/Broker','Appraiser','Architect','Builder','Corporate Investor','Developer','Listing Administrator',
                                                              'Mortgage Broker','Partner','Property/Asset Manager','Researcher','Other'],'display' => 'block','class'=>'mt-3']) }}

                                                    <div class="other-textbox" style="display: block">
                                                        {{ Form::bsText('new_role',$role,['id'=>'new_role']) }}
                                                    </div>
                                                @endif
                                            @else
                                                {{ Form::bsRadio('user_roles','Investor', ['list' => ['Investor','Owner/Tenant','Agent/Broker','Appraiser','Architect','Builder','Corporate Investor','Developer','Listing Administrator',
                                                                  'Mortgage Broker','Partner','Property/Asset Manager','Researcher','Other'],'display' => 'block','class'=>'mt-3']) }}

                                                <div class="other-textbox" style="display: none">
                                                    {{ Form::bsText('new_role',null,['id'=>'new_role']) }}
                                                </div>
                                            @endif

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

                $('[name=user_roles]').on('change', function () {
                    if ($('[name=user_roles]:checked').val() === 'Other') {
                        $('.other-textbox').show();
                        $('#new_role').prop('required', true);
                    } else {
                        $('#new_role').val('');
                        $('#new_role').prop('required', false);
                        $('.other-textbox').hide();
                    }

                });
                if ($('[name=user_roles]:checked').val() === 'Other') {
                    $('.other-textbox').show();
                    $('#new_role').prop('required', true);
                } else {
                    $('#new_role').prop('required', false);
                    $('.other-textbox').hide();
                }
                $('.search-submit-btn').on('click', function(){

                });
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
                        // console.log(xhr);
                        // console.log(status);
                        // console.log(error);
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
