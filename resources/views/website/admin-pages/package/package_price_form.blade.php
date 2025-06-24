@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>Jagha - Buy Sell Rent Homes & Properties In Pakistan by https://www.jagha.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">

@endsection

@section('content')
    <div id="site" class="left relative">
        <div id="site-wrap" class="left relative">
            @include('website.admin-pages.includes.admin-nav')
            <div style="min-height:90px"></div>
            <div class="submit-property">
                <div class="container-fluid container-padding">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" role="tabpanel">
                                    <div class="row my-4">
                                        <div class="col-md-3">
                                            @include('website.admin-pages.package.sidebar')
                                        </div>
                                        <div class="col-md-9">
                                            @include('website.layouts.flash-message')
                                            <div class="tab-content" id="listings-tabContent">
                                                <div class="float-right"><span class="pull-right"><a class="btn btn-sm transition-background color-green mr-2" href="/"><i class="fa fa-globe mr-1"></i>Go to jagha.com</a></span>
                                                </div>

                                                <div class="tab-pane fade active show" id="listings-all" role="tabpanel"
                                                     aria-labelledby="listings-all-tab">
                                                    <h6>Packages Pricing</h6>
                                                    <div class="my-4">
                                                        <div class="card my-4">
                                                            <div class="card-header theme-blue text-white">
                                                                <div class="font-14 font-weight-bold text-white">Edit Price</div>
                                                            </div>
                                                            <div class="card-body">
                                                                {{ Form::open(['route' => ['admin.package.price.update',$package], 'method' => 'post', 'class'=> 'package-form']) }}
                                                                {{ Form::bsRadio('package_for', ucwords($package->package_for), ['required' => true, 'list' => ['Agency','Properties'],'display' => 'block','class'=>'mt-3']) }}
                                                                @error('package_for') <span class="error help-block text-red">{{ $message }}</span> @enderror

                                                                {{ Form::bsText('type', $package->type, ['required' => true]) }}


                                                                {{ Form::bsNumber('price', isset($package->price_per_unit)?$package->price_per_unit:0, ['required' => true, 'min' => 1, 'step' => 1]) }}

                                                            </div>
                                                            <div class="card-footer">
                                                                {{ Form::submit('Submit', ['class' => 'btn btn-primary btn-md search-submit-btn']) }}
                                                            </div>
                                                            {{ Form::close() }}
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer start -->

@endsection

@section('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    {{--    <script src="{{asset('website/js/admin-package-listings.js')}}"></script>--}}
    <script>
        (function ($) {
            $(document).ready(function () {
                $('.package-price-table').DataTable(
                    {
                        "scrollX": true,
                        "ordering": false,
                        "responsive": true
                    }
                );
            });
        })(jQuery);
    </script>
@endsection
