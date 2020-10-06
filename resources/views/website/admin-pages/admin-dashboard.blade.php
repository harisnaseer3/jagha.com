@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Property Management By https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">

@endsection

@section('content')
    @include('website.admin-pages.includes.admin-nav')

    <!-- Submit Property start -->
    <div class="row">
        <div class="col-md-12">
            <div class="tab-content" id="ListingsTabContent">
                <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                    <div class="m-4">

{{--                        <div class="row">--}}
{{--                            <div class="col-sm-6 col-md-6 col-lg-3">--}}
{{--                                <a href="{{route('properties.listings',['active','all',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),'id','asc','1'])}}">--}}
{{--                                    <div class="info-box">--}}
{{--                                        <span class="info-box-icon bg-success"><i class="fas fa-home"></i></span>--}}
{{--                                        <div class="info-box-content">--}}
{{--                                            <span class="info-box-text"> Active Properties</span>--}}
{{--                                            <span class="info-box-number"></span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-6 col-md-6 col-lg-3">--}}
{{--                                <a href="{{route('properties.listings',['pending','all',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),'id','asc','1'])}}">--}}
{{--                                    <div class="info-box">--}}
{{--                                        <span class="info-box-icon bg-warning"><i class="fas fa-home"></i></span>--}}
{{--                                        <div class="info-box-content">--}}
{{--                                            <span class="info-box-text"> Pending Properties</span>--}}
{{--                                            <span class="info-box-number"></span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-6 col-md-6 col-lg-3">--}}
{{--                                <a href="{{route('properties.listings',['deleted','all',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),'id','asc','1'])}}">--}}
{{--                                    <div class="info-box">--}}
{{--                                        <span class="info-box-icon bg-danger"><i class="fas fa-home"></i></span>--}}
{{--                                        <div class="info-box-content">--}}
{{--                                            <span class="info-box-text"> Deleted Properties</span>--}}
{{--                                            <span class="info-box-number"></span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-6 col-md-6 col-lg-3">--}}
{{--                                <a href="{{route('agencies.listings',['verified_agencies','all',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),'id','asc','1'])}}">--}}
{{--                                    <div class="info-box">--}}
{{--                                        <span class="info-box-icon bg-info"><i class="fas fa-home"></i></span>--}}
{{--                                        <div class="info-box-content">--}}
{{--                                            <span class="info-box-text"> Total Agencies</span>--}}
{{--                                            <span class="info-box-number"></span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="row">
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="team-1">
                                    <div class="team-photo">
                                        @if(isset($admin->image) && $admin->image != null)
                                            <img src="{{ asset('thumbnails/user_images/'.explode('.',$admin->image)[0].'-450x350.webp')}}"
                                                 alt="{{$admin->name}}" title="{{$admin->name}}" class="img-fluid image-padding rounded-circle" aria-label="user photo">
                                        @else
                                            <img src="{{asset('img/logo/profile.png')}}"
                                                 alt="{{$admin->name}}" title="{{$admin->name}}" class="img-fluid image-padding rounded-circle" aria-label="user photo">
                                        @endif
                                    </div>
                                    <div class="team-details">
                                        @if(count($admin->roles) > 0)
                                            <h6 class="proper-case">{{ucwords($admin->roles[0]->name)}}</h6>
                                        @endif
                                        <h5><a href="#">{{ucwords($admin->name)}}</a></h5>
                                        <div class="contact">
                                            <p class="m-0">
                                                <a href="mailto:info@themevessel.com"><i class="fa fa-envelope-o mr-1"></i> {{$admin->email}}</a>
                                            </p>
                                            @if($admin->cell !== null)
                                                <p class="m-0">
                                                    <a href="tel:+554XX-634-7071"> <i class="fa fa-phone mr-1"></i>{{$admin->cell}}</a>
                                                </p>
                                            @endif
                                            @if($admin->phone !== null)
                                                <p class="m-0">
                                                    <a href="#"><i class="fa fa-phone mr-1"></i>{{$admin->phone}}</a>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-8 col-sm-6">
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="card">
                                            <div class="card-header theme-blue text-white">
                                              Property Log
                                            </div>
                                            <div class="card-body">

                                        <table id="property-log" class="display" style="width: 100%">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Admin ID</th>
                                                <th>Name</th>
                                                <th>Property ID</th>
                                                <th>Status</th>
                                                <th>Rejection Reason</th>
                                                <th>Date/Time</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($property_log as $property)
                                                <tr>
                                                    <td>{{$property->id}}</td>
                                                    <td>{{$property->admin_id}}</td>
                                                    <td>{{ucwords($property->admin_name)}}</td>
                                                    <td>{{$property->property_id}}</td>
                                                    <td>{{ucwords($property->status)}}</td>
                                                    <td>{{$property->rejection_reason}}</td>
                                                    <td>{{ (new \Illuminate\Support\Carbon($property->created_at))->format('Y-m-d') }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header theme-blue text-white">
                                            Agency Log
                                            </div>
                                            <div class="card-body">
                                                <table id="agency-log" class="display" style="width: 100%">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Admin ID</th>
                                                        <th>Name</th>
                                                        <th>Agency ID</th>
                                                        <th>Status</th>
                                                        <th>Rejection Reason</th>
                                                        <th>Date/Time</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($agency_log as $agency)
                                                        <tr>
                                                            <td>{{$agency->id}}</td>
                                                            <td>{{$agency->admin_id}}</td>
                                                            <td>{{ucwords($agency->admin_name)}}</td>
                                                            <td>{{$agency->property_id}}</td>
                                                            <td>{{ucwords($agency->status)}}</td>
                                                            <td>{{$agency->rejection_reason}}</td>
                                                            <td>{{ (new \Illuminate\Support\Carbon($agency->created_at))->format('Y-m-d') }}</td>
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


@endsection

@section('script')
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#property-log').DataTable();
            $('#agency-log').DataTable();
        });
    </script>
@endsection


