@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection



@section('json-ld')
    <?php echo $localBusiness->toScript()  ?>
@endsection


@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')

    @include('website.includes.nav')
    <!-- Banner start -->
    <div class="container-fluid">
    @include('website.includes.index-page-banner')
    <!-- Search Section start -->
    @include('website.includes.search2')
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
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="http://malsup.github.io/jquery.cycle2.js"></script>
    <script src="http://malsup.github.io/jquery.cycle2.carousel.js"></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>

    <script>
        $.fn.cycle.defaults.autoSelector = '#agency-slider';
        $.fn.cycle.defaults.autoSelector = '#featured-agency-slider';
    </script>
    <script>
        (function ($) {
            $(document).ready(function () {
                var paused = false,
                    interval = setInterval(function () {
                        (!paused) && $('#agency-next').trigger('click');
                       $('#middle-agency-name').html($("#agency-slider .slick-center .slick-slide-item .agency-name").text()+' ('+ $("#agency-slider .slick-center .slick-slide-item .agency-city").text()+')');
                       $('#sale-count').html($("#agency-slider .slick-center .slick-slide-item .sale-count").text()+ ' Properties For Sale');
                       $('#agency-phone').html($("#agency-slider .slick-center .slick-slide-item .agency-phone").text());
                    },3000);
                    interval = setInterval(function () {
                        (!paused) && $('#featured-agency-next').trigger('click');
                    },4000);
                $('#agency-slider, .controls').click(function ()
                {
                    $('#middle-agency-name').html($("#agency-slider .slick-center .slick-slide-item .agency-name").text()+' ('+ $("#agency-slider .slick-center .slick-slide-item .agency-city").text()+')');
                    $('#sale-count').html($("#agency-slider .slick-center .slick-slide-item .sale-count").text()+ ' Properties For Sale');
                });
                $('#featured-agency-slider .slick-slide-item').hover(function ()
                {
                    
                });


                $('.select2').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === 'en' ? 'ltr' : 'rtl'}}',
                });
                $('.select2bs4').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === 'en' ? 'ltr' : 'rtl'}}',
                    theme: 'bootstrap4',
                });

            });
        })(jQuery);
    </script>
    <script src="{{asset('website/js/popper.min.js')}}"></script>
    <script src="{{asset('website/js/script-custom.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.bundle.min.js')}}"></script>

@endsection
