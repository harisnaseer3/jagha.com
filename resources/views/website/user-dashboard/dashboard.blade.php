@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">
    <style>
        .badge-gold{
            color: grey;
            background-color: #FFD700;
        }
        .badge-platinum{
            color: black;
            background-color: #C0C0C0;
        }
    </style>
@endsection

@section('content')
    @include('website.includes.dashboard-nav')

    <!-- Submit Property start -->
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content admin-margin" id="ListingsTabContent">
                        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                            <div class="m-4">

                                <div class="row">
                                    <div class="col-sm-6 col-md-6 col-lg-4">
                                        <a href="{{route('properties.listings',['active','all',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),'id','desc','1'])}}">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-success"><i class="fas fa-city  color-white"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text"> Active Properties</span>
                                                    <span class="info-box-number">{{$active_properties}}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-4">
                                        <a href="{{route('properties.listings',['pending','all',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),'id','desc','1'])}}">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-warning"><i class="fas fa-city color-white"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text"> Pending Properties</span>
                                                    <span class="info-box-number">{{$pending_properties}}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-4">
                                        <a href="{{route('properties.listings',['deleted','all',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),'id','desc','1'])}}">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-danger"><i class="fas fa-city color-white"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text"> Deleted Properties</span>
                                                    <span class="info-box-number">{{$deleted_properties}}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-4">
                                        <a href="{{route('agencies.listings',['verified_agencies','all',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),'id','desc','1'])}}">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                                                <div class="info-box-content" style="word-wrap: break-word;">
                                                    <span class="info-box-text">Verified Agencies & Memberships</span>
                                                    <span class="info-box-number">{{$agencies}}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-4">
                                        <a href="{{route('package.index')}}">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-danger"><i class="fad fa-gem color-white"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Active Packages</span>
                                                    <span class="info-box-number">{{count($packages)}}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-4">
                                        <a href="{{route('account.wallet')}}">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-success"><i class="far fa-wallet color-white"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Wallet</span>
                                                    <span class="info-box-number"> Rs. {{$wallet}}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <span class="pull-right py-2"><a class="btn btn-sm theme-blue text-white ml-2" href="{{route('properties.create')}}"><i class="fa fa-plus-circle mr-1"></i>Post Advertisement</a></span>
                                        <span class="pull-right py-2"><a class="btn btn-sm theme-blue text-white" href="{{route('agencies.create')}}"><i
                                                    class="fa fa-plus-circle mr-1"></i>Add New Agency</a></span>
                                        <span class="pull-right py-2"><a class="btn btn-sm theme-blue text-white mr-2" href="/"><i
                                                    class="fa fa-globe mr-1"></i>Go to property.aboutpakistan.com</a></span>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-2 col-lg-3 col-md-5 col-sm-6">
                                        <div class="team-1">
                                            <div class="team-photo">
                                                @if(isset($user->image) && $user->image != null)
                                                    <img src="{{ asset('thumbnails/user_images/'.explode('.',$user->image)[0].'-450x350.webp')}}"
                                                         alt="{{$user->name}}" title="{{$user->name}}" class="img-fluid image-padding rounded-circle" aria-label="user photo">
                                                @else
                                                    <img src="{{asset('img/logo/profile.png')}}"
                                                         alt="{{$user->name}}" title="{{$user->name}}" class="img-fluid image-padding rounded-circle" aria-label="user photo">
                                                @endif
                                            </div>
                                            <div class="team-details">
                                                @if(count($user->roles) > 0)
                                                    <h6 class="proper-case">{{ucwords($user->roles[0]->name)}}</h6>
                                                @endif
                                                <h5>{{ucwords($user->name)}}</h5>
                                                <div class="contact">
                                                    <p class="m-0">
                                                        <i class="fa fa-envelope-o mr-1"></i> {{$user->email}}
                                                    </p>
                                                    @if($user->cell !== null)
                                                        <p class="m-0">
                                                            <i class="fa fa-phone mr-1"></i>{{$user->cell}}
                                                        </p>
                                                    @endif
                                                    @if($user->phone !== null)
                                                        <p class="m-0">
                                                            <i class="fa fa-phone mr-1"></i>{{$user->phone}}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-xl-10 col-lg-9 col-md-7 col-sm-12 ">
                                        {{--                                        <div><h4>Recent Properties</h4></div>--}}
                                        @if($sale->count() > 0)
                                            <div class="card my-2">
                                                <div class="card-header theme-blue text-white">
                                                    Recent Properties for Sale
                                                </div>
                                                <div class="card-body">
                                                    <table class="display" style="width: 100%" id="sale-properties">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Type</th>
                                                            <th>Location</th>
                                                            <th>Price (PKR)</th>
                                                            <th>Status</th>
                                                            <th>Package</th>
                                                            <th>Views</th>
                                                            <th>Listed Date</th>
                                                            <th>Controls</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @forelse($sale as $property)
                                                            <tr>
                                                                <td>{{$property->id}}</td>
                                                                <td>{{$property->type}}</td>
                                                                <td>{{$property->location->name}}, {{$property->city->name}}</td>
                                                                <td>
                                                                    @if($property->price == 0)
                                                                        Call option selected for price
                                                                    @else
                                                                        {{$property->price}} (PKR)
                                                                    @endif
                                                                </td>
                                                                <td>{{ucfirst($property->status)}}</td>
                                                                <td>
                                                                    @if($property->gold_lisitng == '1')
                                                                        <div class="badge badge-gold p-2">Gold</div>
                                                                    @elseif($property->platinum_listing == '1')
                                                                        <div class="badge badge-platinum p-2">Platinum</div>
                                                                    @else
                                                                        <div class="badge badge-primary p-2">Basic</div>

                                                                    @endif

                                                                </td>
                                                                <td>{{$property->views}}</td>
                                                                <td>{{ (new \Illuminate\Support\Carbon($property->created_at))->isoFormat('DD-MM-YYYY  h:mm a') }}</td>
                                                                <td>
                                                                    @if($property->id < 104280)
                                                                        <a type="button" href="{{$property->status === 'active' ? route('properties.show',[
                                                                        'slug'=>Str::slug($property->location) . '-' . Str::slug($property->title) . '-' . $property->reference,
                                                                        'property'=>$property->id]):'#'}}"
                                                                           class="btn btn-sm btn-primary mb-1
                                                                           {{$property->status === 'active' ? '':'anchor-disable'}}"
                                                                           data-toggle-1="tooltip"
                                                                           target="_blank"
                                                                           data-placement="bottom" title="View Property">
                                                                            <i class="fas fa-eye"></i><span class="sr-only sr-only-focusable" aria-hidden="true">View</span>
                                                                        </a>
                                                                    @else
                                                                        <a type="button" href="{{$property->status === 'active' ? route('properties.show',[
                                                                            'slug'=>Str::slug($property->city) . '-' .Str::slug($property->location) . '-' . Str::slug($property->title) . '-' . $property->reference,
                                                                            'property'=>$property->id]):'#'}}"
                                                                           class="btn btn-sm btn-primary mb-1
                                                                           {{$property->status === 'active' ? '':'anchor-disable'}}"
                                                                           data-toggle-1="tooltip"
                                                                           target="_blank"
                                                                           data-placement="bottom" title="View Property">
                                                                            <i class="fas fa-eye"></i><span class="sr-only sr-only-focusable" aria-hidden="true">View</span>
                                                                        </a>
                                                                    @endif


                                                                    <a type="button" href="{{route('properties.edit', $property->id)}}"
                                                                       class="btn btn-sm btn-warning mb-1"
                                                                       data-toggle-1="tooltip"
                                                                       data-placement="bottom" title="Edit Property">
                                                                        <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                    </a>
                                                                    <a type="button" class="btn btn-sm btn-danger mb-1" data-toggle-1="tooltip"
                                                                       data-placement="bottom" title="Delete Property"
                                                                       data-toggle="modal" data-target="#delete"
                                                                       data-record-id="{{$property->id}}">
                                                                        <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="9" class="p-4 text-center">No Listings Found!</td>
                                                            </tr>
                                                        @endforelse
                                                        </tbody>
                                                    </table>

                                                </div>

                                            </div>
                                        @endif
                                        @if($rent->count() > 0)
                                            <div class="card my-2">
                                                <div class="card-header theme-blue text-white">
                                                    Recent Properties for Rent
                                                </div>
                                                <div class="card-body">
                                                    <table class="display" style="width: 100%" id="rent-properties">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Type</th>
                                                            <th>Location</th>
                                                            <th>Price (PKR)</th>
                                                            <th>Status</th>
                                                            <th>Views</th>
                                                            <th>Listed Date</th>
                                                            <th>Controls</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @forelse($rent as $property)
                                                            <tr>
                                                                <td>{{$property->id}}</td>
                                                                <td>{{$property->type}}</td>
                                                                <td>{{$property->location->name}}, {{$property->city->name}}</td>
                                                                <td>
                                                                    @if($property->price == 0)
                                                                        Call option selected for price
                                                                    @else
                                                                        {{$property->price}} (PKR)
                                                                    @endif
                                                                </td>
                                                                <td>{{ucfirst($property->status)}}</td>
                                                                <td>{{$property->views}}</td>
                                                                <td>{{ (new \Illuminate\Support\Carbon($property->created_at))->isoFormat('MMMM Do YYYY, h:mm a') }}</td>
                                                                <td><a type="button" href="{{route('properties.edit', $property->id)}}"
                                                                       class="btn btn-sm btn-warning"
                                                                       data-toggle-1="tooltip"
                                                                       data-placement="bottom" title="edit">
                                                                        <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                    </a>
                                                                    <a type="button" class="btn btn-sm btn-danger" data-toggle-1="tooltip"
                                                                       data-placement="bottom" title="delete"
                                                                       data-toggle="modal" data-target="#delete"
                                                                       data-record-id="{{$property->id}}">
                                                                        <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                    </a></td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="9" class="p-4 text-center">No Listings Found!</td>
                                                            </tr>
                                                        @endforelse
                                                        </tbody>
                                                    </table>

                                                </div>

                                            </div>
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


    <!-- Footer start -->
    @include('website.includes.footer')
    @include('website.layouts.delete-modal', array('route'=>'properties'))

