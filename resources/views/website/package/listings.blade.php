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
    @include('website.includes.dashboard-nav')
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>Packages Listing</h1>
            </div>
        </div>
    </div>
    <!-- Submit Property start -->
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" role="tabpanel">
                            <div class="row my-4">
                                <div class="col-md-3">
                                    @include('website.package.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.flash-message')
                                    <div class="tab-content" id="listings-tabContent">
                                        <div class="float-right">
                                               <span class="pull-right"><a class="btn btn-sm theme-blue text-white mr-2" href="/"><i
                                                           class="fa fa-globe mr-1"></i>Go to property.aboutpakistan.com</a></span>
                                        </div>

                                        <div class="tab-pane fade active show" id="listings-all" role="tabpanel"
                                             aria-labelledby="listings-all-tab">
                                            <h6>Packages Listings</h6>
                                            @if($sub_packages)
                                                <div class="my-4">
                                                    <div class="card my-4">
                                                        <div class="card-header theme-blue text-white">
                                                            <div class="font-14 font-weight-bold text-white">Subscribed Packages</div>
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="display sub-table" style="width: 100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Type</th>
                                                                    <th>Duration</th>
                                                                    <th>Package For</th>
                                                                    <th>Properties Count</th>
                                                                    <th>Added Properties Count</th>
                                                                    <th>Package Activation</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($sub_packages as $index=>$sub_package)
                                                                    <tr>
                                                                        <td>{{$index +1 }}</td>
                                                                        <td>{{$sub_package->type}}</td>
                                                                        <td>{{$sub_package->duration}}</td>
                                                                        <td>
                                                                            @if(isset($sub_package->agency_id))
                                                                                {{\App\Models\Agency::getAgencyTitle($sub_package->agency_id)}} - {{$sub_package->agency_id}}
                                                                            @else
                                                                                {{ucwords($sub_package->package_for)}}
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-right pr-3">{{$sub_package->property_count}}</td>
                                                                        <td class="text-right pr-3">{{$sub_package->added_properties}}</td>
                                                                        <td>{{ (new \Illuminate\Support\Carbon($sub_package->activated_at))->isoFormat('DD-MM-YYYY  h:mm a')}}</td>
                                                                        <td>
                                                                            <div class="badge badge-success p-2 "><strong class="font-12 color-white">{{ucwords($sub_package->status)}}</strong>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            {{--                                                                            <div class='btn-group'>--}}
                                                                            <a type="button"
                                                                               href="{{route('package.add.properties', $sub_package->id)}}"
                                                                               class="btn btn-sm btn-success mb-1"
                                                                               data-toggle-1="tooltip"
                                                                               data-placement="bottom" title="Add Properties">
                                                                                <i class="fas fa-plus"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Add Properties</span>
                                                                            </a>

                                                                            {{--                                                                            <a style="color: black" class="btn-sm btn btn-danger mb-1" data-record-id="{{$sub_package->id}}"--}}
                                                                            {{--                                                                               data-toggle="modal" data-target="#package-modal">--}}
                                                                            {{--                                                                                <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>--}}
                                                                            {{--                                                                            </a>--}}

                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="my-4">
                                                <div class="card my-4">
                                                    <div class="card-header theme-blue text-white">
                                                        <div class="font-14 font-weight-bold text-white">Requested Packages</div>
                                                    </div>
                                                    <div class="card-body">

                                                        <table class="display req-table" style="width: 100%">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Type</th>
                                                                <th>Duration in Months</th>
                                                                <th>Package For</th>
                                                                <th>Properties Count</th>
                                                                <th>Requested At</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($req_packages as $index=>$package)
                                                                <tr>
                                                                    <td>{{$index +1 }}</td>
                                                                    <td>{{ucwords($package->type)}}</td>
                                                                    <td class="text-right pr-3">{{ucwords($package->duration)}}</td>
                                                                    <td>
                                                                        @if(isset($package->agency_id))
                                                                            {{\App\Models\Agency::getAgencyTitle($package->agency_id) . ' - '.$package->agency_id}}
                                                                        @else
                                                                            {{ucwords($package->package_for)}}
                                                                        @endif</td>
                                                                    <td class="text-right pr-3">{{ucwords($package->property_count)}}</td>
                                                                    <td>
                                                                        {{ (new \Illuminate\Support\Carbon($package->created_at))->isoFormat('DD-MM-YYYY  h:mm a')}}
                                                                    </td>
                                                                    <td>
                                                                        @if($package->status == 'deleted')
                                                                            <div class="badge badge-danger p-2 "><strong class="font-12 color-white">{{ucwords($package->status)}}</strong>
                                                                            </div>
                                                                        @else
                                                                            <div class="badge badge-warning p-2 "><strong class="font-12">{{ucwords($package->status)}}</strong>
                                                                            </div>
                                                                        @endif

                                                                    </td>
                                                                    <td>
                                                                        @if($package->status != 'deleted')
                                                                            <div class='btn-group'>
                                                                                <a style="color: black" class="btn-sm btn btn-danger" data-record-id="{{$package->id}}"
                                                                                   data-toggle="modal"
                                                                                   data-target="#package-modal"><i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span></a>
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
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

    <!-- Footer start -->
    @include('website.includes.footer')
    @include('website.layouts.package-delete-modal', array('route'=>'package'))


@endsection

@section('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>

    <script src="{{asset('website/js/package-form.js')}}"></script>
@endsection
