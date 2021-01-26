@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection

@section('css_library')
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/intl-tel-input/css/intlTelInput.min.css')}}" async defer>

@endsection

@section('content')
    @include('website.includes.dashboard-nav')
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>Agency Profile</h1>
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
                                    @include('website.agency.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.flash-message')
                                    {{ Form::open(['route' => ['agencies.update', $agency], 'method' => 'put', 'role' => 'form','class'=>'data-insertion-form','enctype' => 'multipart/form-data']) }}
                                    <div class="card">
                                        <div class="card-header theme-blue text-white text-capitalize">Agency Profile</div>
                                        <div class="card-body">
                                            {{ Form::bsText('agency_id', isset($agency->id)?$agency->id:null, ['readonly' => 'readonly']) }}
                                            {{ Form::bsText('city', isset($agency->city)? $agency->city : null, ['readonly' => 'readonly']) }}
                                            {{ Form::bsText('company_title', isset($agency->title)? $agency->title : null, ['required' => true, 'data-default' => 'Please provide the official and registered name of your agency.','readonly' => 'readonly']) }}
                                            {{ Form::bsTextArea('description', isset($agency->description)? $agency->description : null, ['required' => true, 'data-default' => 'Please provided detailed information about your agency services. For example, does your company provide sales and rental services or both.Description should have almost 4096 characters.']) }}


                                            {{ Form::bsIntlTel('phone_#', isset($agency->phone)? $agency->phone : null, ['id'=>'phone']) }}
                                            {{Form::hidden('phone_check')}}
                                            {{ Form::bsIntlTel('mobile_#', isset($agency->cell)? $agency->cell : null, ['required' => true,'id'=>'cell']) }}

                                            {{ Form::bsIntlTel('optional_mobile_#', isset($agency->optional_number)? $agency->optional_number :null, ['id'=>'optional_mobile']) }}
                                            {{Form::hidden('optional_mobile_check')}}

                                            {{ Form::bsText('address', isset($agency->address)? $agency->address : null, ['required' => true]) }}
                                            {{ Form::bsText('zip_code', isset($agency->zip_code)? $agency->zip_code : null, ['data-default' => 'Postal Code must be of 5 digits']) }}
                                            {{ Form::bsSelect2('country', ['Afghanistan' => 'Afghanistan', 'Albania' => 'Albania', 'Algeria' => 'Algeria', 'American Samoa' => 'American Samoa', 'Andorra' => 'Andorra', 'Angola' => 'Angola', 'Anguilla' => 'Anguilla', 'Antarctica' => 'Antarctica', 'Antigua and Barbuda' => 'Antigua and Barbuda', 'Argentina' => 'Argentina', 'Armenia' => 'Armenia', 'Aruba' => 'Aruba', 'Australia' => 'Australia', 'Austria' => 'Austria', 'Azerbaijan' => 'Azerbaijan', 'Bahamas' => 'Bahamas', 'Bahrain' => 'Bahrain', 'Bangladesh' => 'Bangladesh', 'Barbados' => 'Barbados', 'Belarus' => 'Belarus', 'Belgium' => 'Belgium', 'Belize' => 'Belize', 'Benin' => 'Benin', 'Bermuda' => 'Bermuda', 'Bhutan' => 'Bhutan', 'Bolivia' => 'Bolivia', 'Bosnia and Herzegoviegovina' => 'Bosnia and Herzegoviegovina', 'Botswana' => 'Botswana', 'Bouvet Island' => 'Bouvet Island', 'Brazil' => 'Brazil', 'British Indian Ocean Territory' => 'British Indian Ocean Territory', 'Brunei Darussalam' => 'Brunei Darussalam', 'Bulgaria' => 'Bulgaria', 'Burkina Faso' => 'Burkina Faso', 'Burundi' => 'Burundi', 'Cambodia' => 'Cambodia', 'Cameroon' => 'Cameroon', 'Canada' => 'Canada', 'Cape Verde' => 'Cape Verde', 'Cayman Islands' => 'Cayman Islands', 'Central African Republic' => 'Central African Republic', 'Chad' => 'Chad', 'Chile' => 'Chile', 'China' => 'China', 'Colombia' => 'Colombia', 'Comoros' => 'Comoros', 'Congo' => 'Congo', 'Cook Islands' => 'Cook Islands', 'Costa Rica' => 'Costa Rica', 'Cote D Ivoire' => 'Cote D Ivoire', 'Croatia' => 'Croatia', 'Cuba' => 'Cuba', 'Cyprus' => 'Cyprus', 'Czech Republic' => 'Czech Republic', 'Denmark' => 'Denmark', 'Djibouti' => 'Djibouti', 'Dominica' => 'Dominica', 'Dominican Republic' => 'Dominican Republic', 'Ecuador' => 'Ecuador', 'Egypt' => 'Egypt', 'El Salvador' => 'El Salvador', 'Equatorial Guinea' => 'Equatorial Guinea', 'Eritrea' => 'Eritrea', 'Estonia' => 'Estonia', 'Ethiopia' => 'Ethiopia', 'Falkland Islands (Malvinas)' => 'Falkland Islands (Malvinas)', 'Faroe Islands' => 'Faroe Islands', 'Fiji' => 'Fiji', 'Finland' => 'Finland', 'France' => 'France', 'French Guiana' => 'French Guiana', 'French Polynesia' => 'French Polynesia', 'French Southern Terri Territories' => 'French Southern Terri Territories', 'Gabon' => 'Gabon', 'Gambia' => 'Gambia', 'Georgia' => 'Georgia', 'Germany' => 'Germany', 'Ghana' => 'Ghana', 'Gibraltar' => 'Gibraltar', 'Greece' => 'Greece', 'Greenland' => 'Greenland', 'Grenada' => 'Grenada', 'Guadeloupe' => 'Guadeloupe', 'Guam' => 'Guam', 'Guatemala' => 'Guatemala', 'Guinea' => 'Guinea', 'Guinea-Bissau' => 'Guinea-Bissau', 'Guyana' => 'Guyana', 'Haiti' => 'Haiti', 'Heard Island and McDonald Islands' => 'Heard Island and McDonald Islands', 'Holy See (Vatican City State)' => 'Holy See (Vatican City State)', 'Honduras' => 'Honduras', 'Hong Kong' => 'Hong Kong', 'Hungary' => 'Hungary', 'Iceland' => 'Iceland', 'India' => 'India', 'Indonesia' => 'Indonesia', 'Iran' => 'Iran', 'Iraq' => 'Iraq', 'Ireland' => 'Ireland', 'Italy' => 'Italy', 'Jamaica' => 'Jamaica', 'Japan' => 'Japan', 'Jordan' => 'Jordan', 'Kazakhstan' => 'Kazakhstan', 'Kenya' => 'Kenya', 'Kiribati' => 'Kiribati', 'Korea' => 'Korea', 'Kuwait' => 'Kuwait', 'Kyrgyzstan' => 'Kyrgyzstan', 'Latvia' => 'Latvia', 'Lebanon' => 'Lebanon', 'Lesotho' => 'Lesotho', 'Liberia' => 'Liberia', 'Libyan Arab Jamahiriya' => 'Libyan Arab Jamahiriya', 'Liechtenstein' => 'Liechtenstein', 'Lithuania' => 'Lithuania', 'Luxembourg' => 'Luxembourg', 'Macau' => 'Macau', 'Macedonia' => 'Macedonia', 'Madagascar' => 'Madagascar', 'Malawi' => 'Malawi', 'Malaysia' => 'Malaysia', 'Maldives' => 'Maldives', 'Mali' => 'Mali', 'Malta' => 'Malta', 'Marshall Islands' => 'Marshall Islands', 'Martinique' => 'Martinique', 'Mauritania' => 'Mauritania', 'Mauritius' => 'Mauritius', 'Mayotte' => 'Mayotte', 'Mexico' => 'Mexico', 'Micronesia' => 'Micronesia', 'Moldova' => 'Moldova', 'Monaco' => 'Monaco', 'Mongolia' => 'Mongolia', 'Montserrat' => 'Montserrat', 'Morocco' => 'Morocco', 'Mozambique' => 'Mozambique', 'Myanmar' => 'Myanmar', 'Namibia' => 'Namibia', 'Nauru' => 'Nauru', 'Nepal' => 'Nepal', 'Netherlands' => 'Netherlands', 'Netherlands Antilles' => 'Netherlands Antilles', 'New Caledonia' => 'New Caledonia', 'New Zealand' => 'New Zealand', 'Nicaragua' => 'Nicaragua', 'Niger' => 'Niger', 'Nigeria' => 'Nigeria', 'Norfolk Island' => 'Norfolk Island', 'Northern Mariana Islands' => 'Northern Mariana Islands', 'Norway' => 'Norway', 'Oman' => 'Oman', 'Pakistan' => 'Pakistan', 'Palau' => 'Palau', 'Palestine' => 'Palestine', 'Panama' => 'Panama', 'Papua New Guinea' => 'Papua New Guinea', 'Paraguay' => 'Paraguay', 'Peru' => 'Peru', 'Philippines' => 'Philippines', 'Poland' => 'Poland', 'Portugal' => 'Portugal', 'Puerto Rico' => 'Puerto Rico', 'Qatar' => 'Qatar', 'Reunion' => 'Reunion', 'Romania' => 'Romania', 'Russian Federation' => 'Russian Federation', 'Rwanda' => 'Rwanda', 'Saint Kitts and Nevis' => 'Saint Kitts and Nevis', 'Saint Lucia' => 'Saint Lucia', 'Saint Vincent and the Grenadines' => 'Saint Vincent and the Grenadines', 'Samoa' => 'Samoa', 'San Marino' => 'San Marino', 'Sao Tome and Principe' => 'Sao Tome and Principe', 'Saudi Arabia' => 'Saudi Arabia', 'Senegal' => 'Senegal', 'Seychelles' => 'Seychelles', 'Sierra Leone' => 'Sierra Leone', 'Singapore' => 'Singapore', 'Slovakia' => 'Slovakia', 'Slovenia' => 'Slovenia', 'Solomon Islands' => 'Solomon Islands', 'Somalia' => 'Somalia', 'South Africa' => 'South Africa', 'Spain' => 'Spain', 'Sri Lanka' => 'Sri Lanka', 'Sudan' => 'Sudan', 'Suriname' => 'Suriname', 'Swaziland' => 'Swaziland', 'Sweden' => 'Sweden', 'Switzerland' => 'Switzerland', 'Syrian Arab Republic' => 'Syrian Arab Republic', 'Taiwan' => 'Taiwan', 'Tajikistan' => 'Tajikistan', 'Tanzania' => 'Tanzania', 'Thailand' => 'Thailand', 'Togo' => 'Togo', 'Tokelau' => 'Tokelau', 'Tonga' => 'Tonga', 'Trinidad and Tobago' => 'Trinidad and Tobago', 'Tunisia' => 'Tunisia', 'Turkey' => 'Turkey', 'Turkmenistan' => 'Turkmenistan', 'Turks and Caicos Islands' => 'Turks and Caicos Islands', 'Tuvalu' => 'Tuvalu', 'Uganda' => 'Uganda', 'Ukraine' => 'Ukraine', 'United Arab Emirates' => 'United Arab Emirates', 'United Kingdom' => 'United Kingdom', 'United States of America' => 'United States of America', 'United States Minor Outlying Islands' => 'United States Minor Outlying Islands', 'Uruguay' => 'Uruguay', 'Uzbekistan' => 'Uzbekistan', 'Vanuatu' => 'Vanuatu', 'Venezuela' => 'Venezuela', 'Vietnam' => 'Vietnam', 'Virgin Islands' => 'Virgin Islands', 'Virgin Islands' => 'Virgin Islands', 'Wallis and Futuna' => 'Wallis and Futuna', 'Yemen' => 'Yemen', 'Yugoslavia' => 'Yugoslavia', 'Zambia' => 'Zambia', 'Zimbabwe' => 'Zimbabwe'],
                                               isset($agency->country)? ucwords($agency->country): 'Pakistan', ['required' => true, 'placeholder' => 'Select country']) }}
                                            {{ Form::bsEmail('email', $agency->email, ['required' => true, 'data-default' => 'Please provide an e-mail address for your agency. This e-mail can be different from your account e-mail.']) }}
                                            {{ Form::bsText('website', isset($agency->website)? $agency->website : null,['data-default' => 'Please provide your website like www.aboutpakistan.com']) }}
                                            @if(Auth::user()->hasRole('Admin'))
                                                {{ Form::bsSelect2('status', ['verified' => 'Verified', 'pending' => 'pending', 'expired' => 'Expired', 'deleted'=>'Deleted', 'rejected'=> 'Rejected'],
                                                   isset($agency->status) ? strtolower($agency->status) : null, ['required' => true, 'placeholder' => 'Select Status']) }}
                                            @endif
                                            @if(isset($agency->logo))
                                                <div class="form-group row">
                                                    <div class="col-sm-4 col-md-2 col-form-label col-form-label-sm">Company Logo</div>
                                                    <div class="col-sm-8 col-md-5">
                                                        <img class="img-fluid img-thumbnail w-50"
                                                             src="{{isset($agency->logo)?asset('thumbnails/agency_logos/'.explode('.',$agency->logo)[0].'-450x350.webp'):''}}"
                                                             onerror="this.src='{{asset('img/default_company.jpg')}}'" alt="image"/>
                                                    </div>
                                                </div>
                                            @endif

                                            {{ Form::bsFile('upload_new_logo', null, ['required' => false, 'class' => 'img-fluid img-thumbnail w-50', 'data-default' => 'Supported formats: (png, jpg, jpeg), File size: 128 KB']) }}
                                        </div>

                                        <div class="card-header theme-blue text-white text-capitalize">CEO / Owner Profile</div>
                                        <div class="card-body">
                                            {{ Form::bsText('name', isset($agency->ceo_name)?$agency->ceo_name:null) }}
                                            {{ Form::bsText('designation', isset($agency->ceo_designation)?$agency->ceo_designation:null) }}
                                            {{ Form::bsTextArea('about_CEO', isset($agency->ceo_message)?$agency->ceo_message:null) }}
                                            @if(isset($agency->ceo_image))
                                                <div class="form-group row">
                                                    <div class="col-sm-4 col-md-2 col-form-label col-form-label-sm">Picture</div>
                                                    <div class="col-sm-8 col-md-5">
                                                        <img class="img-fluid img-thumbnail w-25"
                                                             src="{{isset($agency->ceo_image)?asset('thumbnails/agency_ceo_images/'.explode('.',$agency->ceo_image)[0].'-450x350.webp'):''}}"
                                                             onerror="this.src='{{asset('img/default_user.jpg')}}'" alt="image"/>
                                                    </div>
                                                </div>
                                            @endif

                                            {{ Form::bsFile('upload_new_picture', null, ['required' => false, 'class' => 'img-fluid img-thumbnail w-50', 'data-default' => 'Supported formats: (png, jpg, jpeg), File size: 128 KB']) }}
                                            {{--                                            {{ Form::bsCheckbox(null, null, ['list'=> [(object) ['id' => 0, 'name' => 'Update details in all property listings']]]) }}--}}
                                            <div class="mt-2"><span style="color:red">*</span>Above details will be updated in all property listings</div>

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
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('plugins/intl-tel-input/js/intlTelInput.js')}}"></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('website/js/agency_create_form.js')}}"></script>
@endsection
