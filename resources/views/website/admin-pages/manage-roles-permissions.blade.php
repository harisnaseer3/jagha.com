@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
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
        <h1 class="ml-5">
{{--            <a class="btn btn-primary" href="#">Add Role</a>--}}
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="alert-container mx-5">
            @include('website.layouts.flash-message')
        </div>
        <div class="clearfix"></div>
        <div class="row mx-4 mt-2">

            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">Manage Roles and Permissions
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>{{__('Role')}}</th>
                                <th>{{__('Admin')}}</th>
                                <th>{{__('Permission')}}</th>
{{--                                <th>{{__('Action')}}</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                @if($role->name !== 'super-admin')
                                    <?php $role_admins = $admin->getAdminsByRole($role->name);
                                    $permissions = $admin->getPermissionsByRole($role->name) ?>
                                    <tr>
                                        <td>{{$role->name}}</td>
                                        <td>
                                            <ul class="fa-ul">
                                                @forelse($role_admins as $key => $role_admin)
                                                    <li class="mb-2"><span class="fa-li"><i class="fas fa-user text-info"></i></span>{{ $role_admin }} <code>({{ $key }})</code></li>
                                                @empty
                                                    <li class="mb-2"><span class="fa-li"><i class="fas fa-ban text-danger"></i></span>{{__('Not Assigned')}}</li>
                                                @endforelse
                                            </ul>
                                        </td>
                                        <td>
                                            <ul class="fa-ul">
                                                @forelse($permissions as $permission)
                                                    <li class="mb-2"><span class="fa-li"><i class="fas fa-check-circle text-success"></i></span>{{$permission['name']}}</li>
                                                @empty
                                                    <li class="mb-2"><span class="fa-li"><i class="fas fa-ban text-danger"></i></span>{{__('Not Assigned')}}</li>
                                                @endforelse
                                            </ul>
                                        </td>
{{--                                        <td></td>--}}
                                    </tr>
                                @endif
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

@endsection

@section('script')

@endsection
