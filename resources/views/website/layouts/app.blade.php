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

<div class="fixed-bottom p-4">
    <div class="toast bg-success w-100 mw-100 color-white" role="alert" style="display: none">
        <div class="toast-body p-4 d-flex flex-column">
            <h4>Our website uses cookies</h4>
            <p>
{{--                By continuing to browse or by clicking ‘Accept’, you agree to the storing of cookies on your device to enhance your site experience and for analytical purposes.--}}
                This website use cookies, which are necessary for its functioning.
                You can accept the use of cookies by clicking on Accept button or by continuing to browse otherwise.
            </p>
            <div class="ml-auto">
{{--                <button type="button" class="btn btn-outline-light mr-3" id="btnDeny">--}}
{{--                    Deny--}}
{{--                </button>--}}
                <button type="button" class="btn btn-light" id="btnAccept">
                    Accept
                </button>
            </div>
        </div>
    </div>
</div>

@include('website.includes.scripts')
</body>
</html>
