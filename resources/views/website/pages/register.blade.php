@extends('website.layouts.app')
@section('title')
    <title> Register Page : Property Management By https://www.aboutpakistan.com</title>
@endsection

@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
@endsection

<!-- Contact section start -->

@section('content')
    <div class="contact-section">
        <div class="container">
            <div class="login-box" style="max-width: 500px;!important;">
                <div class="align-self-center pad-0">
                    <div class="form-section clearfix">
                        <h3>Create an account</h3>
{{--                        <div class="btn-section clearfix">--}}
{{--                            <a href="{{ route('login') }}" class="link-btn btn-1 default-bg">Login</a>--}}
{{--                            <a href="{{ route('register') }}" class="link-btn active btn-2 active-bg ">Register</a>--}}
{{--                        </div>--}}
                        {{--                        <div class="mb-3">--}}
                        {{--                            <button class="btn-md btn-theme">--}}
                        {{--                                Login with Facebook--}}
                        {{--                            </button>--}}
                        {{--                        </div>--}}

                        <div class="clearfix"></div>
                        @include('website.layouts.flash-message')

                        <form method="POST" action="{{ route('register') }}">
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
                            <div class="form-group row">
                                <div class="col-sm-6" id="agency-container">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="agent-model" {{ old('agent-model') ? 'checked' : '' }} id="agent-model">
                                        <label class="form-check-label text-transform mt-1" for="agent-model" style="color: black; font-size:12px">
                                            {{ __('Are You an Agent?') }}
                                        </label>
                                    </div>
                                    <input type="hidden" value="{{ old('agency-cities') }}" name="agency-cities">
                                    <input type="hidden" value="{{ old('agency-email') }}" name="agency-email">
                                    <input type="hidden" value="{{ old('agency-title') }}" name="agency-title">
                                    <input type="hidden" value="{{ old('agency-description') }}" name="agency-description">
                                    <input type="hidden" value="{{ old('agency-phone') }}" name="agency-phone">
                                    <input type="hidden" value="{{ old('agency-cell') }}" name="agency-cell">
                                    <input type="hidden" value="{{ old('agency-fax') }}" name="agency-fax">
                                    <input type="hidden" value="{{ old('agency-address') }}" name="agency-address">
                                    <input type="hidden" value="{{ old('agency-zip_code') }}" name="agency-zip_code">
                                    <input type="hidden" value="{{ old('agency-country') }}" name="agency-country">
                                    <input type="hidden" value="{{ old('agency-website') }}" name="agency-website">
                                </div>
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
    <div class="modal fade" id="agentModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 500px">
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Agency Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <div class="card-body">
                        <div class="fetal-error text-red"></div>
                        {{ Form::open(['route' => ['validation'], 'method' => 'post', 'role' => 'form', 'enctype' => 'multipart/form-data', 'id' => 'add-agency']) }}
                        {{ Form::bsSelect2('select_cities[]', ['Abbottabad' => 'Abbottabad', 'Abdul Hakim' => 'Abdul Hakim', 'Ahmedpur East' => 'Ahmedpur East', 'Alipur' => 'Alipur', 'Arifwala' => 'Arifwala', 'Astore' => 'Astore', 'Attock' => 'Attock', 'Awaran' => 'Awaran', 'Badin' => 'Badin', 'Bagh' => 'Bagh', 'Bahawalnagar' => 'Bahawalnagar', 'Bahawalpur' => 'Bahawalpur', 'Balakot' => 'Balakot', 'Bannu' => 'Bannu', 'Barnala' => 'Barnala', 'Batkhela' => 'Batkhela', 'Bhakkar' => 'Bhakkar', 'Bhalwal' => 'Bhalwal', 'Bhimber' => 'Bhimber', 'Buner' => 'Buner', 'Burewala' => 'Burewala', 'Chaghi' => 'Chaghi', 'Chakwal' => 'Chakwal', 'Charsadda' => 'Charsadda', 'Chichawatni' => 'Chichawatni', 'Chiniot' => 'Chiniot', 'Chishtian Sharif' => 'Chishtian Sharif', 'Chitral' => 'Chitral', 'Choa Saidan Shah' => 'Choa Saidan Shah', 'Chunian' => 'Chunian', 'Dadu' => 'Dadu', 'Daharki' => 'Daharki', 'Daska' => 'Daska', 'Daur' => 'Daur', 'Depalpur' => 'Depalpur', 'Dera Ghazi Khan' => 'Dera Ghazi Khan', 'Dera Ismail Khan' => 'Dera Ismail Khan', 'Dijkot' => 'Dijkot', 'Dina' => 'Dina', 'Dobian' => 'Dobian', 'Duniya Pur' => 'Duniya Pur', 'Faisalabad' => 'Faisalabad', 'FATA' => 'FATA', 'Fateh Jang' => 'Fateh Jang', 'Gaarho' => 'Gaarho', 'Gadoon' => 'Gadoon', 'Galyat' => 'Galyat', 'Ghakhar' => 'Ghakhar', 'Gharo' => 'Gharo', 'Ghotki' => 'Ghotki', 'Gilgit' => 'Gilgit', 'Gojra' => 'Gojra', 'Gujar Khan' => 'Gujar Khan', 'Gujranwala' => 'Gujranwala', 'Gujrat' => 'Gujrat', 'Gwadar' => 'Gwadar', 'Hafizabad' => 'Hafizabad', 'Hala' => 'Hala', 'Hangu' => 'Hangu', 'Harappa' => 'Harappa', 'Haripur' => 'Haripur', 'Haroonabad' => 'Haroonabad', 'Hasilpur' => 'Hasilpur', 'Hassan Abdal' => 'Hassan Abdal', 'Haveli Lakha' => 'Haveli Lakha', 'Hazro' => 'Hazro', 'Hub Chowki' => 'Hub Chowki', 'Hujra Shah Muqeem' => 'Hujra Shah Muqeem', 'Hunza' => 'Hunza', 'Hyderabad' => 'Hyderabad', 'Islamabad' => 'Islamabad', 'Jacobabad' => 'Jacobabad', 'Jahanian' => 'Jahanian', 'Jalalpur Jattan' => 'Jalalpur Jattan', 'Jampur' => 'Jampur', 'Jamshoro' => 'Jamshoro', 'Jatoi' => 'Jatoi', 'Jauharabad' => 'Jauharabad', 'Jhang' => 'Jhang', 'Jhelum' => 'Jhelum', 'Kaghan' => 'Kaghan', 'Kahror Pakka' => 'Kahror Pakka', 'Kalat' => 'Kalat', 'Kamalia' => 'Kamalia', 'Kamoki' => 'Kamoki', 'Kandiaro' => 'Kandiaro', 'Karachi' => 'Karachi', 'Karak' => 'Karak', 'Kasur' => 'Kasur', 'Khairpur' => 'Khairpur', 'Khanewal' => 'Khanewal', 'Khanpur' => 'Khanpur', 'Kharian' => 'Kharian', 'Khipro' => 'Khipro', 'Khushab' => 'Khushab', 'Khuzdar' => 'Khuzdar', 'Kohat' => 'Kohat', 'Kot Addu' => 'Kot Addu', 'Kotli' => 'Kotli', 'Kotri' => 'Kotri', 'Lahore' => 'Lahore', 'Lakki Marwat' => 'Lakki Marwat', 'Lalamusa' => 'Lalamusa', 'Larkana' => 'Larkana', 'Lasbela' => 'Lasbela', 'Layyah' => 'Layyah', 'Liaquatpur' => 'Liaquatpur', 'Lodhran' => 'Lodhran', 'Loralai' => 'Loralai', 'Lower Dir' => 'Lower Dir', 'Mailsi' => 'Mailsi', 'Makran' => 'Makran', 'Malakand' => 'Malakand', 'Mandi Bahauddin' => 'Mandi Bahauddin', 'Mangla' => 'Mangla', 'Mansehra' => 'Mansehra', 'Mardan' => 'Mardan', 'Matiari' => 'Matiari', 'Matli' => 'Matli', 'Mian Channu' => 'Mian Channu', 'Mianwali' => 'Mianwali', 'Mingora' => 'Mingora', 'Mirpur' => 'Mirpur', 'Mirpur Khas' => 'Mirpur Khas', 'Mirpur Sakro' => 'Mirpur Sakro', 'Mitha Tiwana' => 'Mitha Tiwana', 'Moro' => 'Moro', 'Multan' => 'Multan', 'Muridke' => 'Muridke', 'Murree' => 'Murree', 'Muzaffarabad' => 'Muzaffarabad', 'Muzaffargarh' => 'Muzaffargarh', 'Nankana Sahib' => 'Nankana Sahib', 'Naran' => 'Naran', 'Narowal' => 'Narowal', 'Nasar Ullah Khan Town' => 'Nasar Ullah Khan Town', 'Nasirabad' => 'Nasirabad', 'Naushahro Feroze' => 'Naushahro Feroze', 'Nawabshah' => 'Nawabshah', 'Neelum' => 'Neelum', 'New Mirpur City' => 'New Mirpur City', 'Nowshera' => 'Nowshera', 'Okara' => 'Okara', 'Others' => 'Others', 'Others Azad Kashmir' => 'Others Azad Kashmir', 'Others Balochistan' => 'Others Balochistan', 'Others Gilgit Baltistan' => 'Others Gilgit Baltistan', 'Others Khyber Pakhtunkhwa' => 'Others Khyber Pakhtunkhwa', 'Others Punjab' => 'Others Punjab', 'Others Sindh' => 'Others Sindh', 'Pakpattan' => 'Pakpattan', 'Peshawar' => 'Peshawar', 'Pind Dadan Khan' => 'Pind Dadan Khan', 'Pindi Bhattian' => 'Pindi Bhattian', 'Pir Mahal' => 'Pir Mahal', 'Qazi Ahmed' => 'Qazi Ahmed', 'Quetta' => 'Quetta', 'Rahim Yar Khan' => 'Rahim Yar Khan', 'Rajana' => 'Rajana', 'Rajanpur' => 'Rajanpur', 'Ratwal' => 'Ratwal', 'Rawalkot' => 'Rawalkot', 'Rawalpindi' => 'Rawalpindi', 'Rohri' => 'Rohri', 'Sadiqabad' => 'Sadiqabad', 'Sahiwal' => 'Sahiwal', 'Sakrand' => 'Sakrand', 'Samundri' => 'Samundri', 'Sanghar' => 'Sanghar', 'Sarai Alamgir' => 'Sarai Alamgir', 'Sargodha' => 'Sargodha', 'Sehwan' => 'Sehwan', 'Shabqadar' => 'Shabqadar', 'Shahdadpur' => 'Shahdadpur', 'Shahkot' => 'Shahkot', 'Shahpur Chakar' => 'Shahpur Chakar', 'Shakargarh' => 'Shakargarh', 'Shehr Sultan' => 'Shehr Sultan', 'Sheikhupura' => 'Sheikhupura', 'Sher Garh' => 'Sher Garh', 'Shikarpur' => 'Shikarpur', 'Shorkot' => 'Shorkot', 'Sialkot' => 'Sialkot', 'Sibi' => 'Sibi', 'Skardu' => 'Skardu', 'Sudhnoti' => 'Sudhnoti', 'Sujawal' => 'Sujawal', 'Sukkur' => 'Sukkur', 'Swabi' => 'Swabi', 'Swat' => 'Swat', 'Talagang' => 'Talagang', 'Tando Adam' => 'Tando Adam', 'Tando Allahyar' => 'Tando Allahyar', 'Tando Bago' => 'Tando Bago', 'Tando Muhammad Khan' => 'Tando Muhammad Khan', 'Taxila' => 'Taxila', 'Tharparkar' => 'Tharparkar', 'Thatta' => 'Thatta', 'Toba Tek Singh' => 'Toba Tek Singh', 'Turbat' => 'Turbat', 'Vehari' => 'Vehari', 'Wah' => 'Wah', 'Wazirabad' => 'Wazirabad', 'Waziristan' => 'Waziristan', 'Yazman' => 'Yazman', 'Zhob' => 'Zhob'],
                             old('select_cities[]') , ['multiple' => 'multiple', 'data-default' => 'Select one or more cities you deal in.','id'=>'cities','placeholder' => 'Select city']) }}
                        {{ Form::bsText('company_title', null, [ 'data-default' => 'Please provide the official and registered name of your agency.']) }}
                        {{ Form::bsTextArea('description', null, ['data-default' => 'Please provided detailed information about your agency services. For example, does your company provide sales and rental services or both.']) }}
                        {{ Form::bsTel('phone', null, ['data-default' => 'E.g. +92-51-1234567']) }}
                        {{ Form::bsTel('cell', null, ['data-default' => 'E.g. +92-300-1234567']) }}
                        {{ Form::bsTel('fax', null, ['data-default' => 'E.g. +92-21-1234567']) }}
                        {{ Form::bsText('address', null) }}
                        {{ Form::bsText('zip_code', null) }}
                        {{ Form::bsSelect2('country', ['Afghanistan' => 'Afghanistan', 'Albania' => 'Albania', 'Algeria' => 'Algeria', 'American Samoa' => 'American Samoa', 'Andorra' => 'Andorra', 'Angola' => 'Angola', 'Anguilla' => 'Anguilla', 'Antarctica' => 'Antarctica', 'Antigua and Barbuda' => 'Antigua and Barbuda', 'Argentina' => 'Argentina', 'Armenia' => 'Armenia', 'Aruba' => 'Aruba', 'Australia' => 'Australia', 'Austria' => 'Austria', 'Azerbaijan' => 'Azerbaijan', 'Bahamas' => 'Bahamas', 'Bahrain' => 'Bahrain', 'Bangladesh' => 'Bangladesh', 'Barbados' => 'Barbados', 'Belarus' => 'Belarus', 'Belgium' => 'Belgium', 'Belize' => 'Belize', 'Benin' => 'Benin', 'Bermuda' => 'Bermuda', 'Bhutan' => 'Bhutan', 'Bolivia' => 'Bolivia', 'Bosnia and Herzegoviegovina' => 'Bosnia and Herzegoviegovina', 'Botswana' => 'Botswana', 'Bouvet Island' => 'Bouvet Island', 'Brazil' => 'Brazil', 'British Indian Ocean Territory' => 'British Indian Ocean Territory', 'Brunei Darussalam' => 'Brunei Darussalam', 'Bulgaria' => 'Bulgaria', 'Burkina Faso' => 'Burkina Faso', 'Burundi' => 'Burundi', 'Cambodia' => 'Cambodia', 'Cameroon' => 'Cameroon', 'Canada' => 'Canada', 'Cape Verde' => 'Cape Verde', 'Cayman Islands' => 'Cayman Islands', 'Central African Republic' => 'Central African Republic', 'Chad' => 'Chad', 'Chile' => 'Chile', 'China' => 'China', 'Colombia' => 'Colombia', 'Comoros' => 'Comoros', 'Congo' => 'Congo', 'Cook Islands' => 'Cook Islands', 'Costa Rica' => 'Costa Rica', 'Cote D Ivoire' => 'Cote D Ivoire', 'Croatia' => 'Croatia', 'Cuba' => 'Cuba', 'Cyprus' => 'Cyprus', 'Czech Republic' => 'Czech Republic', 'Denmark' => 'Denmark', 'Djibouti' => 'Djibouti', 'Dominica' => 'Dominica', 'Dominican Republic' => 'Dominican Republic', 'Ecuador' => 'Ecuador', 'Egypt' => 'Egypt', 'El Salvador' => 'El Salvador', 'Equatorial Guinea' => 'Equatorial Guinea', 'Eritrea' => 'Eritrea', 'Estonia' => 'Estonia', 'Ethiopia' => 'Ethiopia', 'Falkland Islands (Malvinas)' => 'Falkland Islands (Malvinas)', 'Faroe Islands' => 'Faroe Islands', 'Fiji' => 'Fiji', 'Finland' => 'Finland', 'France' => 'France', 'French Guiana' => 'French Guiana', 'French Polynesia' => 'French Polynesia', 'French Southern Terri Territories' => 'French Southern Terri Territories', 'Gabon' => 'Gabon', 'Gambia' => 'Gambia', 'Georgia' => 'Georgia', 'Germany' => 'Germany', 'Ghana' => 'Ghana', 'Gibraltar' => 'Gibraltar', 'Greece' => 'Greece', 'Greenland' => 'Greenland', 'Grenada' => 'Grenada', 'Guadeloupe' => 'Guadeloupe', 'Guam' => 'Guam', 'Guatemala' => 'Guatemala', 'Guinea' => 'Guinea', 'Guinea-Bissau' => 'Guinea-Bissau', 'Guyana' => 'Guyana', 'Haiti' => 'Haiti', 'Heard Island and McDonald Islands' => 'Heard Island and McDonald Islands', 'Holy See (Vatican City State)' => 'Holy See (Vatican City State)', 'Honduras' => 'Honduras', 'Hong Kong' => 'Hong Kong', 'Hungary' => 'Hungary', 'Iceland' => 'Iceland', 'India' => 'India', 'Indonesia' => 'Indonesia', 'Iran' => 'Iran', 'Iraq' => 'Iraq', 'Ireland' => 'Ireland', 'Italy' => 'Italy', 'Jamaica' => 'Jamaica', 'Japan' => 'Japan', 'Jordan' => 'Jordan', 'Kazakhstan' => 'Kazakhstan', 'Kenya' => 'Kenya', 'Kiribati' => 'Kiribati', 'Korea' => 'Korea', 'Kuwait' => 'Kuwait', 'Kyrgyzstan' => 'Kyrgyzstan', 'Latvia' => 'Latvia', 'Lebanon' => 'Lebanon', 'Lesotho' => 'Lesotho', 'Liberia' => 'Liberia', 'Libyan Arab Jamahiriya' => 'Libyan Arab Jamahiriya', 'Liechtenstein' => 'Liechtenstein', 'Lithuania' => 'Lithuania', 'Luxembourg' => 'Luxembourg', 'Macau' => 'Macau', 'Macedonia' => 'Macedonia', 'Madagascar' => 'Madagascar', 'Malawi' => 'Malawi', 'Malaysia' => 'Malaysia', 'Maldives' => 'Maldives', 'Mali' => 'Mali', 'Malta' => 'Malta', 'Marshall Islands' => 'Marshall Islands', 'Martinique' => 'Martinique', 'Mauritania' => 'Mauritania', 'Mauritius' => 'Mauritius', 'Mayotte' => 'Mayotte', 'Mexico' => 'Mexico', 'Micronesia' => 'Micronesia', 'Moldova' => 'Moldova', 'Monaco' => 'Monaco', 'Mongolia' => 'Mongolia', 'Montserrat' => 'Montserrat', 'Morocco' => 'Morocco', 'Mozambique' => 'Mozambique', 'Myanmar' => 'Myanmar', 'Namibia' => 'Namibia', 'Nauru' => 'Nauru', 'Nepal' => 'Nepal', 'Netherlands' => 'Netherlands', 'Netherlands Antilles' => 'Netherlands Antilles', 'New Caledonia' => 'New Caledonia', 'New Zealand' => 'New Zealand', 'Nicaragua' => 'Nicaragua', 'Niger' => 'Niger', 'Nigeria' => 'Nigeria', 'Norfolk Island' => 'Norfolk Island', 'Northern Mariana Islands' => 'Northern Mariana Islands', 'Norway' => 'Norway', 'Oman' => 'Oman', 'Pakistan' => 'Pakistan', 'Palau' => 'Palau', 'Palestine' => 'Palestine', 'Panama' => 'Panama', 'Papua New Guinea' => 'Papua New Guinea', 'Paraguay' => 'Paraguay', 'Peru' => 'Peru', 'Philippines' => 'Philippines', 'Poland' => 'Poland', 'Portugal' => 'Portugal', 'Puerto Rico' => 'Puerto Rico', 'Qatar' => 'Qatar', 'Reunion' => 'Reunion', 'Romania' => 'Romania', 'Russian Federation' => 'Russian Federation', 'Rwanda' => 'Rwanda', 'Saint Kitts and Nevis' => 'Saint Kitts and Nevis', 'Saint Lucia' => 'Saint Lucia', 'Saint Vincent and the Grenadines' => 'Saint Vincent and the Grenadines', 'Samoa' => 'Samoa', 'San Marino' => 'San Marino', 'Sao Tome and Principe' => 'Sao Tome and Principe', 'Saudi Arabia' => 'Saudi Arabia', 'Senegal' => 'Senegal', 'Seychelles' => 'Seychelles', 'Sierra Leone' => 'Sierra Leone', 'Singapore' => 'Singapore', 'Slovakia' => 'Slovakia', 'Slovenia' => 'Slovenia', 'Solomon Islands' => 'Solomon Islands', 'Somalia' => 'Somalia', 'South Africa' => 'South Africa', 'Spain' => 'Spain', 'Sri Lanka' => 'Sri Lanka', 'Sudan' => 'Sudan', 'Suriname' => 'Suriname', 'Swaziland' => 'Swaziland', 'Sweden' => 'Sweden', 'Switzerland' => 'Switzerland', 'Syrian Arab Republic' => 'Syrian Arab Republic', 'Taiwan' => 'Taiwan', 'Tajikistan' => 'Tajikistan', 'Tanzania' => 'Tanzania', 'Thailand' => 'Thailand', 'Togo' => 'Togo', 'Tokelau' => 'Tokelau', 'Tonga' => 'Tonga', 'Trinidad and Tobago' => 'Trinidad and Tobago', 'Tunisia' => 'Tunisia', 'Turkey' => 'Turkey', 'Turkmenistan' => 'Turkmenistan', 'Turks and Caicos Islands' => 'Turks and Caicos Islands', 'Tuvalu' => 'Tuvalu', 'Uganda' => 'Uganda', 'Ukraine' => 'Ukraine', 'United Arab Emirates' => 'United Arab Emirates', 'United Kingdom' => 'United Kingdom', 'United States of America' => 'United States of America', 'United States Minor Outlying Islands' => 'United States Minor Outlying Islands', 'Uruguay' => 'Uruguay', 'Uzbekistan' => 'Uzbekistan', 'Vanuatu' => 'Vanuatu', 'Venezuela' => 'Venezuela', 'Vietnam' => 'Vietnam', 'Virgin Islands' => 'Virgin Islands', 'Virgin Islands' => 'Virgin Islands', 'Wallis and Futuna' => 'Wallis and Futuna', 'Yemen' => 'Yemen', 'Yugoslavia' => 'Yugoslavia', 'Zambia' => 'Zambia', 'Zimbabwe' => 'Zimbabwe'],
                           'Pakistan', ['placeholder' => 'Select country']) }}
                        {{ Form::bsUrl('website', null) }}
                        {{ Form::bsEmail('email', null, [ 'data-default' => 'Please provide an e-mail address for your agency. This e-mail can be different from your account e-mail.']) }}
                        <button class="btn btn-block save-agency" style="background-color: #274abb; margin-top: 10px; color: white; display: block">SAVE</button>
                        <button class="btn btn-block close-form" style="background-color: #274abb; margin-top: 10px; color: white; display: none" data-dismiss="modal">CLOSE</button>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
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
                $('#delete-image').on('show.bs.modal', function (event) {
                    let record_id = $(event.relatedTarget).data('record-id');
                    $(this).find('.modal-body #image-record-id').val(record_id);
                });
            });
            $('select option:first-child').css('cursor', 'default').prop('disabled', true);

            $("#agent-model").click(function () {
                if ($(this).is(':checked')) {
                    $('#agentModalCenter').modal('show');
                }
            });

            $('#agentModalCenter').on('shown.bs.modal', function () {
                let form = $('#add-agency');
                $.validator.addMethod("regx", function (value, element, regexpr) {
                    return regexpr.test(value);
                }, "Please enter a valid value.");
                //validate an image size in jquery
                // $.validator.addMethod('minImageSize', function (value, element, minSize) {
                //     var imageSize = $(element).data('imageSize');
                //     return (imageSize)
                //         && (imageSize.width === minSize.width)
                //         && (imageSize.height === minSize.height);
                // }, function (minSize, element) {
                //     return ($(element).data('imageSize'))
                //         ? ("Your image's size must equal to "
                //             + minSize.width + "px by " + minSize.height + "px")
                //         : "Selected file is not an image.";
                // });

                form.validate({
                    rules: {
                        'select_cities[]': {
                            required: true,
                        },
                        company_title: {
                            required: true,
                            maxlength: 255
                        },
                        address: {
                            required: true,
                            maxlength: 255
                        },
                        phone: {
                            required: true,
                            regx: /\+92-\d{2}-\d{7}/,
                        },
                        cell: {
                            required: true,
                            regx: /^\+92-3\d{2}-\d{7}$/,
                        },
                        fax: {
                            regx: /\+92-\d{2}-\d{7}/,
                        },
                        description: {
                            maxlength: 4096
                        },
                        zip_code: {
                            digits: true,
                            minlength: 5,
                            maxlength: 5
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        website: {
                            required: true,
                            url: true
                        },
                    },
                    messages: {
                    },
                    errorElement: 'small',
                    errorClass: 'help-block text-red',
                    submitHandler: function (form) {
                        form.preventDefault();
                    },
                    invalidHandler: function (event, validator) {
                        // 'this' refers to the form
                        const errors = validator.numberOfInvalids();
                        if (errors) {
                            let error_tag = $('div.error.text-red');
                            error_tag.hide();
                            const message = errors === 1
                                ? 'You missed 1 field. It has been highlighted'
                                : 'You missed ' + errors + ' fields. They have been highlighted';
                            $('div.error.text-red span').html(message);
                            error_tag.show();
                        } else {
                            $('div.error.text-red').hide();
                        }
                    }
                });

                // let $photoInput = $('#upload_new_logo'),
                //     $imgContainer = $('#imgContainer');
                // $photoInput.change(function () {
                //     $photoInput.removeData('imageSize');
                //     $imgContainer.find('img').removeAttr('src');
                //     $imgContainer.hide().empty();
                //
                //     var file = this.files[0];
                //
                //     if (file.type.match(/image\/.*/)) {
                //         var reader = new FileReader();
                //         reader.onload = function () {
                //             var $img = $('<img />').attr({src: reader.result});
                //
                //             $img.on('load', function () {
                //                 $imgContainer.append($img).show();
                //
                //                 $photoInput.data('imageSize', {
                //                     width: $img.width(),
                //                     height: $img.height()
                //                 });
                //                 $img.css({width: '100px', height: '100px'});
                //             });
                //         }
                //         reader.readAsDataURL(file);
                //     }
                // });

                // form.submit(function () {
                $('.save-agency').click(function (event) {
                    if (form.valid()) {
                        event.preventDefault();
                        jQuery.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        jQuery.ajax({
                            type: 'post',
                            url: '{{ url('/validation') }}',
                            data: $('#add-agency').serialize(),
                            dataType: 'json',
                            success: function (data) {
                                // console.log(data);
                                if (data.success) {
                                    $('.save-agency').hide();
                                    $('.close-form').show();
                                    $('input[name=agency-cities]').val($('#cities').val());
                                    $('input[name=agency-email]').val($('[name=email]').val());
                                    $('input[name=agency-title]').val($('[name=company_title]').val());
                                    $('input[name=agency-description]').val($('[name=description]').val());
                                    $('input[name=agency-phone]').val($('[name=phone]').val());
                                    $('input[name=agency-cell]').val($('[name=cell]').val());
                                    $('input[name=agency-fax]').val($('[name=fax]').val());
                                    $('input[name=agency-address]').val($('[name=address]').val());
                                    $('input[name=agency-zip_code]').val($('[name=zip_code]').val());
                                    $('input[name=agency-country]').val($('[name=country]').val());
                                    $('input[name=agency-website]').val($('[name=website]').val());
                                } else {
                                    $.each(data.errors, function (index, value) {
                                        $("input[name=" + index + "]").parent().append('<small id="' + index + '-error" class="help-block text-red" style="display: block;">' + value + '</small>');
                                    })
                                }
                            },
                            error: function (xhr, status, error) {
                                // console.log(error);
                                // console.log(status);
                                // console.log(xhr['responseJSON']);

                            },
                            complete: function (url, options) {
                            }
                        });
                    }
                })

            });
        })(jQuery);
    </script>
@endsection
