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

@section('script')
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId            : '639361382871128',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v8.0'
            });
        };
    </script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v8.0" nonce="sYBlILm7"></script>
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
                $('[data-toggle="tooltip"]').tooltip();
                var paused = false,

                    agency_interval = setInterval(function () {
                        (!paused) && $('#agency-next').trigger('click');
                        $('#middle-agency-name').html($("#agency-slider .slick-center .slick-slide-item .agency-name").text() + ' (' + $("#agency-slider .slick-center .slick-slide-item .agency-city").text() + ')');
                        $('#sale-count').html($("#agency-slider .slick-center .slick-slide-item .sale-count").text() + ' Total Properties');
                        $('#agency-phone').html($("#agency-slider .slick-center .slick-slide-item .agency-phone").text());
                    }, 3000);

                interval = setInterval(function () {
                    (!paused) && $('#featured-agency-next').trigger('click');
                }, 4000);

                $('#agency-slider, .controls').click(function () {
                    $('#middle-agency-name').html($("#agency-slider .slick-center .slick-slide-item .agency-name").text() + ' (' + $("#agency-slider .slick-center .slick-slide-item .agency-city").text() + ')');
                    $('#sale-count').html($("#agency-slider .slick-center .slick-slide-item .sale-count").text() + ' Total Properties');
                });

                $('#featured-agency-slider .slick-slide-item').hover(function (ev) {
                    clearInterval(interval);
                }, function (ev) {
                    interval = setInterval(function () {
                        (!paused) && $('#featured-agency-next').trigger('click');
                    }, 4000);
                });
                $('#agency-slider .slick-slide-item').hover(function (ev) {
                    clearInterval(agency_interval);
                }, function (ev) {
                    agency_interval = setInterval(function () {
                        (!paused) && $('#agency-next').trigger('click');
                        $('#middle-agency-name').html($("#agency-slider .slick-center .slick-slide-item .agency-name").text() + ' (' + $("#agency-slider .slick-center .slick-slide-item .agency-city").text() + ')');
                        $('#sale-count').html($("#agency-slider .slick-center .slick-slide-item .sale-count").text() + ' Total Properties');
                        $('#agency-phone').html($("#agency-slider .slick-center .slick-slide-item .agency-phone").text());
                    }, 3000);

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
                let form = $('#sign-in-card');
                form.validate({
                    rules: {
                        email: {
                            required: true,
                        },
                        password: {
                            required: true,
                        }
                    },
                    messages: {},
                    errorElement: 'small',
                    errorClass: 'help-block text-red',
                    submitHandler: function (form) {
                        event.preventDefault();
                    },
                    invalidHandler: function (event, validator) {
                        // 'this' refers to the form
                        const errors = validator.numberOfInvalids();
                        if (errors) {
                            let error_tag = $('div.error.text-red');
                            error_tag.hide();
                            const message = errors === 1
                                ? 'You missed 1 field. It has been highlighted'
                                : 'You missed ' + errors + ' fields. They have been highlighted';
                            $('div.error.text-red span').html(message);
                            error_tag.show();
                        } else {
                            $('div.error.text-red').hide();

                        }
                    }
                });

                $('#sign-in-btn').click(function (event) {
                    if (form.valid()) {
                        event.preventDefault();
                        jQuery.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        event.preventDefault();
                        jQuery.ajax({
                            type: 'post',
                            url: 'http://127.0.0.1/property/login',
                            data: form.serialize(),
                            dataType: 'json',
                            success: function (data) {
                                console.log(data);
                                if (data.data) {
                                    $('.error-tag').hide();
                                    $('#exampleModalCenter').modal('hide');

                                } else if (data.error) {
                                    $('div.help-block small').html(data.error.password);
                                    $('.error-tag').show();
                                }
                            },
                            error: function (xhr, status, error) {
                                event.preventDefault();

                                console.log(error);
                                console.log(status);
                                console.log(xhr);
                            },
                            complete: function (url, options) {
                            }
                        });
                    }
                });
            });
        })(jQuery);
    </script>
    <script src="{{asset('website/js/popper.min.js')}}"></script>
    <script src="{{asset('website/js/script-custom.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.bundle.min.js')}}"></script>

@endsection
