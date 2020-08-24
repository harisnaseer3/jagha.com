@extends('website.layouts.app')
@section('title')
    <title> Portfolio : Property Management By Property.com</title>
@endsection

@section('css_library')
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
@endsection

@section('content')
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>My Account &amp; Profiles</h1>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class=" mt-3 float-right">
                        <a href="{{route('home')}}">Home Page</a> |
                        <a href="{{route('accounts.logout')}}">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Property start -->
    <div class="submit-property content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('website.includes.tabs')

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
                                    {{ Form::open(['route' => ['agencies.store'], 'method' => 'post', 'role' => 'form', 'enctype' => 'multipart/form-data']) }}
                                    <div class="card">
                                        <div class="card-header bg-success text-white text-uppercase">Agency Profile</div>
                                        <div class="card-body">
                                            {{ Form::bsSelect2('select_cities[]', ['Abbottabad' => 'Abbottabad', 'Abdul Hakim' => 'Abdul Hakim', 'Ahmedpur East' => 'Ahmedpur East', 'Alipur' => 'Alipur', 'Arifwala' => 'Arifwala', 'Astore' => 'Astore', 'Attock' => 'Attock', 'Awaran' => 'Awaran', 'Badin' => 'Badin', 'Bagh' => 'Bagh', 'Bahawalnagar' => 'Bahawalnagar', 'Bahawalpur' => 'Bahawalpur', 'Balakot' => 'Balakot', 'Bannu' => 'Bannu', 'Barnala' => 'Barnala', 'Batkhela' => 'Batkhela', 'Bhakkar' => 'Bhakkar', 'Bhalwal' => 'Bhalwal', 'Bhimber' => 'Bhimber', 'Buner' => 'Buner', 'Burewala' => 'Burewala', 'Chaghi' => 'Chaghi', 'Chakwal' => 'Chakwal', 'Charsadda' => 'Charsadda', 'Chichawatni' => 'Chichawatni', 'Chiniot' => 'Chiniot', 'Chishtian Sharif' => 'Chishtian Sharif', 'Chitral' => 'Chitral', 'Choa Saidan Shah' => 'Choa Saidan Shah', 'Chunian' => 'Chunian', 'Dadu' => 'Dadu', 'Daharki' => 'Daharki', 'Daska' => 'Daska', 'Daur' => 'Daur', 'Depalpur' => 'Depalpur', 'Dera Ghazi Khan' => 'Dera Ghazi Khan', 'Dera Ismail Khan' => 'Dera Ismail Khan', 'Dijkot' => 'Dijkot', 'Dina' => 'Dina', 'Dobian' => 'Dobian', 'Duniya Pur' => 'Duniya Pur', 'Faisalabad' => 'Faisalabad', 'FATA' => 'FATA', 'Fateh Jang' => 'Fateh Jang', 'Gaarho' => 'Gaarho', 'Gadoon' => 'Gadoon', 'Galyat' => 'Galyat', 'Ghakhar' => 'Ghakhar', 'Gharo' => 'Gharo', 'Ghotki' => 'Ghotki', 'Gilgit' => 'Gilgit', 'Gojra' => 'Gojra', 'Gujar Khan' => 'Gujar Khan', 'Gujranwala' => 'Gujranwala', 'Gujrat' => 'Gujrat', 'Gwadar' => 'Gwadar', 'Hafizabad' => 'Hafizabad', 'Hala' => 'Hala', 'Hangu' => 'Hangu', 'Harappa' => 'Harappa', 'Haripur' => 'Haripur', 'Haroonabad' => 'Haroonabad', 'Hasilpur' => 'Hasilpur', 'Hassan Abdal' => 'Hassan Abdal', 'Haveli Lakha' => 'Haveli Lakha', 'Hazro' => 'Hazro', 'Hub Chowki' => 'Hub Chowki', 'Hujra Shah Muqeem' => 'Hujra Shah Muqeem', 'Hunza' => 'Hunza', 'Hyderabad' => 'Hyderabad', 'Islamabad' => 'Islamabad', 'Jacobabad' => 'Jacobabad', 'Jahanian' => 'Jahanian', 'Jalalpur Jattan' => 'Jalalpur Jattan', 'Jampur' => 'Jampur', 'Jamshoro' => 'Jamshoro', 'Jatoi' => 'Jatoi', 'Jauharabad' => 'Jauharabad', 'Jhang' => 'Jhang', 'Jhelum' => 'Jhelum', 'Kaghan' => 'Kaghan', 'Kahror Pakka' => 'Kahror Pakka', 'Kalat' => 'Kalat', 'Kamalia' => 'Kamalia', 'Kamoki' => 'Kamoki', 'Kandiaro' => 'Kandiaro', 'Karachi' => 'Karachi', 'Karak' => 'Karak', 'Kasur' => 'Kasur', 'Khairpur' => 'Khairpur', 'Khanewal' => 'Khanewal', 'Khanpur' => 'Khanpur', 'Kharian' => 'Kharian', 'Khipro' => 'Khipro', 'Khushab' => 'Khushab', 'Khuzdar' => 'Khuzdar', 'Kohat' => 'Kohat', 'Kot Addu' => 'Kot Addu', 'Kotli' => 'Kotli', 'Kotri' => 'Kotri', 'Lahore' => 'Lahore', 'Lakki Marwat' => 'Lakki Marwat', 'Lalamusa' => 'Lalamusa', 'Larkana' => 'Larkana', 'Lasbela' => 'Lasbela', 'Layyah' => 'Layyah', 'Liaquatpur' => 'Liaquatpur', 'Lodhran' => 'Lodhran', 'Loralai' => 'Loralai', 'Lower Dir' => 'Lower Dir', 'Mailsi' => 'Mailsi', 'Makran' => 'Makran', 'Malakand' => 'Malakand', 'Mandi Bahauddin' => 'Mandi Bahauddin', 'Mangla' => 'Mangla', 'Mansehra' => 'Mansehra', 'Mardan' => 'Mardan', 'Matiari' => 'Matiari', 'Matli' => 'Matli', 'Mian Channu' => 'Mian Channu', 'Mianwali' => 'Mianwali', 'Mingora' => 'Mingora', 'Mirpur' => 'Mirpur', 'Mirpur Khas' => 'Mirpur Khas', 'Mirpur Sakro' => 'Mirpur Sakro', 'Mitha Tiwana' => 'Mitha Tiwana', 'Moro' => 'Moro', 'Multan' => 'Multan', 'Muridke' => 'Muridke', 'Murree' => 'Murree', 'Muzaffarabad' => 'Muzaffarabad', 'Muzaffargarh' => 'Muzaffargarh', 'Nankana Sahib' => 'Nankana Sahib', 'Naran' => 'Naran', 'Narowal' => 'Narowal', 'Nasar Ullah Khan Town' => 'Nasar Ullah Khan Town', 'Nasirabad' => 'Nasirabad', 'Naushahro Feroze' => 'Naushahro Feroze', 'Nawabshah' => 'Nawabshah', 'Neelum' => 'Neelum', 'New Mirpur City' => 'New Mirpur City', 'Nowshera' => 'Nowshera', 'Okara' => 'Okara', 'Others' => 'Others', 'Others Azad Kashmir' => 'Others Azad Kashmir', 'Others Balochistan' => 'Others Balochistan', 'Others Gilgit Baltistan' => 'Others Gilgit Baltistan', 'Others Khyber Pakhtunkhwa' => 'Others Khyber Pakhtunkhwa', 'Others Punjab' => 'Others Punjab', 'Others Sindh' => 'Others Sindh', 'Pakpattan' => 'Pakpattan', 'Peshawar' => 'Peshawar', 'Pind Dadan Khan' => 'Pind Dadan Khan', 'Pindi Bhattian' => 'Pindi Bhattian', 'Pir Mahal' => 'Pir Mahal', 'Qazi Ahmed' => 'Qazi Ahmed', 'Quetta' => 'Quetta', 'Rahim Yar Khan' => 'Rahim Yar Khan', 'Rajana' => 'Rajana', 'Rajanpur' => 'Rajanpur', 'Ratwal' => 'Ratwal', 'Rawalkot' => 'Rawalkot', 'Rawalpindi' => 'Rawalpindi', 'Rohri' => 'Rohri', 'Sadiqabad' => 'Sadiqabad', 'Sahiwal' => 'Sahiwal', 'Sakrand' => 'Sakrand', 'Samundri' => 'Samundri', 'Sanghar' => 'Sanghar', 'Sarai Alamgir' => 'Sarai Alamgir', 'Sargodha' => 'Sargodha', 'Sehwan' => 'Sehwan', 'Shabqadar' => 'Shabqadar', 'Shahdadpur' => 'Shahdadpur', 'Shahkot' => 'Shahkot', 'Shahpur Chakar' => 'Shahpur Chakar', 'Shakargarh' => 'Shakargarh', 'Shehr Sultan' => 'Shehr Sultan', 'Sheikhupura' => 'Sheikhupura', 'Sher Garh' => 'Sher Garh', 'Shikarpur' => 'Shikarpur', 'Shorkot' => 'Shorkot', 'Sialkot' => 'Sialkot', 'Sibi' => 'Sibi', 'Skardu' => 'Skardu', 'Sudhnoti' => 'Sudhnoti', 'Sujawal' => 'Sujawal', 'Sukkur' => 'Sukkur', 'Swabi' => 'Swabi', 'Swat' => 'Swat', 'Talagang' => 'Talagang', 'Tando Adam' => 'Tando Adam', 'Tando Allahyar' => 'Tando Allahyar', 'Tando Bago' => 'Tando Bago', 'Tando Muhammad Khan' => 'Tando Muhammad Khan', 'Taxila' => 'Taxila', 'Tharparkar' => 'Tharparkar', 'Thatta' => 'Thatta', 'Toba Tek Singh' => 'Toba Tek Singh', 'Turbat' => 'Turbat', 'Vehari' => 'Vehari', 'Wah' => 'Wah', 'Wazirabad' => 'Wazirabad', 'Waziristan' => 'Waziristan', 'Yazman' => 'Yazman', 'Zhob' => 'Zhob'],
                                                isset($agency->city)? json_decode($agency->city):null, ['required' => true, 'multiple' => 'multiple', 'data-default' => 'Select one or more cities you deal in.']) }}
                                            {{ Form::bsText('company_title', isset($agency->title)? $agency->title : null, ['required' => true, 'data-default' => 'Please provide the official and registered name of your agency.']) }}
                                            {{ Form::bsTextArea('description', isset($agency->description)? $agency->description : null, ['required' => true, 'data-default' => 'Please provided detailed information about your agency services. For example, does your company provide sales and rental services or both.']) }}
                                            {{ Form::bsTel('phone', isset($agency->phone)? $agency->phone : null, ['required' => true, 'data-default' => 'E.g. +92-51-1234567']) }}
                                            {{ Form::bsTel('cell', isset($agency->cell)? $agency->cell : null, ['data-default' => 'E.g. +92-300-1234567']) }}
                                            {{ Form::bsTel('fax', isset($agency->fax)? $agency->fax : null, ['data-default' => 'E.g. +92-21-1234567']) }}
                                            {{ Form::bsText('address', isset($agency->address)? $agency->address : null, ['required' => true]) }}
                                            {{ Form::bsText('zip_code', isset($agency->zip_code)? $agency->zip_code : null) }}
                                            {{ Form::bsSelect2('country', ['Afghanistan' => 'Afghanistan', 'Albania' => 'Albania', 'Algeria' => 'Algeria', 'American Samoa' => 'American Samoa', 'Andorra' => 'Andorra', 'Angola' => 'Angola', 'Anguilla' => 'Anguilla', 'Antarctica' => 'Antarctica', 'Antigua and Barbuda' => 'Antigua and Barbuda', 'Argentina' => 'Argentina', 'Armenia' => 'Armenia', 'Aruba' => 'Aruba', 'Australia' => 'Australia', 'Austria' => 'Austria', 'Azerbaijan' => 'Azerbaijan', 'Bahamas' => 'Bahamas', 'Bahrain' => 'Bahrain', 'Bangladesh' => 'Bangladesh', 'Barbados' => 'Barbados', 'Belarus' => 'Belarus', 'Belgium' => 'Belgium', 'Belize' => 'Belize', 'Benin' => 'Benin', 'Bermuda' => 'Bermuda', 'Bhutan' => 'Bhutan', 'Bolivia' => 'Bolivia', 'Bosnia and Herzegoviegovina' => 'Bosnia and Herzegoviegovina', 'Botswana' => 'Botswana', 'Bouvet Island' => 'Bouvet Island', 'Brazil' => 'Brazil', 'British Indian Ocean Territory' => 'British Indian Ocean Territory', 'Brunei Darussalam' => 'Brunei Darussalam', 'Bulgaria' => 'Bulgaria', 'Burkina Faso' => 'Burkina Faso', 'Burundi' => 'Burundi', 'Cambodia' => 'Cambodia', 'Cameroon' => 'Cameroon', 'Canada' => 'Canada', 'Cape Verde' => 'Cape Verde', 'Cayman Islands' => 'Cayman Islands', 'Central African Republic' => 'Central African Republic', 'Chad' => 'Chad', 'Chile' => 'Chile', 'China' => 'China', 'Colombia' => 'Colombia', 'Comoros' => 'Comoros', 'Congo' => 'Congo', 'Cook Islands' => 'Cook Islands', 'Costa Rica' => 'Costa Rica', 'Cote D Ivoire' => 'Cote D Ivoire', 'Croatia' => 'Croatia', 'Cuba' => 'Cuba', 'Cyprus' => 'Cyprus', 'Czech Republic' => 'Czech Republic', 'Denmark' => 'Denmark', 'Djibouti' => 'Djibouti', 'Dominica' => 'Dominica', 'Dominican Republic' => 'Dominican Republic', 'Ecuador' => 'Ecuador', 'Egypt' => 'Egypt', 'El Salvador' => 'El Salvador', 'Equatorial Guinea' => 'Equatorial Guinea', 'Eritrea' => 'Eritrea', 'Estonia' => 'Estonia', 'Ethiopia' => 'Ethiopia', 'Falkland Islands (Malvinas)' => 'Falkland Islands (Malvinas)', 'Faroe Islands' => 'Faroe Islands', 'Fiji' => 'Fiji', 'Finland' => 'Finland', 'France' => 'France', 'French Guiana' => 'French Guiana', 'French Polynesia' => 'French Polynesia', 'French Southern Terri Territories' => 'French Southern Terri Territories', 'Gabon' => 'Gabon', 'Gambia' => 'Gambia', 'Georgia' => 'Georgia', 'Germany' => 'Germany', 'Ghana' => 'Ghana', 'Gibraltar' => 'Gibraltar', 'Greece' => 'Greece', 'Greenland' => 'Greenland', 'Grenada' => 'Grenada', 'Guadeloupe' => 'Guadeloupe', 'Guam' => 'Guam', 'Guatemala' => 'Guatemala', 'Guinea' => 'Guinea', 'Guinea-Bissau' => 'Guinea-Bissau', 'Guyana' => 'Guyana', 'Haiti' => 'Haiti', 'Heard Island and McDonald Islands' => 'Heard Island and McDonald Islands', 'Holy See (Vatican City State)' => 'Holy See (Vatican City State)', 'Honduras' => 'Honduras', 'Hong Kong' => 'Hong Kong', 'Hungary' => 'Hungary', 'Iceland' => 'Iceland', 'India' => 'India', 'Indonesia' => 'Indonesia', 'Iran' => 'Iran', 'Iraq' => 'Iraq', 'Ireland' => 'Ireland', 'Italy' => 'Italy', 'Jamaica' => 'Jamaica', 'Japan' => 'Japan', 'Jordan' => 'Jordan', 'Kazakhstan' => 'Kazakhstan', 'Kenya' => 'Kenya', 'Kiribati' => 'Kiribati', 'Korea' => 'Korea', 'Kuwait' => 'Kuwait', 'Kyrgyzstan' => 'Kyrgyzstan', 'Latvia' => 'Latvia', 'Lebanon' => 'Lebanon', 'Lesotho' => 'Lesotho', 'Liberia' => 'Liberia', 'Libyan Arab Jamahiriya' => 'Libyan Arab Jamahiriya', 'Liechtenstein' => 'Liechtenstein', 'Lithuania' => 'Lithuania', 'Luxembourg' => 'Luxembourg', 'Macau' => 'Macau', 'Macedonia' => 'Macedonia', 'Madagascar' => 'Madagascar', 'Malawi' => 'Malawi', 'Malaysia' => 'Malaysia', 'Maldives' => 'Maldives', 'Mali' => 'Mali', 'Malta' => 'Malta', 'Marshall Islands' => 'Marshall Islands', 'Martinique' => 'Martinique', 'Mauritania' => 'Mauritania', 'Mauritius' => 'Mauritius', 'Mayotte' => 'Mayotte', 'Mexico' => 'Mexico', 'Micronesia' => 'Micronesia', 'Moldova' => 'Moldova', 'Monaco' => 'Monaco', 'Mongolia' => 'Mongolia', 'Montserrat' => 'Montserrat', 'Morocco' => 'Morocco', 'Mozambique' => 'Mozambique', 'Myanmar' => 'Myanmar', 'Namibia' => 'Namibia', 'Nauru' => 'Nauru', 'Nepal' => 'Nepal', 'Netherlands' => 'Netherlands', 'Netherlands Antilles' => 'Netherlands Antilles', 'New Caledonia' => 'New Caledonia', 'New Zealand' => 'New Zealand', 'Nicaragua' => 'Nicaragua', 'Niger' => 'Niger', 'Nigeria' => 'Nigeria', 'Norfolk Island' => 'Norfolk Island', 'Northern Mariana Islands' => 'Northern Mariana Islands', 'Norway' => 'Norway', 'Oman' => 'Oman', 'Pakistan' => 'Pakistan', 'Palau' => 'Palau', 'Palestine' => 'Palestine', 'Panama' => 'Panama', 'Papua New Guinea' => 'Papua New Guinea', 'Paraguay' => 'Paraguay', 'Peru' => 'Peru', 'Philippines' => 'Philippines', 'Poland' => 'Poland', 'Portugal' => 'Portugal', 'Puerto Rico' => 'Puerto Rico', 'Qatar' => 'Qatar', 'Reunion' => 'Reunion', 'Romania' => 'Romania', 'Russian Federation' => 'Russian Federation', 'Rwanda' => 'Rwanda', 'Saint Kitts and Nevis' => 'Saint Kitts and Nevis', 'Saint Lucia' => 'Saint Lucia', 'Saint Vincent and the Grenadines' => 'Saint Vincent and the Grenadines', 'Samoa' => 'Samoa', 'San Marino' => 'San Marino', 'Sao Tome and Principe' => 'Sao Tome and Principe', 'Saudi Arabia' => 'Saudi Arabia', 'Senegal' => 'Senegal', 'Seychelles' => 'Seychelles', 'Sierra Leone' => 'Sierra Leone', 'Singapore' => 'Singapore', 'Slovakia' => 'Slovakia', 'Slovenia' => 'Slovenia', 'Solomon Islands' => 'Solomon Islands', 'Somalia' => 'Somalia', 'South Africa' => 'South Africa', 'Spain' => 'Spain', 'Sri Lanka' => 'Sri Lanka', 'Sudan' => 'Sudan', 'Suriname' => 'Suriname', 'Swaziland' => 'Swaziland', 'Sweden' => 'Sweden', 'Switzerland' => 'Switzerland', 'Syrian Arab Republic' => 'Syrian Arab Republic', 'Taiwan' => 'Taiwan', 'Tajikistan' => 'Tajikistan', 'Tanzania' => 'Tanzania', 'Thailand' => 'Thailand', 'Togo' => 'Togo', 'Tokelau' => 'Tokelau', 'Tonga' => 'Tonga', 'Trinidad and Tobago' => 'Trinidad and Tobago', 'Tunisia' => 'Tunisia', 'Turkey' => 'Turkey', 'Turkmenistan' => 'Turkmenistan', 'Turks and Caicos Islands' => 'Turks and Caicos Islands', 'Tuvalu' => 'Tuvalu', 'Uganda' => 'Uganda', 'Ukraine' => 'Ukraine', 'United Arab Emirates' => 'United Arab Emirates', 'United Kingdom' => 'United Kingdom', 'United States of America' => 'United States of America', 'United States Minor Outlying Islands' => 'United States Minor Outlying Islands', 'Uruguay' => 'Uruguay', 'Uzbekistan' => 'Uzbekistan', 'Vanuatu' => 'Vanuatu', 'Venezuela' => 'Venezuela', 'Vietnam' => 'Vietnam', 'Virgin Islands' => 'Virgin Islands', 'Virgin Islands' => 'Virgin Islands', 'Wallis and Futuna' => 'Wallis and Futuna', 'Yemen' => 'Yemen', 'Yugoslavia' => 'Yugoslavia', 'Zambia' => 'Zambia', 'Zimbabwe' => 'Zimbabwe'],
                                               isset($agency->country)? ucwords($agency->country): 'Pakistan', ['required' => true, 'placeholder' => 'Select country']) }}
                                            {{ Form::bsEmail('email', \Illuminate\Support\Facades\Auth::user()->email, ['required' => true, 'data-default' => 'Please provide an e-mail address for your agency. This e-mail can be different from your account e-mail.']) }}
                                            {{ Form::bsUrl('website', isset($agency->website)? $agency->website : null, ['required' => true]) }}
                                            @if(Auth::user()->hasRole('Admin'))
                                                {{ Form::bsSelect2('status', ['verified' => 'Verified', 'pending' => 'pending', 'expired' => 'Expired', 'deleted'=>'Deleted', 'rejected'=> 'Rejected'],
                                                   isset($agency->status) ? strtolower($agency->status) : null, ['required' => true, 'placeholder' => 'Select Status']) }}
                                            @endif
                                            <div class="form-group row">
                                                <div class="col-sm-4 col-md-2 col-form-label col-form-label-sm">Company Logo</div>
                                                <div class="col-sm-8 col-md-5">

                                                    <img class="img-fluid img-thumbnail w-50" src="{{isset($agency->logo)?asset('storage/agency_logos/'.$agency->logo):''}}"
                                                         onerror="this.src='{{asset('img/default_company.jpg')}}'" alt="image"/>
                                                </div>
                                            </div>
                                            {{ Form::bsFile('upload_new_logo', null, ['required' => false, 'class' => 'img-fluid img-thumbnail w-50', 'data-default' => 'Image dimension: 256x256, File size: 128 KB']) }}
                                        </div>

                                        <div class="card-header bg-success text-white text-uppercase">CEO / Owner Profile</div>
                                        <div class="card-body">
                                            {{ Form::bsText('name', isset($agency->ceo_name)?$agency->ceo_name:null) }}
                                            {{ Form::bsText('designation', isset($agency->ceo_designation)?$agency->ceo_designation:null) }}
                                            {{ Form::bsText('message', isset($agency->ceo_message)?$agency->ceo_message:null) }}

                                            <div class="form-group row">
                                                <div class="col-sm-4 col-md-2 col-form-label col-form-label-sm">Picture</div>
                                                <div class="col-sm-8 col-md-5">
                                                    <img class="img-fluid img-thumbnail w-25" src="{{isset($agency->ceo_image)?asset('storage/agency_ceo_images/'.$agency->ceo_image):''}}"
                                                         onerror="this.src='{{asset('img/default_user.jpg')}}'" alt="image"/>
                                                </div>
                                            </div>

                                            {{ Form::bsFile('upload_new_picture', null, ['required' => false, 'class' => 'img-fluid img-thumbnail w-50', 'data-default' => 'Image dimension: 256x256, File size: 128 KB']) }}
                                            {{ Form::bsCheckbox(null, null, ['list'=> [(object) ['id' => 0, 'name' => 'Update details in all property listings']]]) }}
                                        </div>

                                        <div class="card-footer">
                                            {{ Form::submit('Store', ['class' => 'btn btn-primary btn-sm search-submit-btn']) }}
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
                        <div class="tab-pane fade" id="clients_leads" rolwe="tabpanel" aria-labelledby="clients_leads-tab">
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
                $('#delete-image').on('show.bs.modal', function (event) {
                    let record_id = $(event.relatedTarget).data('record-id');
                    $(this).find('.modal-body #image-record-id').val(record_id);
                });
            });
        })(jQuery);
    </script>
@endsection