@endsection

@section('script')
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script>
        $('#sale-properties').DataTable(
            {
                "scrollX": true,
                "ordering": false,
                responsive: true
            }
        );
        $('#rent-properties').DataTable(
            {
                "scrollX": true,
                "ordering": false,
                responsive: true
            }
        );
        $('#delete').on('show.bs.modal', function (event) {
            let record_id = $(event.relatedTarget).data('record-id');
            $(this).find('.modal-body #record-id').val(record_id);
        });
        setInterval(function () {
            var docHeight = $(window).height();
            var footerHeight = $('#foot-wrap').height();
            var footerTop = $('#foot-wrap').position().top + footerHeight;
            var marginTop = (docHeight - footerTop);
            if (footerTop < docHeight)
                $('#foot-wrap').css('margin-top', marginTop + 'px'); // padding of 30 on footer
            else
                $('#foot-wrap').css('margin-top', '0px');
        }, 250);
        $('.btn-accept').on('click', function () {
            let alert = $(this);
            let agency_id = alert.attr('data-agency');
            let user_id = alert.attr('data-user');
            let notification_id = alert.attr('data-id');

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/dashboard/agencies/accept-invitation',
                data: {'agency_id': agency_id, 'user_id': user_id, 'notification_id': notification_id},
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    if (data.status === 200) {
                        alert.closest('.alert').remove();
                    }
                },
                error: function (xhr, status, error) {
                    // console.log(xhr);
                    // console.log(status);
                    // console.log(error);
                },
                complete: function (url, options) {

                }
            });
        });
        $('.btn-reject').on('click', function () {
            let alert = $(this);
            let notification_id = alert.attr('data-id');

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/dashboard/agencies/reject-invitation',
                data: {'notification_id': notification_id},
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    if (data.status === 200) {
                        alert.closest('.alert').remove();
                    }
                },
                error: function (xhr, status, error) {
                    // console.log(xhr);
                    // console.log(status);
                    // console.log(error);
                },
                complete: function (url, options) {

                }
            });
        });
        $('.mark-as-read').on('click', function () {
            let alert = $(this);
            let notification_id = alert.attr('data-id');

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/dashboard/property-notification',
                data: {'notification_id': notification_id},
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    if (data.status === 200) {
                        // console.log(alert);
                        alert.closest('.alert').remove();
                    }
                },
                error: function (xhr, status, error) {
                    // console.log(xhr);
                    // console.log(status);
                    // console.log(error);
                },
                complete: function (url, options) {

                }
            });
        });
    </script>

@endsection
