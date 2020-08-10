@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')
    <!-- Top header start -->
    <!-- Top header end -->
    <!-- Main header start -->
    @include('website.includes.nav')
    @include('website.includes.banner2')
    @include('website.includes.search2')

    <!-- Properties section body start -->
    <div class="properties-section content-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12">
                    <div itemscope="" itemtype="http://schema.org/BreadcrumbList" aria-label="Breadcrumb" class="breadcrumbs m-2">
                        <span itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                            <a href="{{asset('https://www.aboutpakistan.com/')}}" title="AboutPakistan" itemprop="item">
                            <span class="breadcrumb-link" itemprop="name">Home</span></a>
                            <meta itemprop="position" content="1">
                        </span>
                        <span class="mx-2" aria-label="Link delimiter"> <i class="fal fa-greater-than"></i></span>
                        <span itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                            <a href="{{asset('/')}}" title="Property" itemprop="item">
                            <span class="breadcrumb-link" itemprop="name">Property</span></a>
                            <meta itemprop="position" content="2">
                        </span>
                        <span class="mx-2" aria-label="Link delimiter"> <i class="fal fa-greater-than"></i></span>

                        @if(request()->segment(2) == 'null' || request()->segment(2) == '')
                            <span itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                            <span itemprop="name">
                                <!-- if an option selected from nav bar -->
                                @if(strpos(explode('_', request()->segment(1))[0] , 'cities' ) !== false)
                                    {{ucwords(explode("-",explode('_', request()->segment(1))[0])[1])}}
                                @else
                                    {{ucwords(str_replace("-"," ",explode('_', request()->segment(1))[0]))}}
                                @endif
                            </span>
                            <meta itemprop="position" content="3">
                            </span>
                        @else
                            @if(in_array(explode('_', request()->segment(1))[0],['plots','homes','commercial']))
                                <span itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                                    <a href="{{route('properties.get_listing',['type'=>explode('_', request()->segment(1))[0], 'sort' =>'newest'])}}"
                                       title="{{ucfirst(explode('_', request()->segment(1))[0])}}" itemprop="item">
                                <span class="breadcrumb-link" itemprop="name">{{ucfirst(explode('_', request()->segment(1))[0])}}</span></a>
                                <meta itemprop="position" content="3">
                                </span>
                            @else
                                @php
                                    if(in_array(ucwords(explode('_', request()->segment(1))[0]),['House', 'Flat', 'Upper Portion', 'Lower Portion', 'Farm House', 'Room', 'Penthouse']))
                                            $type = 'Homes';
                                    else if(in_array(ucwords(explode('_', request()->segment(1))[0]),['Office', 'Shop', 'Warehouse', 'Factory', 'Building', 'Other']))
                                        $type = 'Commercial';
                                    else $type = 'Plots';
                                @endphp
                                <span itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                                    <a href="{{route('properties.get_listing',['type'=>$type, 'sort' =>'newest'])}}"
                                       title="{{$type}}" itemprop="item">
                                <span class="breadcrumb-link" itemprop="name">{{$type}}</span></a>
                                <meta itemprop="position" content="3">
                                </span>
                            @endif

                            <span class="mx-2" aria-label="Link delimiter"> <i class="fal fa-greater-than"></i></span>
                            <span itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                            <span itemprop="name">{{ucfirst(request()->segment(2))}}</span>
                            <meta itemprop="position" content="3">
                            </span>

                        @endif

                    </div>

                    <!-- Search Result Count -->
                    @if(count($properties) == 0)
                        <div class="alert alert-info font-weight-bold"><i class="fas fa-search"></i>
                            <span aria-label="Summary text" class="ml-2 color-white">0 results found</span>
                            <span class="color-white">({{ number_format(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 2) }} seconds)</span>
                        </div>
                    @else
                        <div class="alert alert-info font-weight-bold"><i class="fas fa-search"></i>
                            <span aria-label="Summary text" class="ml-2 color-white">{{ $properties->total() }} results found</span>
                            <span class="color-white">({{ number_format(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 2) }} seconds)</span>
                        </div>
                    @endif

                <!-- Listing -->
                    <div class="page-list-layout">
                        @include('website.layouts.list_layout_property_listing')
                    </div>

                    <div class="page-grid-layout" style="display: none;">
                        @include('website.layouts.grid_layout_property_listing')
                    </div>
                    @if($properties->count())
                    <!-- Pagination -->
                        <div class="pagination-box hidden-mb-45 text-center" role="navigation">
                            {{ $properties->links() }}
                        </div>
                    @endif
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="sidebar-right">
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
    <div class="modal fade" id="EmailModelCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Contact Seller</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <div class="container">
                        {{ Form::open(['route'=>['contact'],'method' => 'post','role' => 'form', 'id'=> 'email-contact-form', 'role' => 'form']) }}
                        <div><label class="mt-2">Name<span style="color:red">*</span></label></div>
                        {{ Form::text('name', null, array_merge(['required'=>'true','class' => 'form-control form-control-sm' , 'aria-describedby' => 'name' . '-error', 'aria-invalid' => 'false', 'placeholder'=>"Name"])) }}
                        <div><label class="mt-2">Email<span style="color:red">*</span></label></div>
                        {{ Form::email('email', null, array_merge(['required'=>'true','class' => 'form-control form-control-sm', 'aria-describedby' => 'email' . '-error', 'aria-invalid' => 'false', 'placeholder'=>"name@domain.com"])) }}
                        <div><label class="mt-2">Phone<span style="color:red">*</span></label></div>
                        {{ Form::tel('phone', null, array_merge(['required'=>'true','class' => 'form-control form-control-sm', 'aria-describedby' => 'phone' . '-error', 'aria-invalid' => 'false','placeholder'=>"+92-300-1234567"])) }}
                        <div><label class="mt-2">Message<span style="color:red">*</span></label></div>
                        {!! Form::textarea('message', null, array_merge(['class' => 'form-control form-control-sm' , 'aria-describedby' => 'message' . '-error', 'aria-invalid' => 'false', 'rows' => 3, 'cols' => 10, 'style' => 'resize:none'])) !!}
                        <div class="mt-2">
                            {{ Form::bsRadio('i am','Buyer', ['required' => true, 'list' => ['Buyer', 'Agent', 'Other']]) }}
                        </div>
                        {{ Form::hidden(null,null, array_merge(['class'=>'selected']))}}
                        <div class="text-center">
                            {{ Form::submit('Email', ['class' => 'btn search-submit-btn btn-block btn-email','id'=>'send-mail']) }}
                        </div>
                        {{ Form::close() }}
                        <a href="" class="btn btn-block btn-call mt-2 agent-call">Call</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer start -->
    @include('website.includes.footer')
