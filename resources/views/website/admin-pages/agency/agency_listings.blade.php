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
    <div id="site" class="left relative" >
        <div id="site-wrap" class="left relative" >
    @include('website.admin-pages.includes.admin-nav')
    <!-- Top header start -->
    <div style="min-height:90px"></div>

    <!-- Submit Property start -->
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content" id="ListingsTabContent">
                        <div class="tab-pane fade show active" id="property_management" role="tabpanel" aria-labelledby="property_management-tab">
                            <div class="row my-4">
                                <div class="col-md-3">
                                    @include('website.admin-pages.agency.sidebar')
                                </div>
                                <div class="col-md-9">
                                    {{--                                    @include('website.layouts.user_notification')--}}
                                    @include('website.layouts.flash-message')
                                    <div class="tab-content" id="listings-tabContent">
                                        <div class="float-right"><a class="btn btn-sm theme-blue text-white" href="{{route('admin-agencies-create')}}">Add New Agency</a></div>
                                        <div class="">{{ Form::open(['route' => ['admin.property.search.id'], 'method' => 'post', 'role' => 'form','class'=>'px-3 nav-link color-555', 'style' => 'max-width:300px;' ,'id'=>'search-property-ref']) }}
                                        <input class="px-3 property-id text-transform" type="text" placeholder="Property ID" name="property_id" id="property_id"
                                               autocomplete="false" required>
                                        <i class="fa fa-search ml-1"></i>
                                        {{ Form::close() }}

                                        <div class="tab-pane fade {{\Illuminate\Support\Facades\Request::segments()[5] === 'all'? 'active show' : '' }}" id="listings-all" role="tabpanel"
                                             aria-labelledby="listings-all-tab">
                                            <h6>All Listings</h6>
                                            <div class="my-4">
                                                <table class="table table-sm table-bordered">
                                                    <thead class="theme-blue text-white">
                                                    <tr>
                                                        <td>ID</td>
                                                        <td>Title</td>
                                                        <td>Address</td>
                                                        <td>City</td>
                                                        <td>Website</td>
                                                        <td>Phone</td>
                                                        <td>Listed Date</td>
                                                        @if($params['status'] != 'verified_agencies')
                                                            <td>Status Controls</td>
                                                        @endif
                                                        @if($params['status'] == 'verified_agencies')
                                                            <td>Verified By</td>
                                                        @elseif($params['status'] == 'deleted_agencies')
                                                            <td>Deleted By</td>
                                                        @elseif($params['status'] == 'rejected_agencies')
                                                            <td>Rejected By</td>
                                                        @endif
                                                        <td>Controls</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($listings['all'] as $all_listing)
                                                        <tr>
                                                            <td>{{ $all_listing->id }}</td>
                                                            <td>{{ $all_listing->title }}</td>
                                                            <td>{{ $all_listing->address }}</td>
                                                            <td class="pr-3">{{ $all_listing->city}}</td>
                                                            <td>{{ $all_listing->website }}</td>
                                                            <td>{{ $all_listing->phone }}</td>
                                                            <td>{{ (new \Illuminate\Support\Carbon($all_listing->listed_date))->format('Y-m-d') }}</td>
                                                            @if($params['status'] == 'pending_agencies')
                                                                <td>
                                                                    <div class="pending-status"><strong>Pending</strong></div>
                                                                </td>
                                                            @elseif($params['status'] == 'expired_agencies')
                                                                <td>
                                                                    <div class="pending-status"><strong>Expired</strong></div>
                                                                </td>
                                                            @elseif($params['status'] == 'deleted_agencies')
                                                                <td>
                                                                    <div class="rejected-status"><strong>Delete</strong></div>
                                                                </td>
                                                            @elseif($params['status'] == 'rejected_agencies')
                                                                <td>
                                                                    <div class="rejected-status"><strong>Reject</strong></div>
                                                                </td>

                                                            @endif
                                                            @if($params['status'] == 'verified_agencies')
                                                                <td>{{ucwords($all_listing->reviewed_by)}}</td>
                                                            @elseif($params['status'] == 'deleted_agencies')
                                                                <td>{{ucwords($all_listing->reviewed_by)}}</td>
                                                            @elseif($params['status'] == 'rejected_agencies')
                                                                <td>{{ucwords($all_listing->reviewed_by)}}</td>
                                                            @endif
                                                            <td>
                                                                @if($params['status'] != 'deleted_agencies')
                                                                    <a type="button" href="{{route('admin.agencies.add-users', $all_listing->id)}}" class="btn btn-sm btn-primary"
                                                                       data-toggle-1="tooltip"
                                                                       data-placement="bottom" title="Add user in agency">
                                                                        <i class="fas fa-user-plus"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Add Agency Users</span>
                                                                    </a>
                                                                    @if($params['status'] == 'pending_agencies')
                                                                        <a type="button" href="{{route('admin-agencies-edit', $all_listing->id)}}" class="btn btn-sm btn-warning"
                                                                           data-toggle-1="tooltip"
                                                                           data-placement="bottom" title="Edit Agency">
                                                                            Review & Activate<span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                        </a>
                                                                    @elseif($params['status'] != 'pending_agencies' )
                                                                        <a type="button" href="{{route('admin-agencies-edit', $all_listing->id)}}" class="btn btn-sm btn-warning"
                                                                           data-toggle-1="tooltip"
                                                                           data-placement="bottom" title="Edit Agency">
                                                                            <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                        </a>
                                                                        <a type="button" class="btn btn-sm btn-danger"
                                                                           data-toggle-1="tooltip"
                                                                           data-placement="bottom" title="delete"
                                                                           data-toggle="modal" data-target="#delete" data-record-id="{{$all_listing->id}}">
                                                                            <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                        </a>

                                                                    @endif
                                                                @elseif($params['status'] == 'deleted_agencies')
                                                                    <a type="button" href="{{route('admin-agencies-edit', $all_listing->id)}}" class="btn btn-sm btn-success color-black restore-btn"
                                                                       data-toggle-1="tooltip"
                                                                       data-placement="bottom" title="Edit Agency">
                                                                        Review & Restore<span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                    </a>
{{--                                                                    <a type="button" class="btn btn-sm btn-success color-black restore-btn"--}}
{{--                                                                       data-toggle-1="tooltip" data-placement="bottom"--}}
{{--                                                                       title="restore"--}}
{{--                                                                       href="javascript:void(0)"--}}
{{--                                                                       data-record-id="{{$all_listing->id}}">--}}
{{--                                                                        Review & Restore<span class="sr-only sr-only-focusable" aria-hidden="true">Restore</span>--}}
{{--                                                                    </a>--}}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="8" class="p-4 text-center">No Listings Found!</td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                                {{ $listings['all']->links() }}
                                            </div>
                                        </div>
                                        <div class="tab-pane fade {{\Illuminate\Support\Facades\Request::segments()[5] === 'key'? 'active show' : '' }}" id="listings-key" role="tabpanel"
                                             aria-labelledby="listings-key-tab">
                                            <h6>Key Agencies</h6>
                                            <div class="my-4">
                                                <table class="table table-sm table-bordered">
                                                    <thead class="theme-blue text-white">
                                                    <tr>
                                                        <td>ID</td>
                                                        <td>Title</td>
                                                        <td>address</td>
                                                        <td>City</td>
                                                        <td>Website</td>
                                                        <td>Phone</td>
                                                        <td>Listed Date</td>
                                                        @if($params['status'] != 'verified_agencies')
                                                            <td>Status Controls</td>
                                                        @endif
                                                        @if($params['status'] == 'verified_agencies')
                                                            <td>Verified By</td>
                                                        @elseif($params['status'] == 'deleted_agencies')
                                                            <td>Deleted By</td>
                                                        @endif
                                                        <td>Controls</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($listings['key'] as $key_listing)
                                                        <tr>
                                                            <td>{{ $key_listing->id }}</td>
                                                            <td>{{ $key_listing->title }}</td>
                                                            <td>{{ $key_listing->address }}</td>
                                                            <td class=" pr-3">{{ $key_listing->city }}</td>
                                                            <td>{{ $key_listing->website }}</td>
                                                            <td>{{ $key_listing->phone }}</td>
                                                            <td>{{ (new \Illuminate\Support\Carbon($key_listing->listed_date))->format('Y-m-d') }}</td>
                                                            @if($params['status'] == 'pending_agencies')
                                                                <td>
                                                                    <div class="pending-status"><strong>Pending</strong></div>
                                                                </td>
                                                            @elseif($params['status'] == 'expired_agencies')
                                                                <td>
                                                                    <div class="pending-status"><strong>Expired</strong></div>
                                                                </td>
                                                            @elseif($params['status'] == 'deleted_agencies')
                                                                <td>
                                                                    <div class="rejected-status"><strong>deleted</strong></div>
                                                                </td>
                                                            @endif
                                                            @if($params['status'] == 'verified_agencies')
                                                                <td></td>
                                                            @elseif($params['status'] == 'deleted_agencies')
                                                                <td></td>
                                                            @endif
                                                            <td>
                                                                @if($params['status'] != 'deleted_agencies')
                                                                    <a type="button" href="{{route('admin.agencies.add-users', $key_listing->id)}}" class="btn btn-sm btn-primary"
                                                                       data-toggle-1="tooltip"
                                                                       data-placement="bottom" title="Add user in agency">
                                                                        <i class="fas fa-user-plus color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true"></span>
                                                                    </a>
                                                                    <a type="button" href="{{route('admin-agencies-edit', $key_listing->id)}}" class="btn btn-sm btn-warning "
                                                                       data-toggle-1="tooltip"
                                                                       data-placement="bottom" title="Edit Agency">
                                                                        <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                    </a>
                                                                    <a type="button" class="btn btn-sm btn-danger
                                                                {{$params['status'] == 'deleted' ?' anchor-disable':''}}
                                                                        " data-toggle-1="tooltip" data-placement="bottom" title="Delete Agency"
                                                                       data-toggle="modal" data-target="#delete"
                                                                       data-record-id="{{$key_listing->id}}">
                                                                        <i class="fas fa-trash color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                    </a>
                                                                @elseif($params['status'] == 'deleted_agencies')
                                                                    <a type="button" class="btn btn-sm btn-success color-black restore-btn "
                                                                       data-toggle-1="tooltip" data-placement="bottom"
                                                                       title="Restore Agency"
                                                                       href="javascript:void(0)"
                                                                       data-record-id="{{$key_listing->id}}">
                                                                        <i class="fas fa-redo-alt color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Restore</span>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="8" class="p-4 text-center">No Listings Found!</td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>

                                                {{ $listings['key']->links() }}
                                            </div>
                                        </div>
                                        <div class="tab-pane fade {{\Illuminate\Support\Facades\Request::segments()[5] === 'featured'? 'active show' : '' }}" id="listings-featured" role="tabpanel"
                                             aria-labelledby="listings-featured-tab">
                                            <h6>Featured Agencies</h6>
                                            <div class="my-4">
                                                <table class="table table-sm table-bordered">
                                                    <thead class="theme-blue text-white">
                                                    <tr>
                                                        <td>ID</td>
                                                        <td>Title</td>
                                                        <td>address</td>
                                                        <td>City</td>
                                                        <td>Website</td>
                                                        <td>Phone</td>
                                                        <td>Listed Date</td>
                                                        @if($params['status'] != 'verified_agencies')
                                                            <td>Status Controls</td>
                                                        @endif
                                                        @if($params['status'] == 'verified_agencies')
                                                            <td>Verified By</td>
                                                        @elseif($params['status'] == 'deleted_agencies')
                                                            <td>Deleted By</td>
                                                        @endif
                                                        <td>Controls</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($listings['featured'] as $featured_listing)
                                                        <tr>
                                                            <td>{{ $featured_listing->id }}</td>
                                                            <td>{{ $featured_listing->title }}</td>
                                                            <td>{{ $featured_listing->address }}</td>
                                                            <td class="pr-3">{{ $featured_listing->city }}</td>
                                                            <td>{{ $featured_listing->website }}</td>
                                                            <td>{{ $featured_listing->phone }}</td>
                                                            <td>{{ (new \Illuminate\Support\Carbon($featured_listing->listed_date))->format('Y-m-d') }}</td>
                                                            @if($params['status'] == 'pending_agencies')
                                                                <td>
                                                                    <div class="pending-status"><strong>Pending</strong></div>
                                                                </td>
                                                            @elseif($params['status'] == 'expired_agencies')
                                                                <td>
                                                                    <div class="pending-status"><strong>Expired</strong></div>
                                                                </td>
                                                            @elseif($params['status'] == 'deleted_agencies')
                                                                <td>
                                                                    <div class="rejected-status"><strong>deleted</strong></div>
                                                                </td>
                                                            @endif
                                                            @if($params['status'] == 'verified_agencies')
                                                                <td></td>
                                                            @elseif($params['status'] == 'deleted_agencies')
                                                                <td></td>
                                                            @endif
                                                            <td>
                                                                @if($params['status'] != 'deleted_agencies')

                                                                    <a type="button" href="{{route('admin.agencies.add-users', $featured_listing->id)}}" class="btn btn-sm btn-primary"
                                                                       data-toggle-1="tooltip"
                                                                       data-placement="bottom" title="Add user in agency">
                                                                        <i class="fas fa-user-plus color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true"></span>
                                                                    </a>
                                                                    <a type="button" href="{{route('admin-agencies-edit', $featured_listing->id)}}" class="btn btn-sm btn-warning"
                                                                       data-toggle-1="tooltip"
                                                                       data-placement="bottom" title="Edit Agency">
                                                                        <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                    </a>
                                                                    <a type="button" class="btn btn-sm btn-danger" data-toggle-1="tooltip" data-placement="bottom" title="Delete Agency"
                                                                       data-toggle="modal" data-target="#delete"
                                                                       data-record-id="{{$featured_listing->id}}">
                                                                        <i class="fas fa-trash color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                    </a>
                                                                @elseif($params['status'] == 'deleted_agencies')
                                                                    <a type="button" class="btn btn-sm btn-success color-black restore-btn {{$params['status'] == 'deleted' ?'':'anchor-disable'}}"
                                                                       data-toggle-1="tooltip" data-placement="bottom"
                                                                       title="Restore Agency"
                                                                       href="javascript:void(0)"
                                                                       data-record-id="{{$featured_listing->id}}">
                                                                        <i class="fas fa-redo-alt color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Restore</span>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="8" class="p-4 text-center">No Listings Found!</td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>

                                                {{ $listings['featured']->links() }}
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
    @include('website.admin-pages.layouts.delete-modal', array('route'=>'agencies'))
