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
    <section class="content-header admin-margin">
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
                                <th>Action</th>
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

        </div>
    </div>
        </div>
    </div>

@endsection

@section('script')

@endsection
