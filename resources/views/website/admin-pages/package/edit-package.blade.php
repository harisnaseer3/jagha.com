@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">

@endsection

@section('content')
    <div id="site" class="left relative">
        <div id="site-wrap" class="left relative">
            @include('website.admin-pages.includes.admin-nav')
            <div style="min-height:90px"></div>
            <div class="submit-property">
                <div class="container-fluid container-padding">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" role="tabpanel">
                                    <div class="row my-4">
                                        <div class="col-md-3">
                                            @include('website.admin-pages.package.sidebar')
                                        </div>
                                        <div class="col-md-9">
                                            @include('website.layouts.flash-message')
                                            <div class="tab-content" id="listings-tabContent">
                                                <div class="float-right"><span class="pull-right"><a class="btn btn-sm theme-blue text-white mr-2" href="/"><i class="fa fa-globe mr-1"></i>Go to property.aboutpakistan.com</a></span>
                                                </div>

                                                <div class="tab-pane fade active show" id="listings-all" role="tabpanel"
                                                     aria-labelledby="listings-all-tab">
                                                    <h6>Packages</h6>
                                                    <div class="my-4">
                                                        <div class="card my-4">
                                                            <div class="card-header theme-blue text-white">
                                                                <div class="font-14 font-weight-bold text-white"> Edit Packages</div>
                                                            </div>
                                                            <div class="card-body">
                                                                {{ Form::open(['route' => ['admin.package.update',$package], 'method' => 'post', 'class'=> 'package-form']) }}
                                                                {{ Form::bsRadio('package_for', ucwords($package->package_for), ['required' => true, 'list' => ['Agency','Properties'],'display' => 'block','class'=>'mt-3']) }}
                                                                @error('package_for') <span class="error help-block text-red">{{ $message }}</span> @enderror
                                                                @if($agency_id)
                                                                    {{ Form::bsText('agency',$agency= \App\Models\Agency::getAgencyTitle($agency_id->id) . ' - '.$agency_id->id, ['required' => true]) }}
                                                                @endif

                                                                {{ Form::bsText('package', $package->type, ['required' => true,'data-default'=>'Select Package']) }}


                                                                {{ Form::bsNumber('property_count', isset($package->property_count)?$package->property_count:0, ['required' => true, 'data-default' => 'Enter the number of Properties for selected package', 'min' => 1, 'step' => 1]) }}
                                                                {{ Form::bsNumber('duration', isset($package->duration)?$package->duration:0, ['required' => true, 'data-default' => 'Enter Package Duration in Months', 'min' => 1, 'step' => 1]) }}

                                                                <div class="form-group row">
                                                                    <label for="status" class="col-sm-4 col-md-3 col-lg-2  col-xl-2 col-form-label col-form-label-sm">
                                                                        Status
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                                                                        <select class="custom-select custom-select-sm select2 select2-hidden-accessible"
                                                                                style="width: 100%; border: 1px solid rgb(206, 212, 218); border-radius: 0.25rem;" tabindex="-1"
                                                                                aria-hidden="true" aria-describedby="status-error" aria-invalid="false" required="" id="status" name="status"
                                                                                data-select2-id="status">
                                                                            <option value="" disabled>Select Status</option>
                                                                            <option value="active" {{$package->status === 'active' ? 'selected':''}}>Active</option>
                                                                            <option value="pending" {{$package->status === 'pending' ? 'selected':''}}>Pending</option>
                                                                            <option value="expired" {{$package->status === 'expired' ? 'selected':''}}>Expired</option>
                                                                            <option value="rejected" {{$package->status === 'rejected' ? 'selected':''}}>Rejected</option>
                                                                            <option value="deleted" {{$package->status === 'deleted' ? 'selected':''}}>Deleted</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div id="reason-of-rejection" style="display: none">
                                                                    {{--                                                                    {{ Form::bsText('rejection_reason',isset($property->rejection_reason)? $property->rejection_reason:null) }}--}}
                                                                    <div class="form-group row">
                                                                        <label for="rejection_reason" class="col-sm-4 col-md-3 col-lg-2  col-xl-2 col-form-label col-form-label-sm">
                                                                            Rejection Reason
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                        <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                                                                            <input class="form-control form-control-sm" aria-describedby="rejection_reason-error" aria-invalid="false"
                                                                                   name="rejection_reason"
                                                                                   type="text" disable="false" value="{{isset($package->rejection_reason)? $package->rejection_reason:null}}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="card-footer">
                                                                {{ Form::submit('Submit', ['class' => 'btn btn-primary btn-md search-submit-btn']) }}
                                                            </div>
                                                            {{ Form::close() }}

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer start -->

@endsection

@section('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
        <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script src="{{asset('website/js/admin-package-listings.js')}}"></script>
@endsection
