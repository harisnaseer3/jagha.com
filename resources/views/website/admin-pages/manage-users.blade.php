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
    @include('website.admin-pages.includes.admin-nav')
    <section class="content-header">
        <h1 class="ml-5">
            <a class="btn btn-primary" href="{{route('admin.show-register-form')}}">Add Admin</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="alert-container"></div>
        <div class="clearfix"></div>
        <div class="row mx-4 mt-2">

            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">Manage Admins
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-responsive-sm" id="admins-table" lang="{{ app()->getLocale() }}" {{ app()->getLocale() === 'ar' ? 'dir=rtl style=text-align:right;' : '' }}>
                            <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('E-Mail Address') }}</th>
                                <th>{{ __('Role') }}</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admins as $admin)
                                <tr>
                                    <td>{{$admin->name}}</td>
                                    <td>{{$admin->email}}</td>
                                    <td>
                                        @foreach($admin->roles as $admin_role)
                                         {{$admin_role->name}}
                                        @endforeach
                                    </td>
                                    <td>
{{--                                        {!! Form::open(['route' => ['admins.destroy',   app()->getLocale(),  $admin->id], 'method' => 'delete']) !!}--}}
                                        <div class='btn-group'>
                                            <a href="#" class='btn btn-warning btn-sm'><i class="fas fa-pen-alt"></i></a>
                                            {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("'.__('crud.are_you_sure').'")']) !!}
                                        </div>
{{--                                        {!! Form::close() !!}--}}
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

@endsection

@section('script')

@endsection
