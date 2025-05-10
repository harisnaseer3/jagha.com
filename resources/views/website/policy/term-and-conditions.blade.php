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
                        <h2 class="heading-support">Terms and Conditions </h2>
                        <hr class="new2">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <div>
                            <div class="medium-heading">
                                Terms
                            </div>
                            <div class="mb-5 mt-3 paragraph-text">
                                By accessing this Website, accessible from https://www.aboutpakistan.com/, you are agreeing to be bound by these Website Terms and Conditions of Use and agree that you
                                are responsible for the agreement with any applicable local laws. If you disagree with any of these terms, you are prohibited from accessing this site. The materials
                                contained in this Website are protected by copyright and trade mark law.
                            </div>

                            <div class="medium-heading">Use License</div>
                            <div class="mb-5 mt-3 paragraph-text">
                                Permission is granted to temporarily download one copy of the materials on About Pakistan's Website for personal, non-commercial transitory viewing only. This is the
                                grant of a license, not a transfer of title, and under this license you may not:
                                <ul class="mb-5 mt-3 mid-heading style">
                                    <li class="mb-3 ml-4">Modify or copy the materials</li>
                                    <li class="mb-3 ml-4">Use the materials for any commercial purpose or for any public display</li>
                                    <li class="mb-3 ml-4">Attempt to reverse engineer any software contained on About Pakistan's Website</li>
                                    <li class="mb-3 ml-4">Remove any copyright or other proprietary notations from the materials; or
                                        transferring the materials to another person or "mirror" the materials on any other server
                                    </li>
                                    <li class="mb-3 ml-4"> This will let About Pakistan to terminate upon violations of any of these restrictions. Upon termination, your viewing right will also be
                                        terminated and you
                                        should
                                    </li>
                                    <li class="mb-3 ml-4">Destroy any downloaded materials in your possession whether it is printed or electronic format.
                                    </li>
                                </ul>
                            </div>

                            <div class="medium-heading">Disclaimer</div>
                            <div class="mb-5 mt-3 paragraph-text">All the materials on About Pakistan’s Website are provided "as is". About Pakistan makes no warranties, may it be expressed or
                                implied, therefore negates all other warranties. Furthermore, About Pakistan does not make any representations concerning the accuracy or reliability of the use of
                                the materials on its Website or otherwise relating to such materials or any sites linked to this Website.
                            </div>

                            <div class="medium-heading">Limitations</div>
                            <div class="mb-5 mt-3 paragraph-text">
                                About Pakistan or its suppliers will not be hold accountable for any damages that will arise with the use or inability to use the materials on About Pakistan’s Website,
                                even if About Pakistan or an authorize representative of this Website has been notified, orally or written, of the possibility of such damage. Some jurisdiction does
                                not allow limitations on implied warranties or limitations of liability for incidental damages, these limitations may not apply to you.
                            </div>
                            <div class="medium-heading">Revisions and Errata</div>
                            <div class="mb-5 mt-3 paragraph-text">
                                The materials appearing on About Pakistan’s Website may include technical, typographical, or photographic errors. About Pakistan will not promise that any of the
                                materials in this Website are accurate, complete, or current. About Pakistan may change the materials contained on its website at any time without notice. About
                                Pakistan does not make any commitment to update the materials.
                            </div>
                            <div class="medium-heading">Site Terms of Use Modifications</div>
                            <div class="mb-5 mt-3 paragraph-text">
                                About Pakistan may revise these Terms of Use for its Website at any time without prior notice. By using this Website, you are agreeing to be bound by the current
                                version of these Terms and Conditions of Use.
                            </div>
                            <div class="medium-heading">
                                Links
                            </div>
                            <div class="mb-5 mt-3 paragraph-text">About Pakistan has not reviewed all of the sites linked to its website and is not responsible for the contents of any such linked
                                site. The
                                presence of any link does not imply endorsement by About Pakistan of the site. The use of any linked website is at the user’s own risk.
                            </div>
                            <div class="medium-heading">Site Terms of Use Modifications</div>
                            <div class="mb-5 mt-3 paragraph-text">About Pakistan may revise these Terms of Use for its Website at any time without prior notice. By using this Website, you are agreeing
                                to be
                                bound by the current version of these Terms and Conditions of Use.
                            </div>

                            <div class="medium-heading">Your Privacy
                            </div>
                            <div class="mb-5 mt-3 paragraph-text">Please read our Privacy Policy. <a href="{{route('privacy-policy')}}">(Click to Read)</a></div>
                            <div class="medium-heading">Governing Law</div>
                            <div class="mb-5 mt-3 paragraph-text">Any claim related to About Pakistan's Website shall be governed by the laws of Pakistan without regards to its conflict of law
                                provisions.
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
