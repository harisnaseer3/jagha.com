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
    @include('website.admin-pages.includes.admin-nav')
    <section class="content-header">
    </section>

    <div class="content">
        <div class="clearfix"></div>

        <div class="card mx-4 admin-margin">
            <div class="card-header">Update Admin Roles</div>
            <div class="card-body">
                <form method="POST" action="{{route('admins.update')}}">
                    @csrf
                    <input type="hidden" name="id" value="{{$admin->id}}">
                    <div class="form-group row">
                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12">
                            {!! Form::label('email', __('E-Mail Address') ) !!} <span class="text-danger">*</span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">

                            <input id="email" type="email" class="form-control form-control-sm" readonly name="email" value="{{$admin->email}}"
                                   autocomplete="email">
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        </div>
                    </div>
                    <div class="form-group row" id="admin_role">
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            {!! Form::label('role', __('Role') ) !!} <span class="text-danger">*</span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">

                            @foreach($roles as $role)
                                @if($role->name !== 'Super Admin')
                                    <label class="checkbox-inline ml-2">
                                        <input type="checkbox" class="admin_role" name="role[]" @error('role') is-invalid @enderror value="{{$role->name}}" @if(in_array($role->name, $admin_roles)) checked @endif> {{$role->name}}
                                    </label>
                                @endif
                            @endforeach

                        </div>
                        @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mt-2 mb-2"><span style="color:red">* Please select atleast one role to enable update option. </span></div>
                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" id="submit-button">
                                Update
                            </button>
                            <a href="{{ route('admin.manage-admins')}}"
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

@section('script')
    <script>
        (function ($) {
            $(document).ready(function () {

                $('.admin_role').change(function() {
                    if ($('input[name="role[]"]:checked').length > 0) {
                        $('#submit-button').prop('disabled', false);
                    }
                    else {
                        $('#submit-button').prop('disabled', true);

                    }
                });

            });
        })(jQuery);
    </script>

@endsection
