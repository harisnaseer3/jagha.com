@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
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
                                                <div class="float-right"><span class="pull-right"><a class="btn btn-sm transition-background color-green mr-2" href="/"><i class="fa fa-globe mr-1"></i>Go to property.aboutpakistan.com</a></span>
                                                </div>

                                                <div class="tab-pane fade active show" id="listings-all" role="tabpanel"
                                                     aria-labelledby="listings-all-tab">
                                                    <h6>Packages Pricing</h6>
                                                    <div class="my-4">
                                                        <div class="card my-4">
                                                            <div class="card-header theme-blue text-white">
                                                                <div class="font-14 font-weight-bold text-white">Packages</div>

                                                            </div>
                                                            <div class="card-body">
                                                                <table class="display package-price-table" style="width: 100%">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Type</th>
                                                                        <th>Package For</th>
                                                                        <th>Unit Price</th>
                                                                        <th>Applied At</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    @foreach($packages as $index => $package)
                                                                        <tr>
                                                                            <td>{{$index + 1 }}</td>
                                                                            <td>{{$package['for']}}</td>
                                                                            <td class="text-bold">{{$package['type']}}</td>
                                                                            <td class="text-center">{{$package['price']}}</td>
                                                                            <td>{{$package['at']}}</td>
                                                                            <td class="text-center">
                                                                                <a type="button"
                                                                                   href="{{route('admin.package.price.edit', $package['link'])}}"
                                                                                   class="btn btn-sm btn-success mb-1"
                                                                                   data-toggle-1="tooltip"
                                                                                   data-placement="bottom" title="Edit">
                                                                                    <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach

                                                                    </tbody>


                                                                </table>
                                                            </div>
                                                        </div>
                                                        {{--                                                        <div class="card my-4">--}}
                                                        {{--                                                            <div class="card-header theme-blue text-white">--}}
                                                        {{--                                                                <div class="font-14 font-weight-bold text-white">Update Packages Prices</div>--}}
                                                        {{--                                                            </div>--}}
                                                        {{--                                                        </div>--}}
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
