<!DOCTYPE html>
<html lang="en">
<head>
    @yield('title')
    @yield('json-ld')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    @include('website.includes.styles')
</head>
<body>
<div class="page_loader"></div>

@yield('content')

<div class="fixed-bottom p-2">
    <div class="toast bg-dark w-100 mw-100 color-white" role="alert" style="display: none">
        <div class="toast-body p-2 d-flex flex-column">
            {{--            <h4 class="color-white">Cookies</h4>--}}
            <div class="color-white">
                <span class="mr-auto color-white" style="line-height: 1rem">
                We use cookies for a number of reasons, such as keeping Our Site reliable and secure, providing social media features and to analyse how our Site is used. By clicking on the "Accept" button or by continue to use you consent to the usage these cookies on your device.
                </span>
                <span class="float-right pt-1"><a type="button ml-auto" class="btn btn-light" id="btnAccept">Accept</a></span>
            </div>
            {{--            <div class="ml-auto">--}}
            {{--                <button type="button" class="btn btn-outline-light mr-3" id="btnDeny">--}}
            {{--                    Deny--}}
            {{--                </button>--}}
            {{--                <button type="button" class="btn btn-light" id="btnAccept">--}}
            {{--                    Accept--}}
            {{--                </button>--}}
            {{--            </div>--}}
        </div>
    </div>
</div>

@include('website.includes.scripts')
</body>
</html>
