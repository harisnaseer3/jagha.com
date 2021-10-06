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
    <!-- Banner start -->
    <div class="container-fluid">
    @include('website.includes.index-page-banner')
    <!-- Search Section start -->
    @include('website.includes.index-search')

        <!-- Featured properties start -->
    @include('website.includes.property_counter')
    <!-- Featured properties start -->
    @include('website.includes.featured_properties')
    <!-- featured agencies -->
    @include('website.includes.partner')
    <!-- Key agencies -->
    @include('website.includes.featured_agencies')
    <!-- Most popular places start -->
        @include('website.includes.popular_places_listing')
        <div class="clearfix"></div>
        <!-- Blog start -->
        @include('website.includes.recent_blogs')
    </div>
    <!-- Footer start -->
    @include('website.includes.footer')
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
    {{--    script to show images on internet explorer--}}
    {{--    <script defer>--}}
    {{--        let isIE = /*@cc_on!@*/false || !!document.documentMode;--}}
    {{--        if (isIE) {--}}

    {{--            $.getScript("{{asset('website/js/iejs/polyfills.js')}}").done(function (script, textStatus) {--}}
    {{--                $.getScript("{{asset('website/js/iejs/webp.bundle.js')}}").done(function (script, textStatus) {--}}
    {{--                    var webpMachine = new webpHero.WebpMachine();--}}
    {{--                    webpMachine.polyfillDocument();--}}
    {{--                });--}}
    {{--            });--}}
    {{--        }--}}
    {{--    </script>--}}

@endsection
