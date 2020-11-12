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
                <form method="POST" action="{{route('registration.submit')}}"
                      aria-label="{{ __('Register') }}">
                    @csrf
                    <div class="form-group row" id="admin_role">
                        <div class="col-md-6">
                            {!! Form::label('role', __('Role') ) !!} <span class="text-danger">*</span>

                                @foreach($roles as $role)
                                    @if($role->name !== 'Super Admin')
                                    <label class="checkbox-inline ml-2">
                                        <input type="checkbox" class="admin_role" name="role[]" value="{{$role->name}}"> {{$role->name}}
                                    </label>
                                    @endif
                                @endforeach

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
{{--                            <div id="emailHelp" class="form-text text-gray">{{ __('crud.for_example') }} {{ __('models/user_management.sample_email') }}</div>--}}
                        </div>
                    </div>




                    <div class="mt-2 mb-2"><span style="color:red">* Please select atleast one role to enable register option. </span></div>
                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" id="submit-button" disabled >
                                {{ __('Register') }}
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

