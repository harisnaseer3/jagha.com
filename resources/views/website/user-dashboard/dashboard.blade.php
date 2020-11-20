@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Property Management By Property.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
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
                                @include('website.layouts.user_notification')
                                <div class="row">
                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                        <a href="{{route('properties.listings',['active','all',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),'id','asc','1'])}}">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-success"><i class="fas fa-home"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text"> Active Properties</span>
                                                    <span class="info-box-number">{{$active_properties}}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                        <a href="{{route('properties.listings',['pending','all',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),'id','asc','1'])}}">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-warning"><i class="fas fa-home"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text"> Pending Properties</span>
                                                    <span class="info-box-number">{{$pending_properties}}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                        <a href="{{route('properties.listings',['deleted','all',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),'id','asc','1'])}}">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-danger"><i class="fas fa-home"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text"> Deleted Properties</span>
                                                    <span class="info-box-number">{{$deleted_properties}}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                        <a href="{{route('agencies.listings',['verified_agencies','all',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),'id','asc','1'])}}">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-info"><i class="fas fa-home"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text"> Total Agencies</span>
                                                    <span class="info-box-number">{{$agencies}}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-4 col-sm-6">
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
                                                <h5><a href="#">{{ucwords($user->name)}}</a></h5>
                                                <div class="contact">
                                                    <p class="m-0">
                                                        <a href="mailto:info@themevessel.com"><i class="fa fa-envelope-o mr-1"></i> {{$user->email}}</a>
                                                    </p>
                                                    @if($user->cell !== null)
                                                        <p class="m-0">
                                                            <a href="tel:+554XX-634-7071"> <i class="fa fa-phone mr-1"></i>{{$user->cell}}</a>
                                                        </p>
                                                    @endif
                                                    @if($user->phone !== null)
                                                        <p class="m-0">
                                                            <a href="#"><i class="fa fa-phone mr-1"></i>{{$user->phone}}</a>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-lg-10">
                                        <div><h6>Property Listing</h6></div>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered">
                                                <thead class="theme-blue text-white">
                                                <tr>
                                                    <td>ID</td>
                                                    <td>Type</td>
                                                    <td>Location</td>
                                                    <td>Price (PKR)</td>
                                                    <td>Area (new marla)</td>
                                                    <td>Purpose</td>
                                                    <td>Status</td>
                                                    <td>Views</td>
                                                    <td>Activation Date</td>
                                                    <td>Controls</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($properties as $property)
                                                    <tr>
                                                        <td>{{$property->id}}</td>
                                                        <td>{{$property->type}}</td>
                                                        <td>{{$property->address}}</td>
                                                        <td>
                                                            @if($property->price == 0)
                                                                Call option selected for price
                                                            @else
                                                                {{$property->price}} (PKR)
                                                            @endif
                                                        </td>
                                                        <td>{{(int)round($property->area_in_new_marla)}}</td>
                                                        <td>{{$property->purpose}}</td>
                                                        <td>{{$property->status}}</td>
                                                        <td>{{$property->views}}</td>
                                                        <td>{{(new \Illuminate\Support\Carbon($property->activated_at))->format('Y-m-d')}}</td>

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
                                        {{ $properties->links() }}
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
    <script>
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
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
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
                url: window.location.origin +  '/dashboard/agencies/reject-invitation',
                data: {'notification_id': notification_id},
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    if (data.status === 200) {
                        alert.closest('.alert').remove();
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
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
                url: window.location.origin  + '/dashboard/property-notification',
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
