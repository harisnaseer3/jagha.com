@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>Jagha - Buy Sell Rent Homes & Properties In Pakistan by https://www.jagha.com</title>
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


            <div class="card-header">Create Facebook Post</div>
            <div class="card-body">
                @include('website.layouts.flash-message')
                <form method="POST" action="{{route('admin.facebook.store')}}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12">
                            {!! Form::label('Property ID', __('Property ID') ) !!} <span class="text-danger">*</span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <input id="id" type="number" class="form-control form-control-sm"  name="id">
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            @error('id')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror

                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" id="submit-button">
                                Post
                            </button>
                            <a href="{{ route('admin.facebook.create')}}"
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
            // $(document).ready(function () {
            //
            //     $('.admin_role').change(function() {
            //         if ($('input[name="role[]"]:checked').length > 0) {
            //             $('#submit-button').prop('disabled', false);
            //         }
            //         else {
            //             $('#submit-button').prop('disabled', true);
            //
            //         }
            //     });
            //
            // });
        })(jQuery);
    </script>

@endsection
