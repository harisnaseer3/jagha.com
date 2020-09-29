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
                                    @include('website.layouts.user_notification')
                                    @include('website.layouts.flash-message')

                                    {{ Form::open(['route' => ['users.update',\Illuminate\Support\Facades\Auth::user()->id], 'method' => 'put', 'class'=> 'data-insertion-form', 'role' => 'form', 'enctype' => 'multipart/form-data']) }}
                                    <div class="card">
                                        <div class="card-header theme-blue text-white text-capitalize">User Profile</div>
                                        <div class="card-body">
                                            {{ Form::bsEmail('email', \Illuminate\Support\Facades\Auth::user()->email, ['required' => true, 'readonly' => 'readonly', 'data-default' => 'Email is locked for security reasons, contact admin to change.']) }}
                                            {{ Form::bsText('name', \Illuminate\Support\Facades\Auth::user()->name, ['required' => true]) }}
                                            {{ Form::bsTel('phone', isset($user->phone)?$user->phone: null, ['required' => true, 'data-default' => 'E.g. 0511234567']) }}
                                            {{ Form::bsTel('cell', isset($user->phone)?$user->cell: null, ['data-default' => 'E.g. 0301234567']) }}
                                            {{ Form::bsTel('fax', isset($user->fax)?$user->fax: null, ['data-default' => 'E.g. 0211234567']) }}
                                            {{ Form::bsText('address', isset($user->address)?$user->address: null) }}
                                            {{ Form::bsText('zip_code', isset($user->zip_code)?$user->zip_code: null) }}
                                            {{ Form::bsSelect2('country', ['Afghanistan' => 'Afghanistan', 'Albania' => 'Albania', 'Algeria' => 'Algeria', 'American Samoa' => 'American Samoa', 'Andorra' => 'Andorra', 'Angola' => 'Angola', 'Anguilla' => 'Anguilla', 'Antarctica' => 'Antarctica', 'Antigua and Barbuda' => 'Antigua and Barbuda', 'Argentina' => 'Argentina', 'Armenia' => 'Armenia', 'Aruba' => 'Aruba', 'Australia' => 'Australia', 'Austria' => 'Austria', 'Azerbaijan' => 'Azerbaijan', 'Bahamas' => 'Bahamas', 'Bahrain' => 'Bahrain', 'Bangladesh' => 'Bangladesh', 'Barbados' => 'Barbados', 'Belarus' => 'Belarus', 'Belgium' => 'Belgium', 'Belize' => 'Belize', 'Benin' => 'Benin', 'Bermuda' => 'Bermuda', 'Bhutan' => 'Bhutan', 'Bolivia' => 'Bolivia', 'Bosnia and Herzegoviegovina' => 'Bosnia and Herzegoviegovina', 'Botswana' => 'Botswana', 'Bouvet Island' => 'Bouvet Island', 'Brazil' => 'Brazil', 'British Indian Ocean Territory' => 'British Indian Ocean Territory', 'Brunei Darussalam' => 'Brunei Darussalam', 'Bulgaria' => 'Bulgaria', 'Burkina Faso' => 'Burkina Faso', 'Burundi' => 'Burundi', 'Cambodia' => 'Cambodia', 'Cameroon' => 'Cameroon', 'Canada' => 'Canada', 'Cape Verde' => 'Cape Verde', 'Cayman Islands' => 'Cayman Islands', 'Central African Republic' => 'Central African Republic', 'Chad' => 'Chad', 'Chile' => 'Chile', 'China' => 'China', 'Colombia' => 'Colombia', 'Comoros' => 'Comoros', 'Congo' => 'Congo', 'Cook Islands' => 'Cook Islands', 'Costa Rica' => 'Costa Rica', 'Cote D Ivoire' => 'Cote D Ivoire', 'Croatia' => 'Croatia', 'Cuba' => 'Cuba', 'Cyprus' => 'Cyprus', 'Czech Republic' => 'Czech Republic', 'Denmark' => 'Denmark', 'Djibouti' => 'Djibouti', 'Dominica' => 'Dominica', 'Dominican Republic' => 'Dominican Republic', 'Ecuador' => 'Ecuador', 'Egypt' => 'Egypt', 'El Salvador' => 'El Salvador', 'Equatorial Guinea' => 'Equatorial Guinea', 'Eritrea' => 'Eritrea', 'Estonia' => 'Estonia', 'Ethiopia' => 'Ethiopia', 'Falkland Islands (Malvinas)' => 'Falkland Islands (Malvinas)', 'Faroe Islands' => 'Faroe Islands', 'Fiji' => 'Fiji', 'Finland' => 'Finland', 'France' => 'France', 'French Guiana' => 'French Guiana', 'French Polynesia' => 'French Polynesia', 'French Southern Terri Territories' => 'French Southern Terri Territories', 'Gabon' => 'Gabon', 'Gambia' => 'Gambia', 'Georgia' => 'Georgia', 'Germany' => 'Germany', 'Ghana' => 'Ghana', 'Gibraltar' => 'Gibraltar', 'Greece' => 'Greece', 'Greenland' => 'Greenland', 'Grenada' => 'Grenada', 'Guadeloupe' => 'Guadeloupe', 'Guam' => 'Guam', 'Guatemala' => 'Guatemala', 'Guinea' => 'Guinea', 'Guinea-Bissau' => 'Guinea-Bissau', 'Guyana' => 'Guyana', 'Haiti' => 'Haiti', 'Heard Island and McDonald Islands' => 'Heard Island and McDonald Islands', 'Holy See (Vatican City State)' => 'Holy See (Vatican City State)', 'Honduras' => 'Honduras', 'Hong Kong' => 'Hong Kong', 'Hungary' => 'Hungary', 'Iceland' => 'Iceland', 'India' => 'India', 'Indonesia' => 'Indonesia', 'Iran' => 'Iran', 'Iraq' => 'Iraq', 'Ireland' => 'Ireland', 'Italy' => 'Italy', 'Jamaica' => 'Jamaica', 'Japan' => 'Japan', 'Jordan' => 'Jordan', 'Kazakhstan' => 'Kazakhstan', 'Kenya' => 'Kenya', 'Kiribati' => 'Kiribati', 'Korea' => 'Korea', 'Kuwait' => 'Kuwait', 'Kyrgyzstan' => 'Kyrgyzstan', 'Latvia' => 'Latvia', 'Lebanon' => 'Lebanon', 'Lesotho' => 'Lesotho', 'Liberia' => 'Liberia', 'Libyan Arab Jamahiriya' => 'Libyan Arab Jamahiriya', 'Liechtenstein' => 'Liechtenstein', 'Lithuania' => 'Lithuania', 'Luxembourg' => 'Luxembourg', 'Macau' => 'Macau', 'Macedonia' => 'Macedonia', 'Madagascar' => 'Madagascar', 'Malawi' => 'Malawi', 'Malaysia' => 'Malaysia', 'Maldives' => 'Maldives', 'Mali' => 'Mali', 'Malta' => 'Malta', 'Marshall Islands' => 'Marshall Islands', 'Martinique' => 'Martinique', 'Mauritania' => 'Mauritania', 'Mauritius' => 'Mauritius', 'Mayotte' => 'Mayotte', 'Mexico' => 'Mexico', 'Micronesia' => 'Micronesia', 'Moldova' => 'Moldova', 'Monaco' => 'Monaco', 'Mongolia' => 'Mongolia', 'Montserrat' => 'Montserrat', 'Morocco' => 'Morocco', 'Mozambique' => 'Mozambique', 'Myanmar' => 'Myanmar', 'Namibia' => 'Namibia', 'Nauru' => 'Nauru', 'Nepal' => 'Nepal', 'Netherlands' => 'Netherlands', 'Netherlands Antilles' => 'Netherlands Antilles', 'New Caledonia' => 'New Caledonia', 'New Zealand' => 'New Zealand', 'Nicaragua' => 'Nicaragua', 'Niger' => 'Niger', 'Nigeria' => 'Nigeria', 'Norfolk Island' => 'Norfolk Island', 'Northern Mariana Islands' => 'Northern Mariana Islands', 'Norway' => 'Norway', 'Oman' => 'Oman', 'Pakistan' => 'Pakistan', 'Palau' => 'Palau', 'Palestine' => 'Palestine', 'Panama' => 'Panama', 'Papua New Guinea' => 'Papua New Guinea', 'Paraguay' => 'Paraguay', 'Peru' => 'Peru', 'Philippines' => 'Philippines', 'Poland' => 'Poland', 'Portugal' => 'Portugal', 'Puerto Rico' => 'Puerto Rico', 'Qatar' => 'Qatar', 'Reunion' => 'Reunion', 'Romania' => 'Romania', 'Russian Federation' => 'Russian Federation', 'Rwanda' => 'Rwanda', 'Saint Kitts and Nevis' => 'Saint Kitts and Nevis', 'Saint Lucia' => 'Saint Lucia', 'Saint Vincent and the Grenadines' => 'Saint Vincent and the Grenadines', 'Samoa' => 'Samoa', 'San Marino' => 'San Marino', 'Sao Tome and Principe' => 'Sao Tome and Principe', 'Saudi Arabia' => 'Saudi Arabia', 'Senegal' => 'Senegal', 'Seychelles' => 'Seychelles', 'Sierra Leone' => 'Sierra Leone', 'Singapore' => 'Singapore', 'Slovakia' => 'Slovakia', 'Slovenia' => 'Slovenia', 'Solomon Islands' => 'Solomon Islands', 'Somalia' => 'Somalia', 'South Africa' => 'South Africa', 'Spain' => 'Spain', 'Sri Lanka' => 'Sri Lanka', 'Sudan' => 'Sudan', 'Suriname' => 'Suriname', 'Swaziland' => 'Swaziland', 'Sweden' => 'Sweden', 'Switzerland' => 'Switzerland', 'Syrian Arab Republic' => 'Syrian Arab Republic', 'Taiwan' => 'Taiwan', 'Tajikistan' => 'Tajikistan', 'Tanzania' => 'Tanzania', 'Thailand' => 'Thailand', 'Togo' => 'Togo', 'Tokelau' => 'Tokelau', 'Tonga' => 'Tonga', 'Trinidad and Tobago' => 'Trinidad and Tobago', 'Tunisia' => 'Tunisia', 'Turkey' => 'Turkey', 'Turkmenistan' => 'Turkmenistan', 'Turks and Caicos Islands' => 'Turks and Caicos Islands', 'Tuvalu' => 'Tuvalu', 'Uganda' => 'Uganda', 'Ukraine' => 'Ukraine', 'United Arab Emirates' => 'United Arab Emirates', 'United Kingdom' => 'United Kingdom', 'United States of America' => 'United States of America', 'United States Minor Outlying Islands' => 'United States Minor Outlying Islands', 'Uruguay' => 'Uruguay', 'Uzbekistan' => 'Uzbekistan', 'Vanuatu' => 'Vanuatu', 'Venezuela' => 'Venezuela', 'Vietnam' => 'Vietnam', 'Virgin Islands' => 'Virgin Islands', 'Virgin Islands' => 'Virgin Islands', 'Wallis and Futuna' => 'Wallis and Futuna', 'Yemen' => 'Yemen', 'Yugoslavia' => 'Yugoslavia', 'Zambia' => 'Zambia', 'Zimbabwe' => 'Zimbabwe'], isset($user->country)?$user->country:['Pakistan' => 'Pakistan'],['required' => true, 'placeholder' => 'Select country']) }}
                                            {{ Form::bsText('community_nick', isset($user->community_nick)?$user->community_nick: null, ['data-default' => 'Enter short name which you want to show on your profile.']) }}
                                            {{ Form::bsTextArea('about_yourself', isset($user->about_yourself)?$user->about_yourself: null,
                                                ['data-default' => 'Please provide information about yourself. You could tell us about your work, your interests, lifestyle, nature and other related information about your personality.Description should have almost 4096 characters']) }}
                                            @if(isset($user->image))
                                                <div class="form-group row">
                                                    <div class="col-sm-4 col-md-2 col-form-label col-form-label-sm">Picture</div>
                                                    <div class="col-sm-8 col-md-5">
                                                        <img class="img-fluid img-thumbnail w-25" src="{{isset($user->image)?asset('thumbnails/user_images/'.explode('.',$user->image)[0].'-450x350.webp'):''}}"
                                                             onerror="this.src='{{asset('img/default_user.jpg')}}'" alt="image"/>
                                                    </div>
                                                </div>
                                            @endif

                                            {{ Form::bsFile('upload_new_picture', null, ['required' => false, 'class' => 'img-fluid img-thumbnail w-50', 'multiple'=>'multiple', 'data-default' => 'Image dimension: 256x256, File size: 128 KB']) }}
{{--                                            {{ Form::bsCheckbox(null, null, ['list'=> [(object) ['id' => 0, 'name' => 'Update details in all property listings']]]) }}--}}
                                            <div class="mt-2"><span style="color:red">* </span>Picture will be updated on form submission</div>
                                            <div class="mt-2"><span style="color:red">* </span>Above details will be updated in all property listings</div>
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
                $("input[name='phone']").keyup(function () {
                    $(this).val($(this).val().replace(/^(\d{1})(\d+)$/, "+92-$2"));
                });
                $("input[name='cell']").keyup(function () {
                    $(this).val($(this).val().replace(/^(\d{1})(\d+)$/, "+92-$2"));
                });
                $("input[name='fax']").keyup(function () {
                    $(this).val($(this).val().replace(/^(\d{1})(\d+)$/, "+92-$2"));
                });
                $('[name=country]').parent().children().css({'border': '1px solid #ced4da','border-radius': '.25rem'});
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
        })(jQuery);
    </script>
@endsection
