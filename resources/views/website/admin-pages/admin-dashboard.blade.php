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

        <!-- Submit Property start -->
            <div class="row admin-margin">
                <div class="col-md-12">
                    <div class="tab-content" id="ListingsTabContent">
                        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                            <div class="m-4">
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
                                                <h5>{{ucwords($admin->name)}}</h5>
                                                <div class="contact">
                                                    <p class="m-0">
                                                        <i class="fa fa-envelope-o mr-1"></i> {{$admin->email}}
                                                    </p>
                                                    @if($admin->cell !== null)
                                                        <p class="m-0">
                                                            <i class="fa fa-phone mr-1"></i>{{$admin->cell}}
                                                        </p>
                                                    @endif
                                                    @if($admin->phone !== null)
                                                        <p class="m-0">
                                                            <i class="fa fa-phone mr-1"></i>{{$admin->phone}}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-10 col-md-8 col-sm-6">
                                        <div class="row">
                                            <div class="col-2 mb-4">
                                                <button class="btn theme-blue color-white task-btn" id="execute-tasks">Execute Tasks</button>
                                            </div>
                                            <div class="col-10 mt-2"><i class="fa fa-spinner fa-spin " style="font-size:20px;display:none"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @can('Manage Users')
                                                <div class="col-12 mb-4">
                                                    <div class="card">
                                                        <div class="card-header theme-blue text-white">
                                                            Admins Session Log
                                                        </div>
                                                        <div class="card-body">
                                                            <table id="admin-log" class="display" style="width: 100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>Sr.</th>
                                                                    <th>Admin ID</th>
                                                                    <th>Email</th>
                                                                    <th>IP Address</th>
                                                                    <th>IP Location</th>
                                                                    <th>Operating System</th>
                                                                    <th>Browser</th>
                                                                    <th>LoggedIn_at</th>
                                                                    <th>LoggedOut_at</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($admin_log as $admin)
                                                                    <tr>
                                                                        <td>{{$admin->id}}</td>
                                                                        <td>{{$admin->admin_id}}</td>
                                                                        <td>{{$admin->email}}</td>
                                                                        <td>{{$admin->ip}}</td>
                                                                        <td>{{$admin->ip_location}}</td>
                                                                        <td>{{$admin->os}}</td>
                                                                        <td>{{$admin->browser}}</td>
                                                                        <td>{{ (new \Illuminate\Support\Carbon($admin->created_at))->isoFormat('DD-MM-YYYY, h:mm a') }}</td>
                                                                        @if($admin->logout_at !== null)
                                                                            <td>{{(new \Illuminate\Support\Carbon($admin->logout_at))->isoFormat('DD-MM-YYYY, h:mm a')  }}</td>

                                                                        @elseif(now() > \Illuminate\Support\Carbon::parse($admin->created_at)->addHours(2))
                                                                            <td><span class="badge-danger p-1">Session Expired</span></td>
                                                                        @else
                                                                            <td><span class="badge-success p-1">Connected</span></td>
                                                                        @endif
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan
                                            @can('Manage Property')
                                                <div class="col-12 mb-4">
                                                    <div class="card">
                                                        <div class="card-header theme-blue text-white">
                                                            Property Log
                                                        </div>
                                                        <div class="card-body">
                                                            <table id="property-log" class="display" style="width: 100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>Sr.</th>
                                                                    <th>Admin ID</th>
                                                                    <th>Name</th>
                                                                    <th>Property ID</th>
                                                                    <th>Property Title</th>
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
                                                                        <td>{{$property->property_title}}</td>
                                                                        <td>@if($property->status == 'active') Activated @else {{ucwords($property->status)}} @endif</td>
                                                                        <td>{{$property->rejection_reason}}</td>
                                                                        <td>{{ (new \Illuminate\Support\Carbon($property->created_at))->isoFormat('DD-MM-YYYY, h:mm a') }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan
                                            @can('Manage Agency')
                                                <div class="col-12 mb-4">
                                                    <div class="card">
                                                        <div class="card-header theme-blue text-white">
                                                            Agency Log
                                                        </div>
                                                        <div class="card-body">
                                                            <table id="agency-log" class="display" style="width: 100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>Sr.</th>
                                                                    <th>Admin ID</th>
                                                                    <th>Name</th>
                                                                    <th>Agency ID</th>
                                                                    <th>Agency Title</th>
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
                                                                        <td>{{$agency->agency_id}}</td>
                                                                        <td>{{$agency->agency_title}}</td>
                                                                        <td>{{ucwords($agency->status)}}</td>
                                                                        <td>{{$agency->rejection_reason}}</td>
                                                                        <td>{{ (new \Illuminate\Support\Carbon($agency->created_at))->isoFormat('DD-MM-YYYY, h:mm a') }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan
                                            @can('Manage Users')
                                                <div class="col-12 mb-4">
                                                    <canvas id="myChart" class="w-100" height="300px"></canvas>
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <div class="card">
                                                        <div class="card-header theme-blue text-white">
                                                            User Visit Log
                                                        </div>
                                                        <div class="card-body">
                                                            <table id="user-log" class="display" style="width: 100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>Sr.</th>
                                                                    <th>IP</th>
                                                                    <th>IP Location</th>
                                                                    <th>Date</th>
                                                                    <th>Visit Count</th>
                                                                    {{--                                                                    <th>Time</th>--}}
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($user_visit_log as $visit)
                                                                    <tr>
                                                                        <td>{{$visit->id}}</td>
                                                                        <td>{{$visit->ip}}</td>
                                                                        <td>{{$visit->ip_location}}</td>
                                                                        <td>{{$visit->date}}, {{ (new \Illuminate\Support\Carbon($visit->visit_time))->isoFormat('DD-MM-YYYY, h:mm a') }}</td>
                                                                        <td>{{$visit->count}}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan
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
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/chart.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/admin-dashboard-page.js')}}"></script>

@endsection


