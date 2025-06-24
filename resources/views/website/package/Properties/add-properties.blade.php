@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>Jagha - Buy Sell Rent Homes & Properties In Pakistan by https://www.jagha.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">

    {{--    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">--}}

@endsection

@section('content')
    @include('website.includes.dashboard-nav')
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>Package</h1>
            </div>
        </div>
    </div>
    <!-- Submit Property start -->
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" role="tabpanel">
                            <div class="row my-4">
                                <div class="col-md-3">
                                    @include('website.package.properties.sidebar')
                                </div>
                                <div class="col-md-9">
                                    <div class="message-block"></div>
                                    @include('website.layouts.flash-message')
                                    <div class="tab-content" id="listings-tabContent">
                                        <div class="float-right">
                                               <span class="pull-right"><a class="btn btn-sm transition-background color-green mr-2" href="/"><i
                                                           class="fa fa-globe mr-1"></i>Go to jagha.com</a></span>
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
                                                        <h6>{{$package->type}} Package</h6>
                                                            <table class="table table-bordered" style="width:100%">
                                                                <tr>
                                                                    <td>Package Type</td>
                                                                    <td> {{$package->type}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Package For</td>
                                                                    <td>{{ucwords($package->package_for)}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Package Duration</td>
                                                                    <td>{{ucwords($package->duration)}} month(s)</td>
                                                                </tr>

                                                                @if(isset($package_agency))
                                                                    <tr>
                                                                        <td>Agency</td>
                                                                        <td>
                                                                            @php $agency_name = \App\Models\Agency::getAgencyTitle($package_agency->agency_id);  @endphp
                                                                            {{ $agency_name}} - {{ $package_agency->agency_id}}
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                <tr>
                                                                    <td> Total Properties</td>
                                                                    <td>{{$package->property_count}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Added Properties</td>
                                                                    <td>
                                                                        @if(isset($pack_properties))
                                                                            {{count($pack_properties)}}
                                                                        @else
                                                                            0
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Remaining Properties</td>
                                                                    <td>
                                                                        @if(isset($pack_properties))
                                                                            @php $remaining_count = $package->property_count - count($pack_properties)  @endphp
                                                                            {{$remaining_count}}
                                                                        @else
                                                                            {{$package->property_count}}
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Package Activation Date</td>
                                                                    <td>
                                                                        {{ (new \Illuminate\Support\Carbon($package->activated_at))->isoFormat('DD-MM-YYYY') }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Package Expiry</td>
                                                                    <td>
                                                                        {{ (new \Illuminate\Support\Carbon($package->expired_at))->diffForHumans() }}
                                                                        ({{ (new \Illuminate\Support\Carbon($package->expired_at))->isoFormat('DD-MM-YYYY') }})
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        <div class="pt-1 text-danger"><span class="text-danger">* </span>The package will not renew automatically.</div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="my-4">
                                                <span class="pull-right mx-1 my-2">
                                                    {{ Form::open(['route' => ['package.search.properties',$package], 'method' => 'post', 'role' => 'form','class'=>' color-555', 'style' => 'max-width:300px;']) }}
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
                                                {{ Form::open(['route' => ['package.search.properties',$package], 'method' => 'post', 'role' => 'form','class'=>' color-555', 'style' => 'max-width:300px;', 'id'=>'sort-form']) }}

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
                                                            <td>Duration</td>
                                                            <td>Status Controls</td>
                                                            <td>Controls</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if($data !== null)
                                                            @php  $user_id = \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier() ;
                                                                        $user_name = \Illuminate\Support\Facades\Auth::user()->name
                                                            @endphp
                                                            @forelse($data as $all_listing)
                                                                <tr>
                                                                    <td>{{ $all_listing->id }}</td>
                                                                    <td>{{ $all_listing->purpose}}</td>
                                                                    <td>{{ $all_listing->type }}</td>
                                                                    <td>{{ $all_listing->location }}, {{$all_listing->city}}</td>
                                                                    @if($all_listing->price != '0')
                                                                        <td class="text-right pr-3">{{  $all_listing->price}}</td>
                                                                    @endif
                                                                    <td>
                                                                        @if($all_listing->user_id == $user_id)
                                                                            {{$user_name}}
                                                                        @else
                                                                            {{\App\Models\Dashboard\User::getUserName($all_listing->user_id)}}
                                                                        @endif
                                                                    </td>
                                                                    <td>{{$all_listing->agency_id == null ? 'Individual':'Agency ('.$agency_name .')'}}</td>
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
                                                                    @if(in_array($all_listing->id,$pack_properties))
                                                                        <td>
                                                                            {{--                                                                            <input class="form-control form-control-sm" aria-describedby="property_duration" placeholder="Days" aria-invalid="false"--}}
                                                                            {{--                                                                                   min="1"--}}
                                                                            {{--                                                                                   step="1" name="duration" type="number" required>--}}
                                                                            {{--                                                                            {{\App\Models\Package::getDuration($all_listing->id)}}--}}
                                                                            {{(new \App\Models\Package)->getDuration($all_listing->id)->duration}}
                                                                        </td>
                                                                        <td>
                                                                            <div class="badge badge-success p-2 ">
                                                                                <strong class="font-12 color-white">Added</strong>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>
                                                                            <input class="form-control form-control-sm" aria-describedby="property_duration" placeholder="Days" aria-invalid="false"
                                                                                   min="1"
                                                                                   step="1" name="duration" type="number" required>
                                                                        </td>
                                                                        <td>
                                                                            {{--                                                                        @if(in_array($all_listing->id,$pack_properties))--}}
                                                                            {{--                                                                           --}}
                                                                            {{--                                                                        @else--}}
                                                                            <div class="badge badge-success p-2" style="display: none">
                                                                                <strong class="font-12 color-white">Added</strong>
                                                                            </div>
                                                                            <button type="button"
                                                                                    class="btn btn-sm btn-primary mb-1 add-property"
                                                                                    data-package-id="{{$package->id}}"
                                                                                    data-property-id="{{$all_listing->id}}"
                                                                                    data-toggle-1="tooltip"
                                                                                    data-placement="bottom" title="Add To Package">
                                                                                <span class="color-white"> Add To Package</span>
                                                                            </button>
                                                                            <button type="button"
                                                                                    class="btn btn-sm btn-primary mb-1 loading-btn" disabled style="display: none">
                                                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                                <span class="color-white"> Working ..</span>
                                                                            </button>
                                                                            {{--                                                                        @endif--}}


                                                                        </td>
                                                                    @endif
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

    <!-- Footer start -->
    @include('website.includes.footer')
@endsection

@section('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('website/js/packages-add-properties.js')}}"></script>

@endsection