@endsection

@section('script')
    {{--    <script src="{{asset('website/js/bootstrap.bundle.min.js')}}"></script>--}}
    <script>
        (function ($) {
            $(document).ready(function () {
                $('#delete').on('show.bs.modal', function (event) {
                    let record_id = $(event.relatedTarget).data('record-id');
                    $(this).find('.modal-body #record-id').val(record_id);
                });

                // $('[data-toggle-1="tooltip"]').tooltip();

                function changePropertyStatus(status, id) {
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        type: 'post',
                        url: window.location.origin + '/property' + '/admin/agency-change-status',
                        data: {'id': id, 'status': status},
                        dataType: 'json',
                        success: function (data) {
                            // console.log(data);
                            if (data.status === 200) {
                                window.location.reload(true);
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
                }

                $('.restore-btn').on('click', function () {
                        let id = $(this).attr('data-record-id');
                        let status_value = 'pending';
                        changePropertyStatus(status_value, id);
                    }
                );
                $('[name=status]').on('change', function (event) {
                    let status_value = $(this).val();
                    if ($.inArray(status_value, ['verified']) > -1) {
                        let id = $(this).attr('data-id');
                        changePropertyStatus(status_value, id);
                    }
                });

                //TODO: if page url change then change following accordingly
                $(document).on('click', '#listings-tab a', function () {
                    var tab = $(this).attr('href').split('#');
                    var special_listing = ['listings-super_hot', 'listings-magazine', 'listings-hot'];
                    if (tab[1] != null) {
                        let purpose;
                        if (special_listing.includes(tab[1])) purpose = tab[1].split("-")[1] + '_listing';
                        else purpose = tab[1].split("-")[1];
                        $('.pagination li a').each(function (index) {
                            let url = $(this).attr('href');
                            let url_piece_1 = url.split('purpose/')[0];
                            let url_piece_2 = url.split('purpose/')[1];
                            let url_piece_3 = url_piece_2.split('user/')[1];
                            let new_url = url_piece_1 + 'purpose/' + purpose + '/user/' + url_piece_3;
                            $(this).attr('href', new_url)
                        })
                    }
                });
            });
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
                    url: window.location.origin + '/property' + '/admin/agencies/accept-invitation',
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
                    url: window.location.origin + '/property' + '/admin/agencies/reject-invitation',
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
        })
        (jQuery);

    </script>
@endsection
