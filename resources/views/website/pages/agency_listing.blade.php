@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}">
@endsection

@section('content')
    @include('website.includes.nav')
    {{--    @include('website.includes.banner2')--}}
    @include('website.includes.agency_banner')
    {{--    @include('website.includes.search2')--}}
    @include('website.includes.agency-search2')
    <!-- Properties section body start -->
    <div class="properties-section agency-search-filter">
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
                                        {{ucwords(str_replace('-',' ',explode("agents-",explode('_', request()->segment(1))[0])[1]))}}
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
                                    @elseif(request()->segment(1) === 'key-partners')
                                        <a href="{{route('key-partners',['sort'=>'newest'])}}">
                                            <span class="breadcrumb-link" itemprop="name">
                                            {{ucwords(str_replace('-',' ',explode('_', request()->segment(1))[0]))}}
                                            </span>
                                        </a>
                                    @else
                                        <span itemprop="name">
                                            {{ucwords(str_replace('-',' ',explode('_', request()->segment(1))[0]))}}
                                            </span>
                                    @endif
                                @endif
                                @if(isset($agency_city))
                                    <span itemprop="name">{{$agency_city}}</span>
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
                        {{--                        {{ $agencies->links() }}--}}
                        {{ $agencies->links('vendor.pagination.bootstrap-4') }}


                    </div>
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="sidebar-right">
                        @include('website.includes.subscribe-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- email models  -->
    <div class="modal fade" id="EmailModelCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header  modal-header-color">
                    <h5 class="modal-title color-white" id="myModalLabel">Contact Agent</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="color-white" aria-hidden="true">×</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body contact-modal-padding">
                    <div class="container">
                        {{ Form::open(['route'=>['contact'],'method' => 'post','role' => 'form', 'id'=> 'email-contact-form', 'role' => 'form']) }}
                        <div><label class="mt-2">Name<span style="color:red">*</span></label></div>
                        {{ Form::text('name',  \Illuminate\Support\Facades\Auth::check()? \Illuminate\Support\Facades\Auth::user()->name: null, array_merge(['required'=>'true','class' => 'form-control form-control-sm' , 'aria-describedby' => 'name' . '-error', 'aria-invalid' => 'false', 'placeholder'=>"Name"])) }}
                        <div class="mt-2"><label class="mt-2">Email<span style="color:red">*</span></label></div>
                        {{ Form::email('email', \Illuminate\Support\Facades\Auth::check()? \Illuminate\Support\Facades\Auth::user()->email : null, array_merge(['required'=>'true','class' => 'form-control form-control-sm', 'aria-describedby' => 'email' . '-error', 'aria-invalid' => 'false', 'placeholder'=>"name@domain.com"])) }}
                        <div class="mt-2"><label class="mt-2">Phone (03001234567) <span style="color:red">*</span></label></div>
                        {{ Form::tel('phone', null, array_merge(['required'=>'true','class' => 'form-control form-control-sm', 'aria-describedby' => 'phone' . '-error', 'aria-invalid' => 'false','placeholder'=>"03001234567"])) }}
                        <div class="mt-2"><label class="mt-2">Message<span style="color:red">*</span></label></div>
                        <div class="editable form-control form-control-sm valid editable-div mt-2" contenteditable="true">
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
                            {{ Form::submit('Email', ['class' => 'btn search-submit-btn btn-block btn-email','id'=>'send-mail']) }}
                        </div>
                        {{ Form::close() }}
                        <button class="btn btn-block btn-danger  mt-2" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="EmailConfirmModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
            <div class="modal-content">
                <!--Body-->
                <div class="modal-body">
                    <div class="container">
                        <div class="text-center">
                            <i class="fas fa-check-circle fa-3x" style="color: #28a745"></i>
                            <div class="m-3" style="font-size: 14px">Message sent successfully</div>
                            <div class="mb-2 line-height">Add <span class="theme-dark-blue">sales@aboutpakistan.com </span> to your white list to get email from us.</div>
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
    <script src="{{ asset('/plugins/select2/js/select2.full.min.js')}}" defer></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}" defer></script>
    <script src="{{asset('website/js/script-custom.min.js')}}" defer></script>
    <script src="{{asset('website/js/agency-listing-page.js')}}"></script>
    <script src="{{asset('website/js/cookie.min.js')}}" defer></script>
@endsection
