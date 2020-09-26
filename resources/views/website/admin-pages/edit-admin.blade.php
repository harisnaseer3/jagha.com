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

    </section>
    <div class="content">

        <div class="card card-default m-4">
            <div class= "card-header" >
                Update Admin
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::model($admin, ['route' => ['admins.update','admin' => $admin->id], 'method' => 'patch']) !!}

                        @include('website.admin-pages.includes.fields')

                        {!! Form::close() !!}

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_modal')

@endsection

@section('page_script')

@endsection
