@extends('website.layouts.app')
<!--TODO add SEO on this page-->
{{--@section('title')--}}
{{--    {!! SEO::generate(true) !!}--}}
{{--@endsection--}}


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
                                {{$type}} for {{$purpose}} in All Cities of Pakistan</h1>
                        </div>
                        <div class="card-body">
                            @if(trim(explode('&',$type)[0]) =='Houses')<h2 class="all-cities-header">{{trim(explode('&',$type)[0])}}</h2>@endif
                            <div class="row">
                            @if(isset($cities[trim(strtolower(explode('&',$type)[0]))]))
                                    @foreach($cities[trim(strtolower(explode('&',$type)[0]))] as  $city)
                                        <div class="col-sm-3 my-2">
                                            <a href="{{route('sale.property.search', ['sub_type' => lcfirst(isset($city->property_sub_type)?$city->property_sub_type:$city->property_type),
                                                    'city' => lcfirst($city->city_name) ,
                                                    'purpose'=>lcfirst($city->property_purpose),
                                                    'sort'=>'newest'])}}"
                                               title="{{isset($city->property_sub_type)?$city->property_sub_type.'s':$city->property_type}}  in {{$city->city_name}}"
                                               class="breadcrumb-link">
                                                {{$city->city_name}} ({{$city->property_count}})
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            @if(isset($cities['flats']))
                                <h2 class="all-cities-header pt-1">Flats</h2>
                                <div class="row">
                                    @foreach($cities['flats'] as  $city2)
                                        <div class="col-sm-3 my-2">
                                            <a href="{{route('sale.property.search', ['sub_type' => lcfirst($city2->property_sub_type), 'city' => lcfirst($city2->city_name) ,
                                                    'purpose'=>lcfirst($city2->property_purpose), 'sort'=>'newest'])}}"
                                               title="{{$city2->property_sub_type.'s'}}  in {{$city2->city_name}}"
                                               class="breadcrumb-link">
                                                {{$city2->city_name}} ({{$city2->property_count}})
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

                {{--$('.select2').select2({--}}
                {{--    language: '{{app()->getLocale()}}',--}}
                {{--    direction: '{{app()->getLocale() === 'en' ? 'ltr' : 'rtl'}}',--}}
                {{--});--}}
                {{--$('.select2bs4').select2({--}}
                {{--    language: '{{app()->getLocale()}}',--}}
                {{--    direction: '{{app()->getLocale() === 'en' ? 'ltr' : 'rtl'}}',--}}
                {{--    theme: 'bootstrap4',--}}
                {{--});--}}

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
                            console.log(error);
                        },
                        complete: function (url, options) {
                        }
                    });
                });
            });
        })(jQuery);
    </script>
{{--    <script src="{{asset('website/js/script-custom.js')}}"></script>--}}

@endsection
