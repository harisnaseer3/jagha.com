@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Property Management By https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')
    <div id="site" class="left relative" >
        <div id="site-wrap" class="left relative" >
    @include('website.admin-pages.includes.admin-nav')
    <section class="content-header">
{{--        <h1 class="ml-5">--}}
{{--            <a class="btn btn-primary" href="{{route('admin.show-register-form')}}">Add Admin</a>--}}
{{--        </h1>--}}
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="alert-container mx-5">
            @include('website.layouts.flash-message')
        </div>
        <div class="clearfix"></div>
        <div class="row mx-4 mt-2">

            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card card-primary mt-3">
                    <div class="card-header">Manage Users
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-responsive-sm" id="users-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Name') }}</th>
                                <th>Community Nick</th>
                                <th>{{ __('E-Mail Address') }}</th>
                                <th>Phone</th>
                                <th>Country</th>
                                <th>Address</th>

                                <th>{{ __('Status') }}</th>
{{--                                <th>Action</th>--}}
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
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->community_nick}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->country}}</td>
                                        <td>{{$user->address}}</td>


                                        <td>@if($user->is_active === '1') Active @else Inactive @endif</td>
{{--                                        <td>--}}

{{--                                        </td>--}}
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

@endsection
