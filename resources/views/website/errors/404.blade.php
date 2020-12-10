@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection

{{--@section('json-ld')--}}
{{--    <?php echo $localBusiness->toScript()  ?>--}}
{{--@endsection--}}

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}">
@endsection
@section('content')
    <div class="pages-404-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="pages-404-inner">
                        <h1>Oops... Page Not Found !</h1>
                        <p class="lead">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
                        <a href="{{route('home')}}" class="border-thn">Go to Home Page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
