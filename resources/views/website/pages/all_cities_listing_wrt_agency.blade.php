@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection


@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}" async defer>
@endsection

@section('content')
    @include('website.includes.nav')
    @include('website.includes.agency_banner')
    <!-- Search Section start -->
    @include('website.includes.agency-search2')
    <!-- Properties section body start -->
    <div class="properties-section agency-search-filter">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12 pb-3">
                    <!-- Listing -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h1 class="all-cities-header">Partners Listing</h1>

                        </div>
                        <div class="card-body" id="all-cities-partners-count-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="pull-right">
                                        <strong>Sort Alphabetically</strong>
                                        <label class="switch">
                                            <input name="alpha-partners-switch" id="alpha-partners-switch" type="checkbox">
                                            <span class="slider round"></span>
                                        </label>

                                    </div>
                                </div>
                            </div>
                            <h5 style="font-weight: 400">Featured Partners</h5>
                            <div class="s-border"></div>
                            <div class="m-border"></div>
                            <div class="row  mb-3">
                                @foreach($featured_agencies as $agency)
                                    <div class="col-sm-3 my-2">
                                        <a href="{{route('city.wise.partners',['agency'=>'featured','city'=> strtolower(Str::slug($agency->city)),'sort'=> 'newest'])}}"
                                           title="agencies in {{$agency->city}}"
                                           class="breadcrumb-link">
                                            {{$agency->city}} ({{$agency->agency_count}})
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <h5 style="font-weight: 400">Key Partners</h5>
                            <div class="s-border"></div>
                            <div class="m-border"></div>
                            <div class="row mb-3">
                                @foreach($key_agencies as $agency)
                                    <div class="col-sm-3 my-2">
                                        <a href="{{route('city.wise.partners',['agency'=>'key','city'=> strtolower(Str::slug($agency->city)),'sort'=> 'newest'])}}"
                                           title="agencies in {{$agency->city}}"
                                           class="breadcrumb-link">
                                            {{$agency->city}} ({{$agency->agency_count}})
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <h5 style="font-weight: 400">Other Partners</h5>
                            <div class="s-border"></div>
                            <div class="m-border"></div>
                            <div class="row">
                                @foreach($normal_agencies as $agency)
                                    <div class="col-sm-3 my-2">
                                        <a href="{{route('city.wise.partners',['agency'=>'other','city'=> strtolower(Str::slug($agency->city)),'sort'=> 'newest'])}}"
                                           title="agencies in {{$agency->city}}"
                                           class="breadcrumb-link">
                                            {{$agency->city}} ({{$agency->agency_count}})
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="sidebar-right mt-0">

                            @include('website.includes.subscribe-content')

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
    <script src="{{asset('website/js/jquery.validate.min.js')}}" defer></script>
    <script src="{{asset('website/js/cookie.min.js')}}" defer></script>
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}" defer></script>
    <script src="{{asset('website/js/all-cities-page.js')}}" defer></script>
    <script>
        (function ($) {
            $(document).ready(function () {
                $('.select2').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === "en" ? "ltr" : "rtl"}}',
                });
                $('.select2bs4').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === "en" ? "ltr" : "rtl"}}',
                    theme: 'bootstrap4',
                });
            })
        })(jQuery);
    </script>

@endsection
