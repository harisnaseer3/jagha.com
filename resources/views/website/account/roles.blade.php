@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Portfolio : Property Portal Software By https://www.aboutpakistan.com</title>
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
                                    @include('website.layouts.flash-message')
{{--                                    {{dd($role)}}--}}
                                    {{ Form::open(['route' => ['user_roles.update', !empty($role) ? $role[0] : $role], 'method' => 'put', 'role' => 'form']) }}
                                    <div class="card">
                                        <div class="card-header bg-success text-white text-capitalize">User Roles</div>
                                        <div class="card-body">
{{--                                            {{ Form::bsRadio('email_format', isset($account->email_format)?$account->email_format:'Text', ['required' => true, 'list' => ['HTML', 'Text']]) }}--}}
                                            <!-- TODO: $role get the user role name not id-->
                                            {{ Form::bsRadio('individual', 'Investor', ['list'=> ['Investor','Owner/Tenant'],'display' => 'block']) }}
{{--                                            {{ Form::bsCheckbox('individual[]', $role, [--}}
{{--                                                'list'=> [--}}
{{--                                                    (object) ['id' => 2, 'name' => 'Owner/Tenant'],--}}
{{--                                                    (object) ['id' => 3, 'name' => 'Investor'],--}}
{{--                                                ],--}}
{{--                                                'display' => 'block',--}}
{{--                                            ]) }}--}}
                                            {{ Form::bsRadio('company', isset($role)? $role :'', ['list' => ['Agent/Broker','Appraiser','Architect','Builder','Corporate Investor','Developer','Listing Administrator',
                                                  'Mortgage Broker','Partner','Property/Asset Manager','Researcher','Other'],'display' => 'block']) }}

                                            {{--                                            {{ Form::bsCheckbox('company[]', $role, [--}}
{{--                                                'list'=> [--}}
{{--                                                    (object) ['id' => 4, 'name' => 'Agent/Broker'],--}}
{{--                                                    (object) ['id' => 5, 'name' => 'Appraiser'],--}}
{{--                                                    (object) ['id' => 6, 'name' => 'Architect'],--}}
{{--                                                    (object) ['id' => 7, 'name' => 'Builder'],--}}
{{--                                                    (object) ['id' => 8, 'name' => 'Corporate Investor'],--}}
{{--                                                    (object) ['id' => 9, 'name' => 'Developer'],--}}
{{--                                                    (object) ['id' => 10, 'name' => 'Listing Administrator'],--}}
{{--                                                    (object) ['id' => 11, 'name' => 'Mortgage Broker'],--}}
{{--                                                    (object) ['id' => 12, 'name' => 'Partner'],--}}
{{--                                                    (object) ['id' => 13, 'name' => 'Property/Asset Manager'],--}}
{{--                                                    (object) ['id' => 14, 'name' => 'Researcher'],--}}
{{--                                                    (object) ['id' => 15, 'name' => 'Other'],--}}
{{--                                                ],--}}
{{--                                                'display' => 'block',--}}
{{--                                            ]) }}--}}
                                        </div>
                                        <div class="card-footer">
                                            {{ Form::submit('Update', ['class' => 'btn btn-primary btn-sm search-submit-btn']) }}
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
            });
        })(jQuery);
    </script>
@endsection
