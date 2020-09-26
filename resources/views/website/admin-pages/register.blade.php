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

    <div class="content" lang="{{ app()->getLocale() }}" {{ app()->getLocale() === 'ar' ? 'dir=rtl style=text-align:right;' : '' }}>
        <div class="clearfix"></div>
        <div class="alert-container"></div>
        <div class="clearfix"></div>

        <div class="card mx-4 mt-4 ">
            <div class="card-header">Add Admin</div>

            <div class="card-body">
                <form method="POST" action=""
                      aria-label="{{ __('Register') }}">
                    @csrf
                    <div class="form-group row" id="admin_role">
                        <div class="col-md-6">
                            {!! Form::label('role', __('Role') ) !!} <span class="text-danger">*</span>
                            <select name="role" class="form-control form-control-sm select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="select-admin-role">
                                <option value selected disabled>@lang('models/user_management.select_role')</option>
                                @foreach($roles as $role)
                                    @if($role->name !== 'super-admin')
                                    <option value="{{$role->name}}"> @if(app()->getLocale() === 'ar') {{$role->name_ar}} @else {{$role->name_en}}  @endif</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            {!! Form::label('name', __('Name') ) !!} <span class="text-danger">*</span>
                        </div>
                        <div class="col-md-6">
                            <input id="name" type="text"
                                   class="form-control form-control-sm @error('name') is-invalid @enderror" name="name"
                                   value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div id="nameHelp" class="form-text text-gray">{{ __('crud.for_example') }} {{ __('models/user_management.sample_name') }}</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            {!! Form::label('email', __('E-Mail Address') ) !!} <span class="text-danger">*</span>
                        </div>
                        <div class="col-md-6">

                            <input id="email" type="email"
                                   class="form-control form-control-sm @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div id="emailHelp" class="form-text text-gray">{{ __('crud.for_example') }} {{ __('models/user_management.sample_email') }}</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            {!! Form::label('password', __('Password') ) !!} <span class="text-danger">*</span>
                        </div>
                        <div class="col-md-6">
                            <input id="password" type="password"
                                   class="form-control form-control-sm @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div id="passwordHelp" class="form-text text-gray">{{ __('models/user_management.sample_password') }}</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            {!! Form::label('password-confirm', __('Confirm Password') ) !!} <span
                                class="text-danger">*</span>
                            <input id="password-confirm" type="password" class="form-control form-control-sm"
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                            <a href="{{ route('admin.manage-users')}}"
                               class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page_modal')

@endsection

@section('page_script')
@endsection

