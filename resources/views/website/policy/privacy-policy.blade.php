@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>Jagha - Buy Sell Rent Homes & Properties In Pakistan by https://www.jagha.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" href="{{asset('plugins/intl-tel-input/css/intlTelInput.min.css')}}" async defer>
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <style type="text/css" id="custom-background-css">
        body.custom-background {
            background-color: #eeeeee;
        }

        .card {
            background-color: white;
            margin: 5%;
            padding: 5%;
        }

        .heading-support {
            font-weight: 500;
            font-size: xx-large;
            color: black;
            text-align: center;

        }

        .mid-heading {
            color: black;
            font-stretch: expanded;
            font-size: 18px;
            line-height: 1.5rem;

        }

        hr.new2 {
            border-top: 2px dashed #999999;
        }

        hr.new1 {
            border-top: 2px solid #999999;
        }

        .padding-left {
            padding-left: 15%;
        }

        .contact-info {
            color: black;
            font-size: 15px;

        }

        .color-white {
            color: black;
        }

        .padding-right {
            padding-right: 15%;;
        }

        .padding-top {
            padding-top: 10%;
        }

        hr {
            clear: both;
            display: block
        }

        .divider {
            display: inline-block;
            border-bottom: #999999 1px solid;
            width: 100%;
        }

        .container-fluid {
            padding: 0% !important;
        }

        .media-hover .fa-2x:hover {
            color: black;
        }

        .div-center {
            display: flex;
            justify-content: center;
        }

        .media-padding {
            padding: 0% !important;
        }

        .fa-2x {
            color: #999;
            font-size: 17px;
        }

        .mt-support {
            margin-top: 40px;
        }

        .medium-heading {
            font-weight: bold;
            font-size: large;
            color: black;
        }

        .paragraph-text {
            color: black;
            font-stretch: expanded;
            font-size: 18px;
            line-height: 1.5rem;
            /*padding-left: 6%;*/
        }

        ul.style {
            list-style-type: square;
        }

        .contact-us-tag:hover {
            background-color: #ffffff;
            color: grey;
        }

    </style>
@endsection