@endsection

@section('script')
    <script src="{{ asset('/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.bundle.min.js')}}"></script>
    <script>
        (function ($) {
            $(document).ready(function () {

                $('[data-toggle="tooltip"]').tooltip();

                $('.list-layout-btn').on('click', function (e) {
                    sessionStorage.setItem("page-layout", 'list-layout');
                    // console.log(sessionStorage.getItem("page-layout"))
                    $('.page-list-layout').show();
                    $('.page-grid-layout').hide();
                });

                $.fn.stars = function () {
                    return $(this).each(function () {
                        let rating = $(this).data("rating");
                        rating = rating > 5 ? 5 : rating;
                        const numStars = $(this).data("numStars");
                        const fullStar = '<i class="fas fa-star"></i>'.repeat(Math.floor(rating));
                        const halfStar = (rating % 1 !== 0) ? '<i class="fas fa-star-half-alt"></i>' : '';
                        const noStar = '<i class="far fa-star"></i>'.repeat(Math.floor(numStars - rating));
                        $(this).html(`${fullStar}${halfStar}${noStar}`);
                    });
                }
                $('.stars').stars();

                $('.grid-layout-btn').on('click', function (e) {
                    sessionStorage.setItem("page-layout", 'grid-layout');
                    // console.log(sessionStorage.getItem("page-layout"))
                    $('.page-list-layout').hide();
                    $('.page-grid-layout').show();
                    $('.grid-stars').stars();
                });

                if (sessionStorage.getItem("page-layout") === 'list-layout') {
                    $('.page-list-layout').show();
                    $('.page-grid-layout').hide();
                } else if (sessionStorage.getItem("page-layout") === 'grid-layout') {
                    $('.page-list-layout').hide();
                    $('.page-grid-layout').show();
                    $('.grid-stars').stars();
                }

                $('.sorting').on('change', function (e) {
                    insertParam('sort', $(this).val());
                    // location.assign(location.href.replace(/(.*)(sort=)(.*)/, '$1$2' + $(this).val()));
                });

                $('.favorite').on('click', function () {
                    $('.favorite').hide();
                    $('.remove-favorite').show();
                });
                $('.remove-favorite').on('click', function () {
                    $('.favorite').show();
                    $('.remove-favorite').hide();
                });

                function insertParam(key, value) {
                    key = encodeURIComponent(key);
                    value = encodeURIComponent(value);

                    // kvp looks like ['key1=value1', 'key2=value2', ...]
                    var kvp = document.location.search.substr(1).split('&');
                    let i = 0;

                    for (; i < kvp.length; i++) {
                        if (kvp[i].startsWith(key + '=')) {
                            let pair = kvp[i].split('=');
                            pair[1] = value;
                            kvp[i] = pair.join('=');
                            break;
                        }
                    }

                    if (i >= kvp.length) {
                        kvp[kvp.length] = [key, value].join('=');
                    }

                    // can return this or...
                    let params = kvp.join('&');

                    // reload page with new params
                    document.location.search = params;
                }

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

                $('.select2').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === 'en' ? 'ltr' : 'rtl'}}',
                });
                $('.select2bs4').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === 'en' ? 'ltr' : 'rtl'}}',
                    theme: 'bootstrap4',
                });

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
                let phone = '';
                let form = $('#email-contact-form');
                $('.btn-email').click(function (e) {
                    let property = $(this).closest('.contact-container').find('input[name=property]').val();
                    let agency = $(this).closest('.contact-container').find('input[name=agency]').val();
                    // let reference = $(this).closest('.contact-container').find('input[name=reference]').val();
                    let property_link = $(this).closest('.contact-container').find('.property-description').find('a').attr('href');
                    let anchor_link = '<a href="' + property_link + '"> Link </a>';
                    let message = 'I would like to gather information about your property.' + anchor_link + 'Please contact me at your earliest.';
                    phone = $(this).closest('.contact-container').find('input[name=phone]').val();
                    if (!(property == null))
                        $('.selected').val(property).attr('name', 'property');
                    else if (!(agency == null))
                        $('.selected').val(agency).attr('name', 'agency');
                    $('textarea[name=message]').html(message);
                    call_btn.text('Call');
                });
                let call_btn = $('.agent-call');
                call_btn.on('click', function () {
                    call_btn.attr('href', 'tel:' + phone).text(phone);
                });
                $.validator.addMethod("regx", function (value, element, regexpr) {
                    return regexpr.test(value);
                }, "Please enter a valid value. (+92-300-1234567)");

                form.validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        phone: {
                            required: true,
                            regx: /^\+92-3\d{2}-\d{7}$/,
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        message: {
                            required: true,
                        },
                    },
                    messages: {},
                    errorElement: 'small',
                    errorClass: 'help-block text-red',
                    submitHandler: function (form) {
                        form.preventDefault();
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

                $('#send-mail').click(function (event) {
                    if (form.valid()) {
                        event.preventDefault();
                        jQuery.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        jQuery.ajax({
                            type: 'post',
                            url: window.location.origin + '/property' + '/contactAgent',
                            data: form.serialize(),
                            dataType: 'json',
                            success: function (data) {
                                if (data.status === 200) {
                                    console.log(data.data);
                                    $('#EmailModelCenter').modal('hide');
                                    $('#EmailConfirmModel').modal('show');

                                } else {
                                    console.log(data.data);
                                }
                            },
                            error: function (xhr, status, error) {
                                console.log(error);
                                console.log(status);
                                console.log(xhr);
                            },
                            complete: function (url, options) {
                            }
                        });
                    }
                })
            });
        })(jQuery);
    </script>
    <script src="{{asset('website/js/script-custom.js')}}"></script>

@endsection
