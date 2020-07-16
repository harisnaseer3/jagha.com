@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block" style="background: forestgreen">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong style="color: white">{{ $message }}</strong>
    </div>
@endif


@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block text-white" style="background: red">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-block" style="background: lightgoldenrodyellow">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($message = Session::get('info'))
    <div class="alert alert-info alert-block" style="background: skyblue">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif


{{--@if ($errors->any())--}}
{{--    <div class="alert alert-danger" style="background: red">--}}
{{--        <button type="button" class="close" data-dismiss="alert">×</button>--}}
{{--        Please check the form below for errors--}}
{{--    </div>--}}
{{--@endif--}}
