@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>Jagha - Buy Sell Rent Homes & Properties In Pakistan by https://www.jagha.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">

@endsection

@section('content')
    @include('website.admin-pages.includes.admin-nav')
    <!-- Top header start -->
    {{--    <div class="sub-banner">--}}
    {{--        <div class="container">--}}
    {{--            <div class="page-name">--}}
    {{--                <h1>Package</h1>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <!-- Submit Property start -->
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
                                    <div class="message-block"></div>
                                    @include('website.layouts.flash-message')
                                    <div class="tab-content" id="listings-tabContent">

                                        <div class="tab-pane fade active show" id="listings-all" role="tabpanel"
                                             aria-labelledby="listings-all-tab">
                                            <h6>Package</h6>

                                            <div class="my-4">
                                                <div class="card mb-2">
                                                    <div class="card-header theme-blue text-white">
                                                        <div class="font-14 font-weight-bold text-white">Package Details</div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row pb-3">
                                                            <div class="col-sm-8 col-md-6 col-lg-6 col-xl-2 pb-2">
                                                                <strong> Package Type :</strong>
                                                            </div>
                                                            <div class="col-sm-4 col-md-6 col-lg-6 col-xl-5">
                                                                {{$package->type}}
                                                            </div>
                                                        </div>
                                                        <div class="row pb-3">
                                                            <div class="col-sm-8 col-md-6 col-lg-6 col-xl-2 pb-2">
                                                                <strong> Package For :</strong>
                                                            </div>
                                                            <div class="col-sm-4 col-md-6 col-lg-6 col-xl-5">
                                                                {{ucwords($package->package_for)}}
                                                            </div>
                                                        </div>
                                                        <div class="row pb-3">
                                                            <div class="col-sm-8 col-md-6 col-lg-6 col-xl-2 pb-2">
                                                                <strong> Package Duration :</strong>
                                                            </div>
                                                            <div class="col-sm-4 col-md-6 col-lg-6 col-xl-5">
                                                                {{ucwords($package->duration)}} month(s)
                                                            </div>
                                                        </div>
                                                        @if(isset($package_agency))
                                                            <div class="row pb-3">
                                                                <div class="col-sm-8 col-md-6 col-lg-6 col-xl-2 pb-2">
                                                                    <strong> Agency :</strong>
                                                                </div>
                                                                <div class="col-sm-4 col-md-6 col-lg-6 col-xl-5">
                                                                    @php $agency_name = \App\Models\Agency::getAgencyTitle($package_agency->agency_id);  @endphp
                                                                    {{ $agency_name}} - {{ $package_agency->agency_id}}
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="row pb-3">
                                                            <div class="col-sm-8 col-md-6 col-lg-6 col-xl-2 pb-2">
                                                                <strong> Total Properties :</strong>
                                                            </div>
                                                            <div class="col-sm-4 col-md-6 col-lg-6 col-xl-5">
                                                                {{$package->property_count}}
                                                            </div>
                                                        </div>
                                                        <div class="row pb-3">
                                                            <div class="col-sm-8 col-md-6 col-lg-6 col-xl-2 pb-2">
                                                                <strong> Added Properties :</strong>
                                                            </div>
                                                            <div class="col-sm-4 col-md-6 col-lg-6 col-xl-5">
                                                                @if(isset($pack_properties))
                                                                    {{count($pack_properties)}}
                                                                @else
                                                                    0
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row pb-3">
                                                            <div class="col-sm-8 col-md-6 col-lg-6 col-xl-2 pb-2">
                                                                <strong> Remaining Properties :</strong>
                                                            </div>
                                                            <div class="col-sm-4 col-md-6 col-lg-6 col-xl-5">
                                                                @if(isset($pack_properties))
                                                                    @php $remaining_count = $package->property_count - count($pack_properties)  @endphp
                                                                    {{$remaining_count}}
                                                                @else
                                                                    {{$package->property_count}}
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row pb-3">
                                                            <div class="col-sm-8 col-md-6 col-lg-6 col-xl-2 pb-2">
                                                                <strong> Package Activation Date: </strong>
                                                            </div>
                                                            <div class="col-sm-4 col-md-6 col-lg-6 col-xl-5">
                                                                {{ (new \Illuminate\Support\Carbon($package->activated_at))->isoFormat('DD-MM-YYYY  h:mm a') }}
                                                            </div>
                                                        </div>
                                                        <div class="row pb-3">
                                                            <div class="col-sm-8 col-md-6 col-lg-6 col-xl-2 pb-2">
                                                                <strong> Package Expiry Date: </strong>
                                                            </div>
                                                            <div class="col-sm-4 col-md-6 col-lg-6 col-xl-5">
                                                                {{ (new \Illuminate\Support\Carbon($package->expired_at))->isoFormat('DD-MM-YYYY  h:mm a') }}
                                                                {{--                                                                <div class="badge badge-success p-2">--}}
                                                                @if(str_contains ( (new \Illuminate\Support\Carbon($package->expired_at))->diffForHumans(['parts' => 1]), 'ago' ))
                                                                    <strong
                                                                        class="font-12" style="color: orangered">
                                                                        Expired {{(new \Illuminate\Support\Carbon($package->expired_at))->diffForHumans(['parts' => 1])}}</strong>
                                                                @else
                                                                    <strong
                                                                        class="font-12" style="color: green"> Will Expire in
                                                                         {{(new \Illuminate\Support\Carbon($package->expired_at))->diffForHumans(['parts' => 1])}}</strong>
                                                                @endif
                                                                {{--                                                                </div>--}}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="card">
                                                    <div class="card-header theme-blue text-white">
                                                        Property Listings <span class="spinner-border" role="status" aria-hidden="true" id="loader-property-log"></span>
                                                    </div>
                                                    <div class="card-body" style="display: none" id="property-log-block">
                                                        <table id="property-log" class="display" style="width: 100%">

                                                            <thead>
                                                            <tr>
                                                                <td>ID</td>
                                                                <td>Duration (Days)</td>
                                                                <td>Activation Date</td>
                                                                <td>Expiry Date</td>

                                                            </tr>
                                                            </thead>
                                                            <tbody id="tbody-property-logs">

                                                            </tbody>
                                                        </table>
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

@endsection

@section('script')
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>

    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script>
        (function ($) {
            $(document).ready(function () {
                $.get('/admin/get-package-property', {'id': {{$package->id}} }, // url
                    function (data, textStatus, jqXHR) {  // success callback
                        $('#loader-property-log').hide();
                        $('#property-log-block').slideDown();
                        $('#tbody-property-logs').html(data.view);

                        $('#property-log').DataTable({
                            "scrollX": true,
                            "ordering": false,
                            responsive: true
                        });
                    }
                );

            })
        })
        (jQuery);
    </script>
@endsection
