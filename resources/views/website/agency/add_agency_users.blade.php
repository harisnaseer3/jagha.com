@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Property Management By Property.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/intl-tel-input/css/intlTelInput.min.css')}}" async defer>
@endsection

@section('content')
    @include('website.includes.dashboard-nav')
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>Agency Users</h1>
            </div>
        </div>
    </div>
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="property_management-tab">
                        <div class="row my-4">
                            <div class="col-md-3">
                                @include('website.agency.sidebar')
                            </div>
                            <div class="col-md-9">
                                @include('website.layouts.flash-message')
                                <div class="card card-gray ">
                                    <div class="card-header theme-blue color-white">
                                        Agency Users
                                    </div>
                                    <div class="card-body">
                                        <h6> Agency Information</h6>
                                        <div class="row mb-3 mt-3">
                                            <div class="col-md-12">
                                                <strong>ID:</strong> {{$agency->id}}
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <strong>Title:</strong> {{$agency->title}}
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <strong>Address:</strong> {{$agency->address}}
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <strong>City:</strong> {{$agency->city->name}}
                                            </div>
                                        </div>
                                        <div class="row mb-3">

                                            <div class="col-md-4">
                                                <strong>Phone:</strong> {{$agency->phone}}
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <strong>Website:</strong>{{$agency->website}}
                                            </div>
                                        </div>
                                        <h6 class="mt-2"> Registered Users</h6>
                                        <div style="overflow-x:auto;">
                                        <table class="table table-md table-bordered">
                                            <thead class="theme-blue color-white">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Action</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(isset($current_agency_users) && count($current_agency_users) > 0)
                                                @foreach($current_agency_users as $agency_user)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$agency_user->name}}</td>
                                                        @if($agency->user_id === $agency_user->id)
                                                            <td>Agency CEO</td>
                                                        @elseif(count($agency_user->roles) > 0)
                                                            <td>{{$agency_user->roles[0]->name}}</td>
                                                        @else
                                                            <td></td>
                                                        @endif
                                                        <td>{{$agency_user->email}}</td>
                                                        <td>{{$agency_user->phone}}</td>
                                                        <td>@if($agency_user->is_active === '1') Active @else Inactive @endif</td>
                                                        <td>
                                                            @if($agency->user_id != $agency_user->id)
                                                            @if($agency_user->is_active === '0')
                                                                <div class='btn-group'>
                                                                    <a style="color: white" class="btn-sm btn btn-success" data-record-id="{{$agency_user->id}}" data-toggle="modal" data-target="#status-modal">Activate</a>
                                                                </div>
                                                            @elseif($agency_user->is_active === '1')
                                                                <div class='btn-group'>
                                                                    <a style="color: white" class="btn-sm btn btn-danger" data-record-id="{{$agency_user->id}}" data-toggle="modal" data-target="#status-modal">Deactivate</a>
                                                                </div>
                                                            @endif

                                                                @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                        </div>
                                        <div class="card">
                                            <div class="card-header bg-secondary color-white">
                                                Add User
                                            </div>
                                            {{ Form::open(['route' => ['agencies.store-agency-users',$agency->id], 'method' => 'post', 'class'=> 'data-insertion-form']) }}
                                            <div class="card-body">

                                                {{ Form::bsEmail('email',null, ['required' => true]) }}
                                                {{ Form::bsText('name', null, ['required' => true]) }}
                                                {{ Form::bsPassword('account_password', ['required' => true, 'id' => 'account_password', 'data-default'=>' Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.']) }}
                                                {{ Form::bsPassword('confirm_password', ['required' => true, 'id'=>'confirm_password']) }}
                                                {{ Form::bsIntlTel('phone_#', null, ['required' => true, 'id'=>'phone']) }}
                                                {{ Form::bsIntlTel('mobile_#',null, ['required' => true,'id'=>'cell']) }}
                                                {{ Form::bsText('address',null) }}
                                                {{ Form::bsText('zip_code',null) }}
                                                {{ Form::bsSelect2('country', ['Afghanistan' => 'Afghanistan', 'Albania' => 'Albania', 'Algeria' => 'Algeria', 'American Samoa' => 'American Samoa', 'Andorra' => 'Andorra', 'Angola' => 'Angola', 'Anguilla' => 'Anguilla', 'Antarctica' => 'Antarctica', 'Antigua and Barbuda' => 'Antigua and Barbuda', 'Argentina' => 'Argentina', 'Armenia' => 'Armenia', 'Aruba' => 'Aruba', 'Australia' => 'Australia', 'Austria' => 'Austria', 'Azerbaijan' => 'Azerbaijan', 'Bahamas' => 'Bahamas', 'Bahrain' => 'Bahrain', 'Bangladesh' => 'Bangladesh', 'Barbados' => 'Barbados', 'Belarus' => 'Belarus', 'Belgium' => 'Belgium', 'Belize' => 'Belize', 'Benin' => 'Benin', 'Bermuda' => 'Bermuda', 'Bhutan' => 'Bhutan', 'Bolivia' => 'Bolivia', 'Bosnia and Herzegoviegovina' => 'Bosnia and Herzegoviegovina', 'Botswana' => 'Botswana', 'Bouvet Island' => 'Bouvet Island', 'Brazil' => 'Brazil', 'British Indian Ocean Territory' => 'British Indian Ocean Territory', 'Brunei Darussalam' => 'Brunei Darussalam', 'Bulgaria' => 'Bulgaria', 'Burkina Faso' => 'Burkina Faso', 'Burundi' => 'Burundi', 'Cambodia' => 'Cambodia', 'Cameroon' => 'Cameroon', 'Canada' => 'Canada', 'Cape Verde' => 'Cape Verde', 'Cayman Islands' => 'Cayman Islands', 'Central African Republic' => 'Central African Republic', 'Chad' => 'Chad', 'Chile' => 'Chile', 'China' => 'China', 'Colombia' => 'Colombia', 'Comoros' => 'Comoros', 'Congo' => 'Congo', 'Cook Islands' => 'Cook Islands', 'Costa Rica' => 'Costa Rica', 'Cote D Ivoire' => 'Cote D Ivoire', 'Croatia' => 'Croatia', 'Cuba' => 'Cuba', 'Cyprus' => 'Cyprus', 'Czech Republic' => 'Czech Republic', 'Denmark' => 'Denmark', 'Djibouti' => 'Djibouti', 'Dominica' => 'Dominica', 'Dominican Republic' => 'Dominican Republic', 'Ecuador' => 'Ecuador', 'Egypt' => 'Egypt', 'El Salvador' => 'El Salvador', 'Equatorial Guinea' => 'Equatorial Guinea', 'Eritrea' => 'Eritrea', 'Estonia' => 'Estonia', 'Ethiopia' => 'Ethiopia', 'Falkland Islands (Malvinas)' => 'Falkland Islands (Malvinas)', 'Faroe Islands' => 'Faroe Islands', 'Fiji' => 'Fiji', 'Finland' => 'Finland', 'France' => 'France', 'French Guiana' => 'French Guiana', 'French Polynesia' => 'French Polynesia', 'French Southern Terri Territories' => 'French Southern Terri Territories', 'Gabon' => 'Gabon', 'Gambia' => 'Gambia', 'Georgia' => 'Georgia', 'Germany' => 'Germany', 'Ghana' => 'Ghana', 'Gibraltar' => 'Gibraltar', 'Greece' => 'Greece', 'Greenland' => 'Greenland', 'Grenada' => 'Grenada', 'Guadeloupe' => 'Guadeloupe', 'Guam' => 'Guam', 'Guatemala' => 'Guatemala', 'Guinea' => 'Guinea', 'Guinea-Bissau' => 'Guinea-Bissau', 'Guyana' => 'Guyana', 'Haiti' => 'Haiti', 'Heard Island and McDonald Islands' => 'Heard Island and McDonald Islands', 'Holy See (Vatican City State)' => 'Holy See (Vatican City State)', 'Honduras' => 'Honduras', 'Hong Kong' => 'Hong Kong', 'Hungary' => 'Hungary', 'Iceland' => 'Iceland', 'India' => 'India', 'Indonesia' => 'Indonesia', 'Iran' => 'Iran', 'Iraq' => 'Iraq', 'Ireland' => 'Ireland', 'Italy' => 'Italy', 'Jamaica' => 'Jamaica', 'Japan' => 'Japan', 'Jordan' => 'Jordan', 'Kazakhstan' => 'Kazakhstan', 'Kenya' => 'Kenya', 'Kiribati' => 'Kiribati', 'Korea' => 'Korea', 'Kuwait' => 'Kuwait', 'Kyrgyzstan' => 'Kyrgyzstan', 'Latvia' => 'Latvia', 'Lebanon' => 'Lebanon', 'Lesotho' => 'Lesotho', 'Liberia' => 'Liberia', 'Libyan Arab Jamahiriya' => 'Libyan Arab Jamahiriya', 'Liechtenstein' => 'Liechtenstein', 'Lithuania' => 'Lithuania', 'Luxembourg' => 'Luxembourg', 'Macau' => 'Macau', 'Macedonia' => 'Macedonia', 'Madagascar' => 'Madagascar', 'Malawi' => 'Malawi', 'Malaysia' => 'Malaysia', 'Maldives' => 'Maldives', 'Mali' => 'Mali', 'Malta' => 'Malta', 'Marshall Islands' => 'Marshall Islands', 'Martinique' => 'Martinique', 'Mauritania' => 'Mauritania', 'Mauritius' => 'Mauritius', 'Mayotte' => 'Mayotte', 'Mexico' => 'Mexico', 'Micronesia' => 'Micronesia', 'Moldova' => 'Moldova', 'Monaco' => 'Monaco', 'Mongolia' => 'Mongolia', 'Montserrat' => 'Montserrat', 'Morocco' => 'Morocco', 'Mozambique' => 'Mozambique', 'Myanmar' => 'Myanmar', 'Namibia' => 'Namibia', 'Nauru' => 'Nauru', 'Nepal' => 'Nepal', 'Netherlands' => 'Netherlands', 'Netherlands Antilles' => 'Netherlands Antilles', 'New Caledonia' => 'New Caledonia', 'New Zealand' => 'New Zealand', 'Nicaragua' => 'Nicaragua', 'Niger' => 'Niger', 'Nigeria' => 'Nigeria', 'Norfolk Island' => 'Norfolk Island', 'Northern Mariana Islands' => 'Northern Mariana Islands', 'Norway' => 'Norway', 'Oman' => 'Oman', 'Pakistan' => 'Pakistan', 'Palau' => 'Palau', 'Palestine' => 'Palestine', 'Panama' => 'Panama', 'Papua New Guinea' => 'Papua New Guinea', 'Paraguay' => 'Paraguay', 'Peru' => 'Peru', 'Philippines' => 'Philippines', 'Poland' => 'Poland', 'Portugal' => 'Portugal', 'Puerto Rico' => 'Puerto Rico', 'Qatar' => 'Qatar', 'Reunion' => 'Reunion', 'Romania' => 'Romania', 'Russian Federation' => 'Russian Federation', 'Rwanda' => 'Rwanda', 'Saint Kitts and Nevis' => 'Saint Kitts and Nevis', 'Saint Lucia' => 'Saint Lucia', 'Saint Vincent and the Grenadines' => 'Saint Vincent and the Grenadines', 'Samoa' => 'Samoa', 'San Marino' => 'San Marino', 'Sao Tome and Principe' => 'Sao Tome and Principe', 'Saudi Arabia' => 'Saudi Arabia', 'Senegal' => 'Senegal', 'Seychelles' => 'Seychelles', 'Sierra Leone' => 'Sierra Leone', 'Singapore' => 'Singapore', 'Slovakia' => 'Slovakia', 'Slovenia' => 'Slovenia', 'Solomon Islands' => 'Solomon Islands', 'Somalia' => 'Somalia', 'South Africa' => 'South Africa', 'Spain' => 'Spain', 'Sri Lanka' => 'Sri Lanka', 'Sudan' => 'Sudan', 'Suriname' => 'Suriname', 'Swaziland' => 'Swaziland', 'Sweden' => 'Sweden', 'Switzerland' => 'Switzerland', 'Syrian Arab Republic' => 'Syrian Arab Republic', 'Taiwan' => 'Taiwan', 'Tajikistan' => 'Tajikistan', 'Tanzania' => 'Tanzania', 'Thailand' => 'Thailand', 'Togo' => 'Togo', 'Tokelau' => 'Tokelau', 'Tonga' => 'Tonga', 'Trinidad and Tobago' => 'Trinidad and Tobago', 'Tunisia' => 'Tunisia', 'Turkey' => 'Turkey', 'Turkmenistan' => 'Turkmenistan', 'Turks and Caicos Islands' => 'Turks and Caicos Islands', 'Tuvalu' => 'Tuvalu', 'Uganda' => 'Uganda', 'Ukraine' => 'Ukraine', 'United Arab Emirates' => 'United Arab Emirates', 'United Kingdom' => 'United Kingdom', 'United States of America' => 'United States of America', 'United States Minor Outlying Islands' => 'United States Minor Outlying Islands', 'Uruguay' => 'Uruguay', 'Uzbekistan' => 'Uzbekistan', 'Vanuatu' => 'Vanuatu', 'Venezuela' => 'Venezuela', 'Vietnam' => 'Vietnam', 'Virgin Islands' => 'Virgin Islands', 'Virgin Islands' => 'Virgin Islands', 'Wallis and Futuna' => 'Wallis and Futuna', 'Yemen' => 'Yemen', 'Yugoslavia' => 'Yugoslavia', 'Zambia' => 'Zambia', 'Zimbabwe' => 'Zimbabwe'], isset($user->country)?$user->country:['Pakistan' => 'Pakistan'],['required' => true, 'placeholder' => 'Select country']) }}

                                            </div>
                                            <div class="card-footer">
                                                {{ Form::submit('Submit', ['class' => 'btn btn-primary btn-md search-submit-btn']) }}
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
        </div>
        @include('website.includes.footer')
        @include('website.layouts.change-user-status')
        @endsection

        @section('script')
            <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
            <script src="{{asset('plugins/intl-tel-input/js/intlTelInput.js')}}"></script>
            <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
            <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
            <script src="{{asset('website/js/agency-users.js')}}"></script>
    <script>
        (function ($) {
        $('#status-modal').on('show.bs.modal', function (event) {
            let record_id = $(event.relatedTarget).data('record-id');
            $(this).find('.modal-body #agency-user-id').val(record_id);
        });
        })(jQuery);
    </script>

@endsection
