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
                                                <div class="float-right"><span class="pull-right"><a class="btn btn-sm transition-background color-green mr-2" href="/"><i class="fa fa-globe mr-1"></i>Go to property.aboutpakistan.com</a></span>
                                                </div>

                                                <div class="tab-pane fade active show" id="listings-all" role="tabpanel"
                                                     aria-labelledby="listings-all-tab">
                                                    <h6>Add Properties in Package</h6>

                                                    <div class="my-4">
                                                        <div class="card my-4">
                                                            <div class="card-header theme-blue text-white">
                                                                <div class="font-14 font-weight-bold text-white">Package Details</div>
                                                            </div>
                                                            <div class="card-body">

{{--                                                                <div class="form-group row">--}}
{{--                                                                    <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">--}}
{{--                                                                        <strong>Package ID :</strong>--}}
{{--                                                                    </div>--}}
{{--                                                                    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">--}}
{{--                                                                        {{$package->id}}--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
                                                                <div class="form-group row">
                                                                    <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
                                                                        <strong> Package Type :</strong>
                                                                    </div>
                                                                    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                                                                        {{$package->type}}
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
                                                                        <strong> Package For :</strong>
                                                                    </div>
                                                                    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                                                                        {{ucwords($package->package_for)}}
                                                                    </div>
                                                                </div>
                                                                @if(isset($package_agency))
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
                                                                            <strong> Agency :</strong>
                                                                        </div>
                                                                        <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                                                                            {{\App\Models\Agency::getAgencyTitle($package_agency->agency_id)}} - {{$package_agency->agency_id}}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <div class="form-group row">
                                                                    <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
                                                                        <strong> Total Properties :</strong>
                                                                    </div>
                                                                    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                                                                        {{$package->property_count}}
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
                                                                        <strong> Added Properties :</strong>
                                                                    </div>
                                                                    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                                                                        @if(isset($pack_properties))
                                                                            {{count($pack_properties)}}
                                                                        @else
                                                                            0
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
                                                                        <strong> Remaining Properties :</strong>
                                                                    </div>
                                                                    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                                                                        @if(isset($pack_properties))
                                                                            @php $remaining_count = $package->property_count - count($pack_properties)  @endphp
                                                                            {{$remaining_count}}
                                                                        @else
                                                                            {{$package->property_count}}
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
                                                                        <strong> Package Activation Date: </strong>
                                                                    </div>
                                                                    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                                                                        {{ (new \Illuminate\Support\Carbon($package->activated_at))->isoFormat('DD-MM-YYYY  h:mm a')}}
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
                                                                        <strong> Package Expiry Date: </strong>
                                                                    </div>
                                                                    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                                                                        {{ (new \Illuminate\Support\Carbon($package->expired_at))->isoFormat('DD-MM-YYYY  h:mm a') }}
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="my-4">
                                                <span class="pull-right mx-1 my-2">
                                                    {{ Form::open(['route' => ['admin.package.search.properties',$package], 'method' => 'post', 'role' => 'form','class'=>' color-555', 'style' => 'max-width:300px;']) }}
                                                     <div class="input-group input-group-sm mb-3">
                                                    <input class="form-control form-control-sm text-transform" type="number" placeholder="Property ID" name="property_id"
                                                           autocomplete="false" min="1" required>
                                                         <div class="col-2 px-0 mx-0">
                                                                <button class="btn btn-primary search-submit-btn btn-sm" type="Submit"><i class="fa fa-search ml-1"></i></button>
                                                         </div>
                                                     </div>
                                                    {{ Form::close() }}
                                                </span>
                                                        <span class="pull-right mx-1 my-2">
                                                {{ Form::open(['route' => ['admin.package.search.properties',$package], 'method' => 'post', 'role' => 'form','class'=>' color-555', 'style' => 'max-width:300px;', 'id'=>'sort-form']) }}

                                                <select class="sorting form-control form-control-sm" style="width: 100%" name="sort">
                                                    <option value selected disabled data-index="0">Select Sorting Option</option>
                                                    <option value="oldest" {{ isset($sort) && $sort=== 'asc' ? 'selected' : '' }}>Oldest
                                                    </option>
                                                    <option value="newest" {{ isset($sort) && $sort=== 'desc' ? 'selected' : '' }}>Newest
                                                    </option>
                                                </select>
                                                    {{ Form::close() }}
                                                </span></div>

                                                    <div class="my-4 component-block">
                                                        <h6 class="pull-left"> Property Listings</h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-sm table-bordered">
                                                                <thead class="theme-blue text-white">
                                                                <tr>
                                                                    <td>ID</td>
                                                                    <td>Purpose</td>
                                                                    <td>Type</td>
                                                                    <td>Location</td>
                                                                    <td>Price (PKR)</td>
                                                                    <td>Added By</td>
                                                                    <td>Listed For</td>
                                                                    <td>Listed Date</td>
                                                                    <td>Activation Date</td>
                                                                    <td>Views</td>
                                                                    <td>Status Controls</td>
                                                                    <td>Controls</td>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if($data !== null)
                                                                    @forelse($data as $all_listing)
                                                                        <tr>
                                                                            <td>{{ $all_listing->id }}</td>
                                                                            <td>{{ $all_listing->purpose}}</td>
                                                                            <td>{{ $all_listing->type }}</td>
                                                                            <td>{{ $all_listing->location }}, {{$all_listing->city}}</td>
                                                                            @if($all_listing->price != '0')
                                                                                <td class="text-right pr-3">{{  $all_listing->price}}</td>
                                                                            @endif
                                                                            <td>{{\App\Models\Dashboard\User::getUserName($all_listing->user_id)}}</td>
                                                                            <td>{{$all_listing->agency_id == null ? 'Individual':'Agency ('.\App\Models\Agency::getAgencyTitle($all_listing->agency_id) .')'}}</td>
                                                                            <td>{{ (new \Illuminate\Support\Carbon($all_listing->created_at))->isoFormat('DD-MM-YYYY  h:mm a') }}</td>

                                                                            <td>
                                                                                <div>
                                                                                    {{ (new \Illuminate\Support\Carbon($all_listing->activated_at))->isoFormat('DD-MM-YYYY  h:mm a') }}
                                                                                </div>
                                                                                <div class="badge badge-success p-2">
                                                                                    @if(str_contains ( (new \Illuminate\Support\Carbon($all_listing->expired_at))->diffForHumans(['parts' => 1]), 'ago' ))
                                                                                        <strong
                                                                                            class="color-white font-12">
                                                                                            Expired {{(new \Illuminate\Support\Carbon($all_listing->expired_at))->diffForHumans(['parts' => 1])}}</strong>
                                                                                    @else
                                                                                        <strong
                                                                                            class="color-white font-12"> Expires
                                                                                            in {{(new \Illuminate\Support\Carbon($all_listing->expired_at))->diffForHumans(['parts' => 1])}}</strong>
                                                                                    @endif
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-right pr-3">
                                                                                {{$all_listing->views}}
                                                                            </td>
                                                                            <td>
                                                                                @if(in_array($all_listing->id,$pack_properties))
                                                                                    <div class="badge badge-success p-2 ">
                                                                                        <strong class="font-12 color-white">Added</strong>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="badge badge-info p-2 ">
                                                                                        <strong class="font-12 color-white">Not Added</strong>
                                                                                    </div>
                                                                                @endif


                                                                            </td>
                                                                            <td>
                                                                                @if($all_listing->id < 104280)
                                                                                    <a type="button" target="_blank"
                                                                                       href="{{route('properties.show',[
                                                                                                'slug'=>Str::slug($all_listing->location) . '-' . Str::slug($all_listing->title) . '-' . $all_listing->reference,
                                                                                                'property'=>$all_listing->id])}}"

                                                                                       class="btn btn-sm btn-primary mb-1"
                                                                                       data-toggle-1="tooltip"
                                                                                       data-placement="bottom" title="View Property">
                                                                                        <i class="fas fa-eye"></i><span class="sr-only sr-only-focusable" aria-hidden="true">View</span>
                                                                                    </a>
                                                                                @else
                                                                                    <a type="button" target="_blank"
                                                                                       href="{{route('properties.show',[
                                                                                                'slug'=>Str::slug($all_listing->city) . '-' .Str::slug($all_listing->location) . '-' . Str::slug($all_listing->title) . '-' . $all_listing->reference,
                                                                                                'property'=>$all_listing->id])}}"

                                                                                       class="btn btn-sm btn-primary mb-1"
                                                                                       data-toggle-1="tooltip"
                                                                                       data-placement="bottom" title="View Property">
                                                                                        <i class="fas fa-eye"></i><span class="sr-only sr-only-focusable" aria-hidden="true">View</span>
                                                                                    </a>
                                                                                @endif
                                                                            </td>
                                                                        </tr>

                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="12" class="p-4 text-center">No Listings Found!</td>
                                                                        </tr>
                                                                    @endforelse
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        @if($data !== null)
                                                            {{ $data->links('vendor.pagination.bootstrap-4') }}
                                                        @endif
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
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script>
        (function ($) {
            $(document).ready(function () {
                $(document).on('change', '.sorting', function (e) {
                    $('#sort-form').submit();
                });
            });
        })
        (jQuery);
    </script>
@endsection
