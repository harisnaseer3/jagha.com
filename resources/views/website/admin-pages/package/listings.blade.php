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
                                                <div class="float-right"><span class="pull-right"><a class="btn btn-sm transition-background color-green mr-2" href="/"><i
                                                                class="fa fa-globe mr-1"></i>Go to property.aboutpakistan.com</a></span>
                                                </div>
                                                <div class="tab-pane fade active show" id="listings-all" role="tabpanel"
                                                     aria-labelledby="listings-all-tab">
                                                    <h6>Packages</h6>

                                                    <div class="my-4">
                                                        <div class="card my-4">
                                                            <div class="card-header theme-blue text-white">
                                                                <div class="font-14 font-weight-bold text-white">Packages Summery</div>
                                                            </div>
                                                            <div class="card-body">
                                                                {{--                                                                <div class="text-center">--}}
                                                                <h4>Packages Meta</h4>
{{--                                                                <div class="container">--}}
                                                                    <table class="table table-bordered" style="width:50%">
                                                                        <tr>
                                                                            <td style="width: 50%">Total Packages</td>
                                                                            <td class="text-center font-weight-bold">{{$total}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 50%">Active Packages Count</td>
                                                                            <td class="text-center font-weight-bold">{{$active}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 50%">Complementary Active Package</td>
                                                                            <td class="text-center font-weight-bold">{{$complementary}} </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 50%">Purchased Active Package</td>
                                                                            <td class="text-center font-weight-bold"> {{$purchased}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 50%">Platinum Active Package</td>
                                                                            <td class="text-center font-weight-bold">{{$platinum}} </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 50%">Gold Active Package</td>
                                                                            <td class="text-center font-weight-bold"> {{$gold}} </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>

                                                                {{--                                                                </div>--}}
{{--                                                            </div>--}}
                                                        </div>
                                                    </div>
                                                    {{--                                                    @if($sub_packages)--}}
                                                    {{--                                                        <div class="my-4">--}}
                                                    {{--                                                            <div class="card my-4">--}}
                                                    {{--                                                                <div class="card-header theme-blue text-white">--}}
                                                    {{--                                                                    <div class="font-14 font-weight-bold text-white">Active Packages</div>--}}
                                                    {{--                                                                </div>--}}
                                                    {{--                                                                <div class="card-body">--}}
                                                    {{--                                                                    <table class="display sub-table" style="width: 100%">--}}
                                                    {{--                                                                        <thead>--}}
                                                    {{--                                                                        <tr>--}}
                                                    {{--                                                                            <th>#</th>--}}
                                                    {{--                                                                            <th>Type</th>--}}
                                                    {{--                                                                            <th>Duration in Months</th>--}}
                                                    {{--                                                                            <th>Package For</th>--}}
                                                    {{--                                                                            <th>Properties Count</th>--}}
                                                    {{--                                                                            <th>Added Properties Count</th>--}}
                                                    {{--                                                                            <th>Activated At</th>--}}
                                                    {{--                                                                            <th>Status</th>--}}
                                                    {{--                                                                            <th>Action</th>--}}
                                                    {{--                                                                        </tr>--}}
                                                    {{--                                                                        </thead>--}}
                                                    {{--                                                                        <tbody>--}}
                                                    {{--                                                                        @foreach($sub_packages as $index=>$sub_package)--}}
                                                    {{--                                                                            <tr>--}}
                                                    {{--                                                                                <td>{{$index +1 }}</td>--}}
                                                    {{--                                                                                <td>{{$sub_package->type}}</td>--}}
                                                    {{--                                                                                <td>{{$sub_package->duration}}</td>--}}
                                                    {{--                                                                                <td>--}}
                                                    {{--                                                                                    @if(isset($sub_package->agency_id))--}}
                                                    {{--                                                                                        {{\App\Models\Agency::getAgencyTitle($sub_package->agency_id)}} - {{$sub_package->agency_id}}--}}
                                                    {{--                                                                                    @else--}}
                                                    {{--                                                                                        {{ucwords($sub_package->package_for)}}--}}
                                                    {{--                                                                                    @endif--}}
                                                    {{--                                                                                </td>--}}
                                                    {{--                                                                                <td class="text-center">{{$sub_package->property_count}}</td>--}}
                                                    {{--                                                                                <td class="text-center">{{$sub_package->added_properties}}</td>--}}
                                                    {{--                                                                                <td>{{ (new \Illuminate\Support\Carbon($sub_package->activated_at))->isoFormat('DD-MM-YYYY  h:mm a')}} </td>--}}
                                                    {{--                                                                                <td>--}}
                                                    {{--                                                                                    <div class="badge badge-success p-2 "><strong class="font-12 color-white">{{ucwords($sub_package->status)}}</strong>--}}
                                                    {{--                                                                                    </div>--}}
                                                    {{--                                                                                </td>--}}
                                                    {{--                                                                                <td>--}}
                                                    {{--                                                                                    --}}{{--                                                                            <div class='btn-group'>--}}
                                                    {{--                                                                                    <a type="button"--}}
                                                    {{--                                                                                       href="{{route('admin.package.show', $sub_package->id)}}"--}}
                                                    {{--                                                                                       class="btn btn-sm btn-success mb-1"--}}
                                                    {{--                                                                                       data-toggle-1="tooltip"--}}
                                                    {{--                                                                                       data-placement="bottom" title="View Package">--}}
                                                    {{--                                                                                        <i class="fas fa-eye"></i><span class="sr-only sr-only-focusable" aria-hidden="true">View Package</span>--}}
                                                    {{--                                                                                    </a>--}}

                                                    {{--                                                                                    --}}{{--                                                                                    <a style="color: black" class="btn-sm btn btn-danger mb-1" data-record-id="{{$sub_package->id}}"  title="Delete Package"--}}
                                                    {{--                                                                                    --}}{{--                                                                                       data-toggle="modal" data-target="#package-modal">--}}
                                                    {{--                                                                                    --}}{{--                                                                                        <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>--}}
                                                    {{--                                                                                    --}}{{--                                                                                    </a>--}}

                                                    {{--                                                                                </td>--}}
                                                    {{--                                                                            </tr>--}}
                                                    {{--                                                                        @endforeach--}}
                                                    {{--                                                                        </tbody>--}}
                                                    {{--                                                                    </table>--}}

                                                    {{--                                                                </div>--}}
                                                    {{--                                                            </div>--}}
                                                    {{--                                                        </div>--}}
                                                    {{--                                                    @endif--}}

                                                    {{--                                                    <div class="my-4">--}}
                                                    {{--                                                        <div class="card my-4">--}}
                                                    {{--                                                            <div class="card-header theme-blue text-white">--}}
                                                    {{--                                                                <div class="font-14 font-weight-bold text-white">Requested Packages</div>--}}
                                                    {{--                                                            </div>--}}
                                                    {{--                                                            <div class="card-body">--}}

                                                    {{--                                                                <table class="display req-table" style="width: 100%">--}}
                                                    {{--                                                                    <thead>--}}
                                                    {{--                                                                    <tr>--}}
                                                    {{--                                                                        <th>#</th>--}}
                                                    {{--                                                                        <th>Type</th>--}}
                                                    {{--                                                                        <th>Duration in Months</th>--}}
                                                    {{--                                                                        <th>Package For</th>--}}
                                                    {{--                                                                        <th>Properties Count</th>--}}
                                                    {{--                                                                        <th>Requested At</th>--}}
                                                    {{--                                                                        <th>Status</th>--}}
                                                    {{--                                                                        <th>Action</th>--}}
                                                    {{--                                                                    </tr>--}}
                                                    {{--                                                                    </thead>--}}
                                                    {{--                                                                    <tbody>--}}
                                                    {{--                                                                    @foreach($req_packages as $index=>$package)--}}
                                                    {{--                                                                        <tr>--}}
                                                    {{--                                                                            <td>{{$index + 1 }}</td>--}}
                                                    {{--                                                                            <td>{{ucwords($package->type)}}</td>--}}
                                                    {{--                                                                            <td class="text-right pr-3">{{ucwords($package->duration)}}</td>--}}
                                                    {{--                                                                            <td>--}}
                                                    {{--                                                                                @if(isset($package->agency_id))--}}
                                                    {{--                                                                                    {{\App\Models\Agency::getAgencyTitle($package->agency_id) . ' - '.$package->agency_id}}--}}
                                                    {{--                                                                                @else--}}
                                                    {{--                                                                                    {{ucwords($package->package_for)}}--}}
                                                    {{--                                                                                @endif</td>--}}
                                                    {{--                                                                            <td class="text-right pr-3">{{ucwords($package->property_count)}}</td>--}}
                                                    {{--                                                                            <td>--}}
                                                    {{--                                                                                {{ (new \Illuminate\Support\Carbon($package->created_at))->isoFormat('DD-MM-YYYY  h:mm a')}}--}}

                                                    {{--                                                                            </td>--}}
                                                    {{--                                                                            <td>--}}
                                                    {{--                                                                                @if($package->status == 'deleted')--}}
                                                    {{--                                                                                    <div class="badge badge-danger p-2 "><strong class="font-12 color-white">{{ucwords($package->status)}}</strong>--}}
                                                    {{--                                                                                    </div>--}}
                                                    {{--                                                                                @else--}}
                                                    {{--                                                                                    <div class="badge badge-warning p-2 "><strong class="font-12">{{ucwords($package->status)}}</strong>--}}
                                                    {{--                                                                                    </div>--}}
                                                    {{--                                                                                @endif--}}

                                                    {{--                                                                            </td>--}}
                                                    {{--                                                                            <td>--}}
                                                    {{--                                                                                @if($package->status != 'deleted')--}}
                                                    {{--                                                                                    <a type="button"--}}
                                                    {{--                                                                                       href="{{route('admin.package.edit', $package->id)}}"--}}
                                                    {{--                                                                                       class="btn btn-sm btn-info mb-1"--}}
                                                    {{--                                                                                       data-toggle-1="tooltip"--}}
                                                    {{--                                                                                       data-placement="bottom" title="Verify & Activate">--}}
                                                    {{--                                                                                        Verify & Activate--}}
                                                    {{--                                                                                    </a>--}}
                                                    {{--                                                                                    <div class='btn-group'>--}}
                                                    {{--                                                                                        <a style="color: black" class="btn-sm btn btn-danger" data-record-id="{{$package->id}}" title="Delete Package"--}}
                                                    {{--                                                                                           data-toggle="modal"--}}
                                                    {{--                                                                                           data-target="#package-modal"><i class="fas fa-trash"></i><span class="sr-only sr-only-focusable"--}}
                                                    {{--                                                                                                                                                          aria-hidden="true">Delete</span></a>--}}
                                                    {{--                                                                                    </div>--}}
                                                    {{--                                                                                @endif--}}
                                                    {{--                                                                            </td>--}}
                                                    {{--                                                                        </tr>--}}
                                                    {{--                                                                    @endforeach--}}
                                                    {{--                                                                    </tbody>--}}
                                                    {{--                                                                </table>--}}

                                                    {{--                                                            </div>--}}
                                                    {{--                                                        </div>--}}
                                                    {{--                                                    </div>--}}
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
    {{--    @include('website.includes.footer')--}}
    @include('website.admin-pages.layouts.package-delete-modal', array('route'=>'admin.package'))


@endsection

@section('script')
    {{--    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>--}}
    {{--    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>--}}
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script src="{{asset('website/js/admin-package-listings.js')}}"></script>
@endsection
