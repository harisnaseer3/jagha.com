@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection

@section('json-ld')
    <?php echo $localBusiness->toScript()  ?>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}">
    <meta name="facebook-domain-verification" content="s0pvft8wezz41p9826lxvw9nfwb8t3" />


@endsection
@section('content')

    @include('website.includes.nav')
    <div class="container-fluid">
        @include('website.pages.investor.includes.index-page-banner')
        @include('website.pages.investor.includes.featured_properties')
        @include('website.pages.investor.includes.featured_design')
{{--        @include('website.pages.investor.includes.carousal')--}}
        @include('website.pages.investor.includes.benefits')
        @include('website.pages.investor.includes.faqs')

    </div>
    <!-- Footer start -->
    @include('website.pages.investor.includes.footer')
    <div class="fly-to-top back-to-top">
        <i class="fa fa-angle-up fa-3"></i>
        <span class="to-top-text">To Top</span>
    </div><!--fly-to-top-->
    <div class="fly-fade">
    </div><!--fly-fade-->
@endsection

@section('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}" defer></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}" defer></script>
    <script src="{{asset('website/js/rangeslider.js')}}" defer></script>
    <script src="{{asset('website/js/popper.min.js')}}" defer></script>
    <script src="{{asset('website/js/index-page.js')}}" defer></script>
    <script src="{{asset('website/js/script-custom.js')}}" defer></script>
@endsection
