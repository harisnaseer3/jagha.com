@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')
    <div id="site" class="left relative">
        <div id="site-wrap" class="left relative">
            @include('website.admin-pages.includes.admin-nav')
            <section class="content-header admin-margin">
            </section>
            <div class="content">
                <div class="clearfix"></div>
                <div class="alert-container mx-5">
                    @include('website.layouts.flash-message')
                </div>
                <div class="clearfix"></div>
                <div class="row mx-4 mt-2">
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header theme-blue text-white">
                                Registered User
                            </div>
                            <div class="card-body">
                                <table id="reg_users" class="display" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>Sr.</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>Community Nick</th>
                                        <th>{{ __('E-Mail Address') }}</th>
                                        <th>Phone</th>
                                        <th>Country</th>
                                        <th>Address</th>

                                        <th>{{ __('Status') }}</th>
                                        <th>Action</th>
                                        {{--                                <th>Action</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($register_users) === 0)
                                        <tr>
                                            <td colspan="6">No Users Found</td>
                                        </tr>
                                    @else
                                        @foreach($register_users as $user)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->community_nick}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{str_replace('-','',$user->cell)}}</td>
                                                <td>{{$user->country}}</td>
                                                <td>{{$user->address}}</td>


                                                <td>@if($user->is_active === '1') Active @else Inactive @endif</td>
                                                <td>

                                                    {!! Form::open(['route' => ['admins.destroy-user', $user->id], 'method' => 'delete']) !!}
                                                    @if($user->is_active === '0')
                                                        <div class='btn-group'>
                                                            {!! Form::button('Activate', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'onclick' => 'return confirm("'.__('Are you sure you want to activate user account?').'")']) !!}
                                                        </div>
                                                    @elseif($user->is_active === '1')
                                                        <div class='btn-group'>
                                                            {!! Form::button('Deactivate', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("'.__('Are you sure you want to deactivate user account?').'")']) !!}
                                                        </div>
                                                    @endif
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header theme-blue text-white">
                                User logs
                            </div>
                            <div class="card-body">
                                <table id="user-log" class="display" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>Sr.</th>
                                        <th>User ID</th>
                                        <th>Email</th>
                                        <th>IP Address</th>
                                        <th>IP Location</th>
                                        <th>City</th>
                                        <th>Operating System</th>
                                        <th>Browser</th>
                                        <th>LoggedIn_at</th>
                                        <th>LoggedOut_at</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($users) === 0)
                                        <tr>
                                            <td colspan="6">No Users Found</td>
                                        </tr>
                                    @else
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$user->user_id}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{$user->ip}}</td>
                                                <td>{{$user->ip_location}}</td>
                                                <td>{{$user->city}}</td>
                                                <td>{{$user->os}}</td>
                                                <td>{{$user->browser}}</td>
                                                <td>{{ (new \Illuminate\Support\Carbon($user->created_at))->isoFormat('DD-MM-YYYY, h:mm a') }}</td>

                                                @if($user->logout_at !== null)
                                                    <td>{{ (new \Illuminate\Support\Carbon($user->logout_at))->isoFormat('DD-MM-YYYY, h:mm a') }}</td>
                                                @elseif(now() > \Illuminate\Support\Carbon::parse($user->created_at)->addHours(2))
                                                    <td><span class="badge-danger p-1">Session Expired</span></td>
                                                @else
                                                    <td><span class="badge-success p-1">Connected</span></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
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
        (function ($) {
            $(document).ready(function () {

                $('#reg_users').DataTable({
                    "scrollX": true,
                    "ordering": false,
                    responsive: true
                });
                $('#user-log').DataTable({
                    "scrollX": true,
                    "ordering": false,
                    responsive: true
                });

            });
        })
        (jQuery);</script>
@endsection
