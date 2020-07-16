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
    <!-- Main header start -->
    @include('website.includes.top_header2')
    <!-- Banner start -->
    @include('website.includes.index-page-banner')
    <!-- Search Section start -->
    @include('website.includes.search2')
    <!-- featured agencies -->
    @include('website.includes.partner')
    <!-- Featured properties start -->
    @include('website.includes.featured_properties')
    <!-- Key agencies -->
    @include('website.includes.featured_agencies')
    <!-- Most popular places start -->
    @include('website.includes.popular_places_listing')
    <div class="clearfix"></div>
    <!-- Blog start -->
    @include('website.includes.recent_blogs')
    <!-- Footer start -->
    @include('website.includes.footer')
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
                    }, 3000);
                $('#agency-slider, .controls').hover(function () {
                    paused = true;
                }, function () {
                    paused = false;
                });
                // $('select option:first-child').css('cursor', 'default').prop('disabled', true);

                $('.select2').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === 'en' ? 'ltr' : 'rtl'}}',
                });
                $('.select2bs4').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === 'en' ? 'ltr' : 'rtl'}}',
                    theme: 'bootstrap4',
                });
                // $.validator.addMethod("regx", function (value, element, regexpr) {
                //     return regexpr.test(value);
                // }, "Invalid value");
                // $('#property-id').validate({
                //     rules: {
                //         property_id: {
                //             required: true,
                //             regx: /^id-2020-\d{3,8}$/i,
                //         },
                //     },
                //     messages: {},
                //     errorElement: 'small',
                //     errorClass: 'help-block text-red',
                //     submitHandler: function (form) {
                //         form.preventDefault();
                //     },
                //     invalidHandler: function (event, validator) {
                //         // 'this' refers to the form
                //         const errors = validator.numberOfInvalids();
                //         if (errors) {
                //             let error_tag = $('div.error.text-red');
                //             error_tag.hide();
                //             const message = errors === 1
                //                 ? 'You missed 1 field. It has been highlighted'
                //                 : 'You missed ' + errors + ' fields. They have been highlighted';
                //             $('div.error.text-red span').html(message);
                //             error_tag.show();
                //         } else {
                //             $('div.error.text-red').hide();
                //         }
                //     }
                // });
            });
        })(jQuery);
    </script>
    <script src="{{asset('website/js/script-custom.js')}}"></script>

@endsection
