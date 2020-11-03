@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Property Management By https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}" async defer>
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}" async defer>
@endsection

@section('content')
    @include('website.includes.dashboard-nav')
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>Property Management</h1>
            </div>
        </div>
    </div>
    <!-- Submit Property start -->
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content" id="ListingsTabContent">

                        <div class="tab-pane fade show active" id="property_management" role="tabpanel" aria-labelledby="property_management-tab">
                            <div class="row my-4">
                                <div class="col-md-3">
                                    @include('website.includes.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.flash-message')
                                    @include('website.layouts.user_notification')
                                    <div class="tab-content" id="listings-tabContent">
                                        <span class="pull-right"><a class="btn btn-sm theme-blue text-white" href="{{route('properties.create')}}">Add New Advertisement</a></span>
                                        <span class="pull-right">{{ Form::open(['route' => ['property.search.ref'], 'method' => 'post', 'role' => 'form','class'=>'px-3 nav-link color-555', 'style' => 'max-width:300px;']) }}
                                                    <input class="px-3 property-id text-transform" type="text" placeholder="Property Reference" name="property_ref" id="property_ref"
                                                           autocomplete="false" required>
                                                    <i class="fa fa-search ml-1"></i>
                                                    {{ Form::close() }}</span>
                                        @foreach(['all', 'sale', 'rent','wanted','basic','bronze','silver','golden','platinum'] as $option)
                                            <div class="tab-pane fade show {{\Illuminate\Support\Facades\Request::segments()[5] === $option? 'active' : '' }}" id="{{"listings-".$option}}"
                                                 role="tabpanel"
                                                 aria-labelledby="{{"listings-".$option."-tab"}}">
                                                <h6 class="pull-left">{{ucwords($option)}} Listings</h6>
                                                <div class="my-4">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-bordered">
                                                            <thead class="theme-blue text-white">
                                                            <tr>
                                                                <td>ID</td>
                                                                <td>Reference</td>
                                                                <td>Type</td>
                                                                <td>Location</td>
                                                                <td>Price (PKR)</td>
                                                                <td>Listed Date</td>
                                                                @if($params['status'] == 'active')
                                                                    <td>Activation Date</td>
                                                                    <td>Boost</td>
                                                                @endif
                                                                @if($params['status'] != 'deleted' || $params['status'] != 'pending' )
                                                                    <td>Status Controls</td>
                                                                @endif
                                                                <td>Controls</td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if($listings[$option] !== null)
                                                                @forelse($listings[$option] as $all_listing)
                                                                    <tr>
                                                                        <td>{{ $all_listing->id }}</td>
                                                                        <td>{{ $all_listing->reference}}</td>
                                                                        <td>{{ $all_listing->type }}</td>
                                                                        <td>{{ $all_listing->location }}, {{$all_listing->city}}</td>
                                                                        @if($all_listing->price != '0')
                                                                            <td class="text-right pr-3">{{  $all_listing->price}}</td>
                                                                        @else
                                                                            <td class="pr-3">{{ 'Call option selected for price'}}</td>
                                                                        @endif
                                                                        <td>{{ (new \Illuminate\Support\Carbon($all_listing->listed_date))->format('Y-m-d') }}</td>
                                                                        @if($params['status'] == 'active')
                                                                            <td>
                                                                                {{ (new \Illuminate\Support\Carbon($all_listing->activated_at))->format('Y-m-d') }}
                                                                                <br>
                                                                                Expired
                                                                                in {{(new \Illuminate\Support\Carbon($all_listing->expired_at))->diffInDays(new \Illuminate\Support\Carbon(now()))}}
                                                                                days
                                                                            </td>
                                                                            <td class="cursor-not-allowed"><span>Boost Count : 0</span>
                                                                                <a href="javascript:void(0)" class="btn btn-sm btn-success pull-right disabled">Click to Boost</a></td>
                                                                        @endif

                                                                        @if($params['status'] != 'deleted')
                                                                            <td>
                                                                                @if($params['status'] === 'sold')
                                                                                    <div class="sold-status"><strong>Property Sold</strong>
                                                                                    </div>                                                                            @else
                                                                                    <form>
                                                                                        @if($params['status'] != 'expired')

                                                                                        @endif
                                                                                        @if($params['status'] != 'active' && $params['status'] != 'pending')
                                                                                            <input type="radio" name="status" value="reactive"
                                                                                                   {{$all_listing->status === 'active'? 'disabled':'' }}
                                                                                                   data-id="{{ $all_listing->id }}">
                                                                                            <label for="active">Reactive</label>
                                                                                        @endif
                                                                                        @if($params['status'] != 'expired')
                                                                                            <input type="radio" name="status" value="expired"
                                                                                                   {{$all_listing->status === 'expired'? 'checked':'' }}
                                                                                                   {{$all_listing->status === 'sold'? 'checked':'' }}
                                                                                                   data-id="{{ $all_listing->id }}" {{$all_listing->status === 'expired'? 'checked':'' }}>
                                                                                            <label for="expired">Expired</label>
                                                                                        @endif
                                                                                        @if($params['status'] != 'sold')
                                                                                            <input type="radio" name="status" value="sold"
                                                                                                   data-id="{{ $all_listing->id }}" {{$all_listing->status === 'sold'? 'checked':'' }}>
                                                                                            <label for="sold">Sold</label>
                                                                                        @endif
                                                                                    </form>
                                                                                @endif
                                                                            </td>
                                                                        @else
                                                                            <td></td>
                                                                        @endif
                                                                        <td>
                                                                            @if($params['status'] != 'sold' && $params['status'] != 'deleted')
                                                                                <a type="button" href="{{route('properties.edit', $all_listing->id)}}"
                                                                                   class="btn btn-sm btn-warning
                                                                            {{$params['status'] == 'deleted' ? 'anchor-disable':'' }}
                                                                                   {{$params['status'] == 'sold' ? 'anchor-disable':'' }}
                                                                                       "
                                                                                   data-toggle-1="tooltip"
                                                                                   data-placement="bottom" title="edit">
                                                                                    <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                                </a>
                                                                                <a type="button" class="btn btn-sm btn-danger" data-toggle-1="tooltip"
                                                                                   data-placement="bottom" title="delete"
                                                                                   data-toggle="modal" data-target="#delete"
                                                                                   data-record-id="{{$all_listing->id}}">
                                                                                    <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                                </a>
                                                                            @elseif($params['status'] == 'deleted')
                                                                                <a type="button"
                                                                                   class="btn btn-sm btn-success color-black restore-btn {{$params['status'] == 'deleted' ?'':'anchor-disable'}}"
                                                                                   data-toggle-1="tooltip" data-placement="bottom"
                                                                                   title="restore"
                                                                                   href="javascript:void(0)"
                                                                                   data-record-id="{{$all_listing->id}}">
                                                                                    <i class="fas fa-redo-alt"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Restore</span>
                                                                                </a>

                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="9" class="p-4 text-center">No Listings Found!</td>
                                                                    </tr>
                                                                @endforelse
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    @if($params['status'] === 'edited')
                                                        <div class="font-12 mb-2"><span class="color-red">*</span> Please check reactive button for verification of changes</div>
                                                    @elseif([$params['status'] === 'active'] ||[$params['status'] === 'expired'] )
                                                        <div class="font-12 mb-2"><span class="color-red">*</span> If property is expired, it will not display on the main site</div>
                                                    @endif
                                                    @if($listings[$option] !== null)
                                                        {{ $listings[$option]->links() }}
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('website.layouts.delete-modal', array('route'=>'properties'))

    <!-- Footer start -->
    @include('website.includes.footer')
@endsection

@section('script')
    <script src="{{asset('website/js/listings-page.js')}}" defer></script>
@endsection
