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
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>Agency Listings</h1>
            </div>
        </div>
    </div>
    <!-- Submit Property start -->
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content" id="ListingsTabContent">
                        <div class="tab-pane fade" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                            <div class="my-4">
                                Dashboard
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="property_management" role="tabpanel" aria-labelledby="property_management-tab">
                            <div class="row my-4">
                                <div class="col-md-3">
                                    @include('website.agency.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.flash-message')

                                    <div class="tab-content" id="listings-tabContent">
                                        <div class="float-right"><a class="btn btn-sm theme-blue text-white" href="{{route('agencies.create')}}">Add New Agency</a></div>

                                        <div class="tab-pane fade show active" id="listings-all" role="tabpanel" aria-labelledby="listings-all-tab">
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
                                                        @if($params['status'] == 'pending_agencies')
                                                            <td>Status Controls</td>
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
                                                                <td><input type="radio" name="status" value="verified" data-id="{{ $all_listing->id }}">
                                                                    <label for="active">Activate</label>
                                                                </td>
                                                            @endif
                                                            <td>
                                                                <a type="button" href="{{route('agencies.add-users', $all_listing->id)}}" class="btn btn-sm btn-primary
                                                                {{$params['status'] == 'deleted_agencies' ? 'anchor-disable':'' }}
                                                                    " data-toggle-1="tooltip"
                                                                   data-placement="bottom" title="Add user in agency">
                                                                    <i class="fas fa-user-plus"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Add Agency Users</span>
                                                                </a>
                                                                <a type="button" href="{{route('agencies.edit', $all_listing->id)}}" class="btn btn-sm btn-warning
                                                                {{$params['status'] == 'deleted_agencies' ? 'anchor-disable':'' }}
                                                                    " data-toggle-1="tooltip"
                                                                   data-placement="bottom" title="Edit Agency">
                                                                    <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                </a>
                                                                <a type="button" class="btn btn-sm btn-danger
                                                                {{$params['status'] == 'deleted_agencies' ?' anchor-disable':''}}
                                                                    " data-toggle-1="tooltip" data-placement="bottom" title="Delete Agency"
                                                                   data-toggle="modal" data-target="#delete"
                                                                   data-record-id="{{$all_listing->id}}">
                                                                    <i class="fas fa-trash color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                </a>
                                                                <a type="button" class="btn btn-sm btn-success color-black restore-btn {{$params['status'] == 'deleted_agencies' ?'':'anchor-disable'}}"
                                                                   data-toggle-1="tooltip" data-placement="bottom"
                                                                   title="restore"
                                                                   href="javascript:void(0)"
                                                                   data-record-id="{{$all_listing->id}}">
                                                                    <i class="fas fa-redo-alt"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Restore</span>
                                                                </a>
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
                                        <div class="tab-pane fade" id="listings-key" role="tabpanel" aria-labelledby="listings-key-tab">
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
                                                        @if($params['status'] == 'pending_agencies')
                                                            <td>Status Controls</td>
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
                                                                <td><input type="radio" name="status" value="verified" data-id="{{ $key_listing->id }}">
                                                                    <label for="active">Activate</label>
                                                                </td>
                                                            @endif
                                                            <td>
                                                                <a type="button" href="{{route('agencies.edit', $key_listing->id)}}" class="btn btn-sm btn-primary
                                                                {{$params['status'] == 'deleted_agencies' ? 'anchor-disable':'' }}
                                                                    " data-toggle-1="tooltip"
                                                                   data-placement="bottom" title="Add user in agency">
                                                                    <i class="fas fa-user-plus color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true"></span>
                                                                </a>

                                                                <a type="button" href="{{route('agencies.edit', $key_listing->id)}}" class="btn btn-sm btn-warning
                                                                {{$params['status'] == 'deleted' ? 'anchor-disable':'' }}
                                                                {{$params['status'] == 'sold' ? 'anchor-disable':'' }}
                                                                    " data-toggle-1="tooltip"
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
                                                                <a type="button" class="btn btn-sm btn-success color-black restore-btn {{$params['status'] == 'deleted' ?'':'anchor-disable'}}"
                                                                   data-toggle-1="tooltip" data-placement="bottom"
                                                                   title="Restore Agency"
                                                                   href="javascript:void(0)"
                                                                   data-record-id="{{$key_listing->id}}">
                                                                    <i class="fas fa-redo-alt color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Restore</span>
                                                                </a>
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
                                        <div class="tab-pane fade" id="listings-featured" role="tabpanel" aria-labelledby="listings-featured-tab">
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
                                                        @if($params['status'] == 'pending_agencies')
                                                            <td>Status Controls</td>
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
                                                                <td><input type="radio" name="status" value="verified" data-id="{{ $featured_listing->id }}">
                                                                    <label for="active">Activate</label>
                                                                </td>
                                                            @endif
                                                            <td>
                                                                <a type="button" href="{{route('agencies.edit', $featured_listing->id)}}" class="btn btn-sm btn-primary
                                                                {{$params['status'] == 'deleted_agencies' ? 'anchor-disable':'' }}
                                                                    " data-toggle-1="tooltip"
                                                                   data-placement="bottom" title="Add user in agency">
                                                                    <i class="fas fa-user-plus color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true"></span>
                                                                </a>
                                                                <a type="button" href="{{route('agencies.edit', $featured_listing->id)}}" class="btn btn-sm btn-warning
                                                                {{$params['status'] == 'deleted' ? 'anchor-disable':'' }}
                                                                {{$params['status'] == 'sold' ? 'anchor-disable':'' }}
                                                                    " data-toggle-1="tooltip"
                                                                   data-placement="bottom" title="Edit Agency">
                                                                    <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                </a>
                                                                <a type="button" class="btn btn-sm btn-danger
                                                                {{$params['status'] == 'deleted' ?' anchor-disable':''}}
                                                                    " data-toggle-1="tooltip" data-placement="bottom" title="Delete Agency"
                                                                   data-toggle="modal" data-target="#delete"
                                                                   data-record-id="{{$featured_listing->id}}">
                                                                    <i class="fas fa-trash color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                </a>
                                                                <a type="button" class="btn btn-sm btn-success color-black restore-btn {{$params['status'] == 'deleted' ?'':'anchor-disable'}}"
                                                                   data-toggle-1="tooltip" data-placement="bottom"
                                                                   title="Restore Agency"
                                                                   href="javascript:void(0)"
                                                                   data-record-id="{{$featured_listing->id}}">
                                                                    <i class="fas fa-redo-alt color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Restore</span>
                                                                </a>
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
                        <div class="tab-pane fade" id="message_center" role="tabpanel" aria-labelledby="message_center-tab">
                            <div class="my-4">
                                Message Center
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account_profile" role="tabpanel" aria-labelledby="account_profile-tab">
                            <div class="my-4">
                                My Accounts &amp; Profiles
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reports" role="tabpanel" aria-labelledby="reports-tab">
                            <div class="my-4">
                                Reports
                            </div>
                        </div>
                        <div class="tab-pane fade" id="agency_staff" role="tabpanel" aria-labelledby="agency_staff-tab">
                            <div class="my-4">
                                Agency Staff
                            </div>
                        </div>
                        <div class="tab-pane fade" id="clients_leads" role="tabpanel" aria-labelledby="clients_leads-tab">
                            <div class="my-4">
                                Clients &amp; Leads
                            </div>
                        </div>
                        <div class="tab-pane fade" id="agency_website" role="tabpanel" aria-labelledby="agency_website-tab">
                            <div class="my-4">
                                Agency Website
                            </div>
                        </div>
                        <div class="tab-pane fade" id="advertise" role="tabpanel" aria-labelledby="advertise-tab">
                            <div class="my-4">
                                Advertise
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer start -->
    @include('website.includes.footer')
    @include('website.layouts.delete-modal', array('route'=>'agencies'))
@endsection

@section('script')
    <script src="{{asset('website/js/bootstrap.bundle.min.js')}}"></script>
    <script>
        (function ($) {
            $(document).ready(function () {
                $('[data-toggle-1="tooltip"]').tooltip();
                function changePropertyStatus(status, id) {
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        type: 'post',
                        url: window.location.origin + '/property' + '/dashboard/agency-change-status',
                        data: {'id': id, 'status': status},
                        dataType: 'json',
                        success: function (data) {
                            // console.log(data);
                            if (data.status === 200) {
                                // console.log(data.location);
                                // console.log(data.city);
                                // console.log(data.status);
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

                $('#delete').on('show.bs.modal', function (event) {
                    let record_id = $(event.relatedTarget).data('record-id');
                    $(this).find('.modal-body #record-id').val(record_id);
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
        })
        (jQuery);
    </script>
@endsection
