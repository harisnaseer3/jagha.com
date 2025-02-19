@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection

@section('css')
        <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/intl-tel-input/css/intlTelInput.min.css')}}" async defer>
    <style>
            .call-model-btn{
        background-color: white;
        }
        </style>

@endsection

@section('content')
    <!-- Top header start -->
    <!-- Top header end -->
    <!-- Main header start -->
    @include('website.includes.nav')
    @include('website.includes.banner2')
    @include('website.includes.search2')

    <!-- Properties section body start -->
    <div class="properties-section content-area2" id="data-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12">
                    @if(strpos( request()->segment(1), 'partners-' ) !== false)
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
                            <a href="{{route('agents.listing')}}" title="Partners" itemprop="item">
                            <span class="breadcrumb-link" itemprop="name">
                                   {{ucwords('Partners')}}
                            </span></a>
                            <meta itemprop="position" content="3">
                        </span>
                            <span class="mx-2" aria-label="Link delimiter"> <i class="fal fa-greater-than"></i></span>
                            <span itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                            <span itemprop="name">
                                <!-- if homes are selected from nav bar -->
                                @if(strpos(explode('-', request()->segment(1))[0] , 'partners') !== false)
                                    <a href="{{route('agencies.citywise.listing',['city'=> explode('partners-',explode('_', request()->segment(1))[0])[1],'sort'=> 'newest'])}}" title="city"
                                       itemprop="item">
                                        <span class="breadcrumb-link" itemprop="name">
                                        {{ucwords(str_replace('-',' ',explode("partners-",explode('_', request()->segment(1))[0])[1]))}}
                                    </span>
                                    </a>
                                @else
                                    {{ucwords(str_replace('-',' ',explode('_', request()->segment(1))[0]))}}
                                @endif
                            </span>
                            <meta itemprop="position" content="4">
                            </span>

                            <span class="mx-2" aria-label="Link delimiter"> <i class="fal fa-greater-than"></i></span>
                            <span itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                            <span itemprop="name">
                                <!-- if homes are selected from nav bar -->
                                    {{ucwords(str_replace('-',' ',explode('_',request()->segment(2))[0]))}}
                            </span>
                            <meta itemprop="position" content="5">
                            </span>
                        </div>
                    @else
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
                                @if(in_array(explode('_', request()->segment(1))[0],['plots','homes','commercial', 'hotels']))
                                    <span itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                                    <a href="{{route('property.city.count.listing',['type'=>lcfirst(explode('_', request()->segment(1))[0]), 'sort' =>'newest'])}}"
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
                                        else if(in_array(ucwords(explode('_', request()->segment(1))[0]),['Hotels']))
                                            $type = 'Hotels';
                                        else $type = 'Plots';
                                    @endphp
                                    <span itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                                    <a href="{{route('property.city.count.listing',['type'=>lcfirst($type), 'sort' =>'newest'])}}"
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
                    @endif

                    {{--                    {{dd( number_format(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 2))}}--}}
                    {{--                    {{dd( $properties)}}--}}
                    <!-- Search Result Count -->
                    {{--                    @if(count($properties) == 0)--}}
                    @if($properties->isEmpty())
                        <div class="alert alert-info font-weight-bold"><i class="fas fa-search"></i>
                            <span aria-label="Summary text" class="ml-2 color-white">0 results found</span>
                            <span class="color-white">({{ number_format(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 2) }} seconds)</span>
                        </div>
                    @else
                        <div class="alert alert-info font-weight-bold"><i class="fas fa-search"></i>
                            <span aria-label="Summary text" class="ml-2 color-white">{{ $properties->count() }} results found</span>
                            <span class="color-white">({{ number_format(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 2) }} seconds)</span>
                        </div>
                    @endif

                    @if(isset($agency_detail))
                        @include('website.includes.agency_detail_card')
                    @endif

                    <div class="ajax-loader"></div>
                    <!-- Listing -->
                    <div id="listings-div">
                        <div class="page-list-layout">
                            @include('website.layouts.list_layout_property_listing')
                        </div>
                        <div class="page-grid-layout" style="display: none;">
                            @include('website.layouts.grid_layout_property_listing')
                        </div>
                        @if($properties->count())
                            <!-- Pagination -->
                            <div class="pagination-box hidden-mb-45 text-center" role="navigation">
                                {{ $properties->render('vendor.pagination.bootstrap-4') }}
                            </div>
                        @endif
                    </div>
                    @if( request()->segment(1) != 'featured-properties' && request()->query('location') == null)
                        @include('website.includes.locations_count_card')
                    @endif

                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="sidebar-right">
                        @include('website.includes.subscribe-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="EmailModelCenter" tabindex="-1" role="dialog" aria-labelledby="EmailModel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header modal-header-color">
                    <h5 class="modal-title color-white" id="myModalLabel">Contact Seller</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class=" color-white" aria-hidden="true">×</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body contact-modal-padding">
                    <div class="container">
                        {{ Form::open(['route'=>['contact'],'method' => 'post','role' => 'form', 'id'=> 'email-contact-form', 'role' => 'form']) }}
                        <div><label class="mt-2">Name<span style="color:red">*</span></label></div>
                        {{ Form::text('name',  \Illuminate\Support\Facades\Auth::check()? \Illuminate\Support\Facades\Auth::user()->name:null, array_merge(['required'=>'true','class' => 'form-control form-control-sm user-name' , 'aria-describedby' => 'name' . '-error', 'aria-invalid' => 'false', 'placeholder'=>"Name"])) }}
                        <div class="mt-2"><label class="mt-2">Email<span style="color:red">*</span></label></div>
                        {{ Form::email('email',  \Illuminate\Support\Facades\Auth::check()? \Illuminate\Support\Facades\Auth::user()->email:null, array_merge(['required'=>'true','class' => 'form-control form-control-sm', 'aria-describedby' => 'email' . '-error', 'aria-invalid' => 'false', 'placeholder'=>"name@domain.com"])) }}

                        <div class="mt-2"><label class="mt-2">Mobile #<span style="color:red">*</span></label></div>
                        {{ Form::tel('phone_#',  \Illuminate\Support\Facades\Auth::check()? \Illuminate\Support\Facades\Auth::user()->cell:null, array_merge(['required'=>'true', 'id'=>'cell', 'class' => 'form-control form-control-sm', 'aria-describedby' => 'phone' . '-error', 'aria-invalid' => 'false'])) }}
                        <span id="valid-msg" class="hide validated mt-2">✓ Valid</span>
                        <span id="error-msg" class="hide error mt-2"></span>
                        <input class="form-control" name="phone" type="hidden" value="{{\Illuminate\Support\Facades\Auth::check()? \Illuminate\Support\Facades\Auth::user()->cell:null}}">
                        {{--                        <div><label class="mt-2">Message<span style="color:red">*</span></label></div>--}}

                        <div class="mt-2"><label class="mt-2">Message<span style="color:red">*</span></label></div>
                        <div class="editable form-control form-control-sm editable-div" contenteditable="true">
                        </div>
                        {!! Form::hidden('message', null, array_merge(['class' => 'form-control form-control-sm' , 'aria-describedby' => 'message' . '-error', 'aria-invalid' => 'false', 'rows' => 3, 'cols' => 10, 'style' => 'resize:none'])) !!}
                        <div class="mt-2">
                            <div class="form-group row">
                                <div class="col-lg-3 col-xl-3">
                                    <div class="custom-control custom-radio custom-control-inline align-items-center">
                                        <input class="custom-control-input" type="radio" name="i am" id="i am_radio_0" value="Buyer" aria-describedby="i am-error" checked="">
                                        <label class="custom-control-label" style="line-height:1.2rem;" for="i am_radio_0">
                                            Buyer </label>
                                    </div>

                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <div class="custom-control custom-radio custom-control-inline align-items-center">
                                        <input class="custom-control-input" type="radio" name="i am" id="i am_radio_1" value="Agent" aria-describedby="i am-error">
                                        <label class="custom-control-label" style="line-height:1.2rem;" for="i am_radio_1">
                                            Agent </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::hidden(null,null, array_merge(['class'=>'selected']))}}
                        <div class="text-center">
                            {{--                            {{ Form::submit('Email', ['class' => 'btn search-submit-btn btn-block btn-email','id'=>'send-mail']) }}--}}
                            {{ Form::submit('Email', ['class' => 'btn search-submit-btn btn-block email-btn-model','id'=>'send-mail']) }}
                        </div>
                        {{ Form::close() }}
                        <button class="btn btn-block btn-danger  mt-2" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="EmailConfirmModel" tabindex="-1" role="dialog" aria-labelledby="EmailConfirmModel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
            <div class="modal-content">
                <!--Body-->
                <div class="modal-body">
                    <div class="container">
                        <div class="text-center">
                            <i class="fas fa-check-circle fa-3x" style="color: #28a745"></i>
                            <div class="m-3" style="font-size: 14px">Message sent successfully</div>
                            <div class="mb-2 line-height">Add <span class="theme-dark-blue">info@aboutpakistan.com </span> to your white list to get email from us.</div>
                            <button class="btn btn-email" data-dismiss="modal">Dismiss</button>
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
        $('#close-icon').click(function () {
            $(this).text($(this).text() === 'close' ? 'open' : 'close');
            $("#locations-card").slideToggle();
        });
    </script>
    <script src="{{ asset('/plugins/select2/js/select2.full.min.js')}}" defer></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}" defer></script>
    <script src="{{asset('website/js/cookie.min.js')}}" defer></script>
    <script src="{{asset('plugins/intl-tel-input/js/intlTelInput.js')}}" defer></script>
    <script src="{{asset('website/js/script-custom.min.js')}}"></script>
    <script src="{{asset('website/js/listing-page.js')}}"></script>

@endsection
