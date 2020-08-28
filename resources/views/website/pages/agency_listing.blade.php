@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')
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

                        <span itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                            <a href="{{route('agents.listing')}}" title="Agents" itemprop="item">
                            <span class="breadcrumb-link" itemprop="name">
                                   {{ucwords('Partners')}}
                            </span></a>
                            <meta itemprop="position" content="3">
                        </span>
                        <span class="mx-2" aria-label="Link delimiter"> <i class="fal fa-greater-than"></i></span>

                        <span itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                            <span itemprop="name">
                                @if(request()->segment(2) == 'null' || request()->segment(2) == '')
                                    @if(strpos(explode('-', request()->segment(1))[0] , 'agents') !== false)
                                        {{ucwords(explode("-",explode('_', request()->segment(1))[0])[1])}}
                                    @else
                                        {{ucwords(str_replace('-',' ',explode('_', request()->segment(1))[0]))}}
                                    @endif
                                @elseif(strpos(request()->segment(1), 'partners') !== false && request()->segment(2) !== null)
                                    @if(request()->segment(1) === 'featured-partners')
                                        <a href="{{route('featured-partners',['sort'=>'newest'])}}">
                                            <span class="breadcrumb-link" itemprop="name">
                                            {{ucwords(str_replace('-',' ',explode('_', request()->segment(1))[0]))}}
                                            </span>
                                        </a>
                                    @else
                                        <a href="{{route('key-partners',['sort'=>'newest'])}}">
                                             <span class="breadcrumb-link" itemprop="name">
                                            {{ucwords(str_replace('-',' ',explode('_', request()->segment(1))[0]))}}
                                             </span>
                                        </a>
                                    @endif

                                @endif
                            </span>
                            <meta itemprop="position" content="4">
                        </span>
                        @if(strpos(request()->segment(1), 'partners') !== false && request()->segment(2) !== null)
                            <span class="mx-2" aria-label="Link delimiter"> <i class="fal fa-greater-than"></i></span>
                            <span itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                            <span itemprop="name">{{ucwords(str_replace('-',' ',request()->segment(2)))}}</span>
                            <meta itemprop="position" content="5">
                        </span>
                        @endif

                    </div>

                    <!-- Search Result Count -->
                    <div class="alert alert-info font-weight-bold"><i class="fas fa-search"></i>
                        <span aria-label="Summary text" class="ml-2 color-white">{{ $agencies->total() }} results found</span>
                        <span class="color-white">({{ number_format(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 2) }} seconds)</span>
                    </div>
                    <!-- cities cards in case of featured and key partners-->
                @if(strpos($_SERVER['REQUEST_URI'], 'partners') !== false && request()->segment(2) == null)
                    @include('website.includes.agencies_cities_card')
                @endif
                <!-- Listing -->
                    <div class="page-list-layout">
                        @include('website.layouts.list_layout_agency_listing')
                    </div>

                    <div class="page-grid-layout" style="display: none;">
                        @include('website.layouts.grid_layout_agency_listing')
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-box hidden-mb-45 text-center" role="navigation">
                        {{ $agencies->links() }}
                    </div>
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
                    <h5 class="modal-title" id="myModalLabel">Contact Agent</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <div class="container">
                        {{ Form::open(['route'=>['contact'],'method' => 'post','role' => 'form', 'id'=> 'email-contact-form', 'role' => 'form']) }}
                        <div><label class="mt-2">Name<span style="color:red">*</span></label></div>
                        {{ Form::text('name',  \Illuminate\Support\Facades\Auth::check()? \Illuminate\Support\Facades\Auth::user()->name: null, array_merge(['required'=>'true','class' => 'form-control form-control-sm' , 'aria-describedby' => 'name' . '-error', 'aria-invalid' => 'false', 'placeholder'=>"Name"])) }}
                        <div><label class="mt-2">Email<span style="color:red">*</span></label></div>
                        {{ Form::email('email', \Illuminate\Support\Facades\Auth::check()? \Illuminate\Support\Facades\Auth::user()->email : null, array_merge(['required'=>'true','class' => 'form-control form-control-sm', 'aria-describedby' => 'email' . '-error', 'aria-invalid' => 'false', 'placeholder'=>"name@domain.com"])) }}
                        <div><label class="mt-2">Phone (+923001234567) <span style="color:red">*</span></label></div>
                        {{ Form::tel('phone', null, array_merge(['required'=>'true','class' => 'form-control form-control-sm', 'aria-describedby' => 'phone' . '-error', 'aria-invalid' => 'false','placeholder'=>"+92-300-1234567"])) }}
                        <div><label class="mt-2">Message<span style="color:red">*</span></label></div>
                        <div class="editable form-control form-control-sm valid editable-div" contenteditable="true">
                        </div>
                        {!! Form::hidden('message', null, array_merge(['class' => 'form-control form-control-sm' , 'aria-describedby' => 'message' . '-error', 'aria-invalid' => 'false', 'rows' => 3, 'cols' => 10, 'style' => 'resize:none'])) !!}
                        <div class="mt-2">
                            {{ Form::bsRadio('i am','Buyer', [ 'list' => ['Buyer', 'Agent']]) }}
                        </div>
                        {{ Form::hidden(null,null, array_merge(['class'=>'selected']))}}
                        <div class="text-center">
                            {{ Form::submit('Email', ['class' => 'btn search-submit-btn btn-block btn-email','id'=>'send-mail']) }}
                        </div>
                        {{ Form::close() }}
                        <button class="btn btn-block btn-danger  mt-2" data-dismiss="modal">Cancel</button>
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
    <script src="{{ asset('/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.bundle.min.js')}}"></script>
    <script>
        (function ($) {
            $(document).ready(function () {
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

                $('#close-icon').click(function () {
                    $(this).text($(this).text() === 'close' ? 'open' : 'close');
                    $("#cities-card").slideToggle();
                });

                $('.record-limit').on('change', function (e) {
                    insertParam('limit', $(this).val());
                });

                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="popover"]').popover({trigger: "hover"});
                $(document).on("click", ".popover .close", function () {
                    $(this).parents(".popover").popover('hide');
                });
                $('body').on('click', function (e) {
                    $('[data-toggle=popover]').each(function () {
                        // hide any open popovers when the anywhere else in the body is clicked
                        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                            $(this).popover('hide');
                        }
                    });
                });

                $('.tt_large').tooltip({template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner large"></div></div>'});

                $('.list-layout-btn').on('click', function (e) {
                    sessionStorage.setItem("page-layout", 'list-layout');
                    // console.log(sessionStorage.getItem("page-layout"))
                    $('.page-list-layout').show();
                    $('.page-grid-layout').hide();
                });

                $('.grid-layout-btn').on('click', function (e) {
                    sessionStorage.setItem("page-layout", 'grid-layout');
                    // console.log(sessionStorage.getItem("page-layout"))
                    $('.page-list-layout').hide();
                    $('.page-grid-layout').show();
                });

                if (sessionStorage.getItem("page-layout") === 'list-layout') {
                    $('.page-list-layout').show();
                    $('.page-grid-layout').hide();
                } else if (sessionStorage.getItem("page-layout") === 'grid-layout') {
                    $('.page-list-layout').hide();
                    $('.page-grid-layout').show();
                }

                $('.sorting').on('change', function (e) {
                    // location.assign(location.href.replace(/(.*)(sort=)(.*)/, '$1$2' + $(this).val()));
                    insertParam('sort', $(this).val());
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
                            // console.log(error);
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
                    let link = '<a href="https://www.aboutpakistan.com" style="text-decoration:underline; color:blue">https://www.aboutpakistan.com</a>';
                    let message = 'I would like to gather information about your properties as per your business listing on ' + link + '<br><br>Please contact me at your earliest by phone or by email.';

                    phone = $(this).closest('.contact-container').find('input[name=phone]').val();
                    // console.log(property, agency, reference,);
                    let editable_div = $('.editable-div');
                    editable_div.html(message);
                    $('input[name=message]').val(editable_div.html());
                    editable_div.click(function () {
                        if (editable_div.html() !== '') {
                            $('input[name=message]').val(editable_div.html());
                        }
                    })

                    if (!(property == null))
                        $('.selected').val(property).attr('name', 'property');
                    else if (!(agency == null))
                        $('.selected').val(agency).attr('name', 'agency');
                    $('textarea[name=message]').val(message);
                    call_btn.text('Call');
                });
                let call_btn = $('.agent-call');
                call_btn.on('click', function () {
                    call_btn.attr('href', 'tel:' + phone).text(phone);
                });
                $.validator.addMethod("regx", function (value, element, regexpr) {
                    return regexpr.test(value);
                }, "Please enter a valid value. (+923001234567)");

                form.validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        phone: {
                            required: true,
                            regx: /^\+923\d{2}\d{7}$/,
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
                            $('div.error.text-red span').text(message);
                            error_tag.show();
                        } else {
                            $('div.error.text-red').hide();
                        }
                    }
                });

                $('#send-mail').click(function (event) {
                    if (form.valid()) {
                        event.preventDefault();
                        // jQuery.ajaxSetup({
                        //     headers: {
                        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        //     }
                        // });
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
