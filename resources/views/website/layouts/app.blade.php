<!DOCTYPE html>
<html lang="en">
<head>
    @yield('title')
    @yield('json-ld')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-170072080-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-170072080-1');
    </script>

    @include('website.includes.styles')
    <style>

        .field-icon {
            float: right;
            margin-left: -25px;

            position: relative;
            z-index: 2;
            margin-right:8px;
            font-size:1.2rem;

        }
    </style>
</head>
<body>
<div class="page_loader"></div>
<div id="snack-div">
    @if(\Illuminate\Support\Facades\Auth::guard('web')->check() && \Illuminate\Support\Facades\Auth::guard('web')->user()->email_verified_at == null)
        <div id="snackbar">Limited Functionality! <a href="{{route('user.dashboard')}}"><u class="color-white">Verify Email Address</u></a> </div>
    @endif
</div>
    @yield('content')





<div class="fixed-bottom p-2">
    <div class="toast bg-dark w-100 mw-100 color-white" role="alert" style="display: none">
        <div class="toast-body p-2 d-flex flex-column">
            {{--            <h4 class="color-white">Cookies</h4>--}}
            <div class="color-white">
                <span class="mr-auto color-white" style="line-height: 1.5rem">
                We use cookies for a number of reasons, such as keeping our site reliable and secure, providing social media features and analyzing how our site is being used by end user. By selecting "Accept" option or continuing to browse site, you consent to the usage of these cookies on your device.
                </span>
                <span class="float-right pt-2 mt-2"><a type="button ml-auto" class="btn btn-sm theme-blue text-white" id="btnAccept">Accept</a></span>
            </div>
        </div>
    </div>
</div>
@include('website.layouts.min-max-check-modal')
@include('website.includes.scripts')
<script>
    (function ($) {
        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    })(jQuery);
</script>

</body>
</html>
