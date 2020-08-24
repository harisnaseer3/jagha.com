@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection


@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')

    @include('website.includes.nav')

    <!-- Properties section body start -->
    <div class="properties-section content-area pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12 pb-3">
                    <!-- Listing -->
                    <div class="card">
                        <div class="card-header">
                            <h1 class="all-cities-header">
                                {{ucwords($type)}} for Sale in All Cities of Pakistan</h1>
                        </div>
                        <div class="card-body">
                        @if($properties)
                                <div class="row">
                                    @foreach($properties as  $property)
                                        <div class="col-sm-3 my-2">
                                            <a href="{{route('sale.property.search', ['sub_type' => lcfirst($property->property_type),
                                                                                      'city' => lcfirst($property->city_name) ,
                                                                                      'purpose'=>lcfirst($property->property_purpose), 'sort'=>'newest','limit'=>15])}}"
                                               title="{{$property->property_type}}  in {{$property->city_name}}"
                                               class="breadcrumb-link">
                                                {{$property->city_name}} ({{$property->property_count}})
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="sidebar-right mt-0">
                        <div class="sidebar widget" aria-label="Subscription form">
                            <h3 class="sidebar-title">Subscribe</h3>
                            <div class="s-border"></div>
                            <div class="m-border"></div>
                            <div class="Subscribe-box">
                                <h2 class="font-size-14 color-555" style="font-weight: 400">Be the first to hear about new properties</h2>
                                <form id="subscribe-form">
                                    <div class="mb-3">
                                        <input id="subscribe" type="email" class="form-contact" name="email" placeholder="example@example.com"
                                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="submit" name="submitNewsletter" class="btn btn-block button-theme" value="Subscribe">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    <script>
        (function ($) {
            $(document).ready(function () {


                $('.record-limit').on('change', function (e) {
                    insertParam('limit', $(this).val());
                });

                if ($('.pagination-box').length > 0) {
                    let current_search_params = window.location.search.split('&page')[0];
                    $('.page-item').each(function () {
                        let link = $(this).find('a');
                        if (link.length > 0) {
                            let fetched_link = link.attr('href');
                            let piece1 = fetched_link.split('?')[0];
                            let piece2 = fetched_link.split('?')[1];
                            link.attr('href', piece1 + current_search_params + '&' + piece2);
                        }
                    });
                }
                setInterval(function () {
                    var docHeight = $(window).height();
                    var footerHeight = $('#foot-wrap').height();
                    var footerTop = $('#foot-wrap').position().top + footerHeight;
                    var marginTop = (docHeight - footerTop);

                    if (footerTop < docHeight)
                        $('#foot-wrap').css('margin-top', marginTop + 'px'); // padding of 30 on footer
                    else
                        $('#foot-wrap').css('margin-top', '0px');
                }, 250);

                $('#subscribe-form').on('submit', function (e) {
                    e.preventDefault();
                    // console.log($('#subscribe').val());
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        type: 'post',
                        url: window.location.origin + '/property' + '/subscribe',
                        data: {
                            email: $('#subscribe').val()
                        },
                        dataType: 'json',
                        success: function (data) {
                            if (data.status === 200) {
                                let btn = '<button class="btn btn-block btn-success"><i class="far fa-check-circle"></i> SUBSCRIBED </button>'
                                $("#subscribe-form").slideUp();
                                $('.Subscribe-box').append(btn);
                            } else {
                                //
                            }
                        },
                        error: function (xhr, status, error) {
                            // console.log(error);
                        },
                        complete: function (url, options) {
                        }
                    });
                });
            });
        })(jQuery);
    </script>
@endsection