@section('content')
    @include('website.includes.nav')

    <!-- Submit Property start -->
    <div class="submit-property mt-support">
        <div class="mt-5">
            <div class="card">
                <div class="row">
                    <div class="col-md-12 col-sm-12 mb-5">
                        <h2 class="heading-support">Privacy Policy</h2>
                        <hr class="new2">

                        {{--                        <p class="mid-heading">We'd <i class="fa fa-heart-o color-white"></i> to help!</p>--}}

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <div class="mb-5 mid-heading">
                            Your privacy is important to us. It is About Pakistan Properties policy to respect your privacy and comply with any applicable law and regulation regarding any personal
                            information
                            we may collect about you, including across our website, https://www.aboutpakistan.com/, and other sites we own and operate.
                        </div>
                        <div>
                            <div class="medium-heading">
                                Information We Collect
                            </div>
                            <div class="mb-5 mt-3 paragraph-text">
                                Information we collect includes both information you knowingly and actively provide us when using or participating in any of our services and promotions, and any
                                information automatically sent by your devices in the course of accessing our products and services.
                            </div>
                            <div>
                                <div class="medium-heading">Log Data</div>
                                <div class="mb-5 mt-3 paragraph-text">
                                    When you visit our website, our servers may automatically log the standard data provided by your web browser. It may include your device’s Internet Protocol (IP)
                                    address, your browser type and version, the pages you visit, the time and date of your visit, the time spent on each page, other details about your visit, and
                                    technical details that occur in conjunction with any errors you may encounter.<br><br>
                                    Please be aware that while this information may not be personally identifying by itself, it may be possible to combine it with other data to personally identify
                                    individual persons.
                                </div>
                            </div>
                            <div>
                                <div class="medium-heading">Personal Information</div>
                                <div class="mb-5 mt-3 paragraph-text">
                                    We may ask for personal information which may include one or more of the following:
                                    <ul class="mb-5 mt-3 mid-heading style">
                                        <li class="mb-3 ml-4">Name</li>
                                        <li class="mb-3 ml-4">Email</li>
                                        <li class="mb-3 ml-4">Social media profiles</li>
                                        <li class="mb-3 ml-4">Phone/mobile number</li>
                                    </ul>


                                </div>
                            </div>
                            <div>
                                <div class="medium-heading">Legitimate Reasons for Processing Your Personal Information</div>
                                <div class="mb-5 mt-3 paragraph-text">We only collect and use your personal information when we have a legitimate reason for doing so. In which instance, we only
                                    collect personal information that is reasonably necessary to provide our services to you.
                                </div>
                            </div>
                            <div>
                                <div class="medium-heading">Collection and Use of Information</div>
                                <div class="mb-5 mt-3 paragraph-text">
                                    We may collect personal information from you when you do any of the following on our website:
                                    <ul class="mb-4 mt-3 mid-heading style">
                                        <li class="mb-3 ml-4">Name</li>
                                        <li class="mb-3 ml-4"> Enter any of our competitions, contests, sweepstakes, and surveys</li>
                                        <li class="mb-3 ml-4"> Sign up to receive updates from us via email or social media channels</li>
                                        <li class="mb-3 ml-4"> Use a mobile device or web browser to access our content</li>
                                        <li class="mb-3 ml-4"> Contact us via email, social media, or on any similar technologies</li>
                                        <li class="mb-3 ml-4"> When you mention us on social media</li>
                                    </ul>
                                    We may collect, hold, use, and disclose information for the following purposes, and personal information will not be further processed in a manner that is
                                    incompatible with these purposes:
                                    <ul class="mb-4 mt-3 mid-heading style">
                                        <li class="mb-3 ml-4"> to enable you to customise or personalise your experience of our website</li>
                                        <li class="mb-3 ml-4"> to contact and communicate with you</li>
                                        <li class="mb-3 ml-4"> for analytics, market research, and business development, including to operate and improve our website, associated applications, and
                                            associated social media platforms
                                        </li>
                                        <li class="mb-3 ml-4"> for advertising and marketing, including to send you promotional information about our products and services and information about third
                                            parties that we consider may be of interest to you
                                        </li>
                                        <li class="mb-3 ml-4"> to enable you to access and use our website, associated applications, and associated social media platforms</li>
                                        <li class="mb-3 ml-4"> for internal record keeping and administrative purposes</li>
                                        <li class="mb-3 ml-4"> to run competitions, sweepstakes, and/or offer additional benefits to you</li>
                                        <li class="mb-3 ml-4"> to comply with our legal obligations and resolve any disputes that we may have</li>
                                        <li class="mb-3 ml-4"> for security and fraud prevention, and to ensure that our sites and apps are safe, secure, and used in line with our terms of use</li>
                                    </ul>
                                    Please be aware that we may combine information we collect about you with general information or research data we receive from other trusted sources.
                                </div>
                            </div>
                            <div>
                                <div class="medium-heading">Security of Your Personal Information</div>
                                <div class="mb-5 mt-3 paragraph-text">
                                    When we collect and process personal information, and while we retain this information, we will protect it within commercially acceptable means to prevent loss and
                                    theft, as well as unauthorized access, disclosure, copying, use, or modification.<br><br>
                                    Although we will do our best to protect the personal information you provide to us, we advise that no method of electronic transmission or storage is 100% secure,
                                    and no one can guarantee absolute data security. We will comply with laws applicable to us in respect of any data breach.<br><br>
                                    You are responsible for selecting any password and its overall security strength, ensuring the security of your own information within the bounds of our services.

                                </div>
                            </div>
                            <div>
                                <div class="medium-heading">How Long We Keep Your Personal Information</div>
                                <div class="mb-5 mt-3 paragraph-text">We keep your personal information only for as long as we need to. This time period may depend on what we are using your
                                    information for, in accordance with this privacy policy. If your personal information is no longer required, we will delete it or make it anonymous by removing all
                                    details that identify you.<br><br>
                                    However, if necessary, we may retain your personal information for our compliance with a legal, accounting, or reporting obligation or for archiving purposes in the
                                    public interest, scientific, or historical research purposes or statistical purposes.

                                </div>
                            </div>
                            <div>
                                <div class="medium-heading">Disclosure of Personal Information to Third Parties</div>
                                <div class="mb-5 mt-3 paragraph-text">
                                    We may disclose personal information to:
                                    <ul class="mb-5 mt-3 mid-heading style">
                                        <li class="mb-4 ml-4"> a parent, subsidiary, or affiliate of our company</li>
                                        <li class="mb-4 ml-4"> third party service providers for the purpose of enabling them to provide their services, for example, IT service providers, data
                                            storage, hosting and server providers, advertisers, or analytics platforms
                                        </li>
                                        <li class="mb-4 ml-4"> our employees, contractors, and/or related entities</li>
                                        <li class="mb-4 ml-4"> our existing or potential agents or business partners</li>
                                        <li class="mb-4 ml-4"> sponsors or promoters of any competition, sweepstakes, or promotion we run</li>
                                        <li class="mb-4 ml-4"> courts, tribunals, regulatory authorities, and law enforcement officers, as required by law, in connection with any actual or prospective
                                            legal proceedings, or in order to establish, exercise, or defend our legal rights
                                        </li>
                                        <li class="mb-4 ml-4"> third parties, including agents or sub-contractors, who assist us in providing information, products, services, or direct marketing to
                                            you third parties to collect and process data
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div>
                                <div class="medium-heading">International Transfers of Personal Information</div>
                                <div class="mb-5 mt-3 paragraph-text">
                                    The personal information we collect is stored and/or processed where we or our partners, affiliates, and third-party providers maintain facilities. Please be aware
                                    that the locations to which we store, process, or transfer your personal information may not have the same data protection laws as the country in which you
                                    initially provided the information. If we transfer your personal information to third parties in other countries: (i) we will perform those transfers in accordance
                                    with the requirements of applicable law; and (ii) we will protect the transferred personal information in accordance with this privacy policy.
                                </div>
                            </div>


                            <div>
                                <div class="medium-heading">Your Rights and Controlling Your Personal Information</div>
                                <div class="mb-5 mt-3 paragraph-text">
                                    You always retain the right to withhold personal information from us, with the understanding that your experience of our website may be affected. We will not
                                    discriminate against you for exercising any of your rights over your personal information. If you do provide us with personal information you understand that we
                                    will collect, hold, use and disclose it in accordance with this privacy policy. You retain the right to request details of any personal information we hold about
                                    you.<br><br>

                                    If we receive personal information about you from a third party, we will protect it as set out in this privacy policy. If you are a third party providing personal
                                    information about somebody else, you represent and warrant that you have such person’s consent to provide the personal information to us.<br><br>
                                    If you have previously agreed to us using your personal information for direct marketing purposes, you may change your mind at any time. We will provide you with
                                    the ability to unsubscribe from our email-database or opt out of communications. Please be aware we may need to request specific information from you to help us
                                    confirm your identity.<br><br>
                                    If you believe that any information we hold about you is inaccurate, out of date, incomplete, irrelevant, or misleading, please contact us using the details
                                    provided in this privacy policy. We will take reasonable steps to correct any information found to be inaccurate, incomplete, misleading, or out of date.<br><br>
                                    If you believe that we have breached a relevant data protection law and wish to make a complaint, please contact us using the details below and provide us with full
                                    details of the alleged breach. We will promptly investigate your complaint and respond to you, in writing, setting out the outcome of our investigation and the
                                    steps we will take to deal with your complaint. You also have the right to contact a regulatory body or data protection authority in relation to your complaint.
                                </div>
                            </div>
                            <div>
                                <div class="medium-heading">Use of Cookies</div>
                                <div class="mb-5 mt-3 paragraph-text">We use “cookies” to collect information about you and your activity across our site. A cookie is a small piece of data that our
                                    website stores on your computer, and accesses each time you visit, so we can understand how you use our site. This helps us serve you content based on preferences
                                    you have specified.
                                </div>
                            </div>
                            <div>
                                <div class="medium-heading">Limits of Our Policy</div>
                                <div class="mb-5 mt-3 paragraph-text">Our website may link to external sites that are not operated by us. Please be aware that we have no control over the content and
                                    policies of those sites, and cannot accept responsibility or liability for their respective privacy practices.
                                </div>
                            </div>
                            <div>
                                <div class="medium-heading">Changes to This Policy</div>
                                <div class="mb-5 mt-3 paragraph-text">At our discretion, we may change our privacy policy to reflect updates to our business processes, current acceptable practices, or
                                    legislative or regulatory changes. If we decide to change this privacy policy, we will post the changes here at the same link by which you are accessing this
                                    privacy policy.<br><br>
                                    If required by law, we will get your permission or give you the opportunity to opt in to or opt out of, as applicable, any new uses of your personal information.
                                </div>
                            </div>
                            <div>
                                <div class="medium-heading">Contact Us</div>
                                <div class="mb-5 mt-3 paragraph-text">For any questions or concerns regarding your privacy, you may contact us using the following details:
                                    <br><br>
                                    <a class="contact-us-tag" href="https://www.aboutpakistan.com/contact-us.php" style="color: #01411c;">Contact Us</a>
                                </div>
                            </div>
                            {{--                            <div>--}}
                            {{--                                <div class="medium-heading"></div>--}}
                            {{--                                <div class="mb-5 mt-3 paragraph-text"></div>--}}
                            {{--                            </div>--}}


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Footer start -->
    @include('website.includes.footer')
@endsection
