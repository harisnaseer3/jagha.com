@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Property Management By https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">

@endsection

@section('content')
    <div id="site" class="left relative" >
        <div id="site-wrap" class="left relative" >
    @include('website.admin-pages.includes.admin-nav')
    <div style="min-height:90px"></div>
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content" id="ListingsTabContent">
                        <div class="tab-pane fade show active" id="property_management" role="tabpanel" aria-labelledby="property_management-tab">
                            <div class="row my-4">
                                <div class="col-md-3">
                                    @include('website.admin-pages.includes.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.flash-message')
                                    <div class="tab-content" id="listings-tabContent">
                                        <div class="float-right">
                                            {{ Form::open(['route' => ['admin.property.search.id'], 'method' => 'post', 'role' => 'form','class'=>'px-3 nav-link color-555', 'style' => 'max-width:300px;' ,'id'=>'search-property-ref']) }}
                                            <input class="px-3 property-id text-transform" type="text" placeholder="Property ID" name="property_id" id="property_id"
                                                   autocomplete="false" required>
                                            <i class="fa fa-search ml-1"></i>
                                            {{ Form::close() }}
                                        </div>
                                        @foreach(['all', 'sale', 'rent','wanted','basic','bronze','silver','golden','platinum'] as $option)

                                            <div class="tab-pane fade show {{\Illuminate\Support\Facades\Request::segments()[5] === $option? 'active' : '' }}" id="listings-{{$option}}"
                                                 role="tabpanel" aria-labelledby="listings-{{$option}}-tab">
                                                <h6>{{ucwords($option)}} Listings</h6>
                                                <div class="my-4">
                                                    <div class="table-responsive">
                                                        {{--                                                        <table class="table table-sm table-bordered">--}}
                                                        {{--                                                        <table class="property-listing {{\Illuminate\Support\Facades\Request::segments()[5] === $option? 'display' : '' }}" style="width: 100%">--}}
                                                        <table class="table table-sm table-bordered">
                                                            <thead class="theme-blue text-white">
                                                            <tr>
                                                                <td>ID</td>
                                                                <td>Type</td>
                                                                <td>Location</td>
                                                                <td>Price (PKR)</td>
                                                                <td>Listed Date</td>
                                                                @if($params['status'] == 'active')
                                                                    <td>Activation Date</td>
                                                                    <td>Activated By</td>
                                                                    <td>Boost</td>
                                                                @endif
                                                                @if($params['status'] == 'rejected')
                                                                    <td>Rejected By</td>
                                                                @elseif($params['status'] == 'deleted')
                                                                    <td>Deleted By</td>
                                                                @endif
                                                                <td>Status Controls</td>
                                                                <td>Controls</td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            @if($listings[$option] !== null)
                                                            @forelse($listings[$option] as $all_listing)
                                                                <tr>
                                                                    <td>{{ $all_listing->id }}</td>
                                                                    <td>{{ $all_listing->type }}</td>
                                                                    <td>{{ $all_listing->location }}, {{$all_listing->city}}</td>
                                                                    @if($all_listing->price != '0')
                                                                        <td class="text-right pr-3">{{  $all_listing->price}}</td>
                                                                    @else
                                                                        <td class="pr-3">{{ 'Call option selected for price'}}</td>
                                                                    @endif
                                                                    <td>{{ (new \Illuminate\Support\Carbon($all_listing->listed_date))->format('Y-m-d') }}</td>
                                                                    @if($params['status'] == 'active')
                                                                        <td>{{ (new \Illuminate\Support\Carbon($all_listing->activated_at))->format('Y-m-d') }} <p>Will Expire
                                                                                in {{(new \Illuminate\Support\Carbon($all_listing->expired_at))->diffInDays(new \Illuminate\Support\Carbon(now()))}} days </p>
                                                                        </td>
                                                                        <td>@if(isset($all_listing->reviewed_by)) {{ucwords($all_listing->reviewed_by)}}@endif</td>
                                                                        <td>
                                                                            <span>Boost Count : 0</span>
                                                                            <a href="javascript:void(0)" class="btn btn-sm btn-success pull-right disabled">Click to Boost</a>
                                                                        </td>
                                                                    @endif
                                                                    @if($params['status'] == 'rejected' || $params['status'] == 'deleted' )
                                                                        <td>@if(isset($all_listing->reviewed_by)) {{ucwords($all_listing->reviewed_by)}}@endif</td>
                                                                    @endif
                                                                    <td>
                                                                        @if($params['status'] == 'deleted')
                                                                            <div class="rejected-status"><strong>Deleted</strong></div>
                                                                        @elseif($params['status'] == 'edited')
                                                                            <div class="pending-status"><strong>Edit</strong></div>
                                                                        @elseif($params['status'] === 'sold')
                                                                            <div class="sold-status"><strong>Property Sold</strong></div>
                                                                        @elseif($params['status'] === 'pending')
                                                                            <div class="pending-status"><strong>Pending</strong></div>
                                                                        @elseif($params['status'] === 'rejected')
                                                                            <div class="rejected-status"><strong>Rejected</strong></div>
                                                                        @else
                                                                            <form>
                                                                                @if($params['status'] == 'active')
                                                                                    <input type="radio" name="status" value="active"
                                                                                           {{$all_listing->status === 'active'? 'checked':'' }}
                                                                                           data-id="{{ $all_listing->id }}">
                                                                                    <label for="active">Active</label>
                                                                                @endif
                                                                                @if($params['status'] != 'active')
                                                                                    <input type="radio" name="status" value="reactive"
                                                                                           {{$all_listing->status === 'active'? 'disabled':'' }}
                                                                                           data-id="{{ $all_listing->id }}">
                                                                                    <label for="active">Reactive</label>
                                                                                @endif
                                                                                @if($params['status'] != 'expired')
                                                                                    <input type="radio" name="status" value="expired"
                                                                                           {{$all_listing->status === 'expired'? 'checked':'' }}
                                                                                           {{$all_listing->status === 'edited'? 'disabled':'' }}
                                                                                           {{$all_listing->status === 'sold'? 'checked':'' }}
                                                                                           data-id="{{ $all_listing->id }}" {{$all_listing->status === 'expired'? 'checked':'' }}>
                                                                                    <label for="expired">Expired</label>
                                                                                @endif
                                                                                @if($params['status'] != 'sold')
                                                                                    <input type="radio" name="status" value="sold"
                                                                                           data-id="{{ $all_listing->id }}" {{$all_listing->status === 'sold'? 'checked':'' }}{{$all_listing->status === 'edited'? 'disabled':'' }}>
                                                                                    <label for="sold">Sold</label>
                                                                                @endif
                                                                            </form>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if($params['status'] === 'pending')
                                                                            <a type="button" href="{{route('admin-properties-edit', $all_listing->id)}}"
                                                                               class="btn btn-sm btn-info
                                                                            {{$params['status'] == 'deleted' ? 'anchor-disable':'' }}
                                                                               {{$params['status'] == 'sold' ? 'anchor-disable':'' }}"
                                                                               data-toggle-1="tooltip"
                                                                               data-placement="bottom" title="Verify and Activate">
                                                                                Verify & Activate
                                                                                <span class="sr-only sr-only-focusable" aria-hidden="true">Verify and Activate</span>
                                                                            </a>
                                                                        @elseif($params['status'] != 'deleted')
                                                                            @if($params['status'] != 'sold')
                                                                                <a type="button" href="{{route('admin-properties-edit', $all_listing->id)}}"
                                                                                   class="btn btn-sm btn-warning  {{$params['status'] == 'sold' ? 'anchor-disable':'' }}"
                                                                                   data-toggle-1="tooltip" data-placement="bottom" title="edit">
                                                                                    <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                                </a>
                                                                            @endif
                                                                            <a type="button" class="btn btn-sm btn-danger"
                                                                               data-toggle-1="tooltip" data-placement="bottom" title="delete" data-toggle="modal" data-target="#delete"
                                                                               data-record-id="{{$all_listing->id}}">
                                                                                <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                            </a>
                                                                        @elseif($params['status'] == 'deleted')
                                                                            <a type="button" href="{{route('admin-properties-edit', $all_listing->id)}}"
                                                                               class="btn btn-sm btn-warning  {{$params['status'] == 'sold' ? 'anchor-disable':'' }}"
                                                                               data-toggle-1="tooltip" data-placement="bottom" title="restore">
                                                                                Review & Restore<span class="sr-only sr-only-focusable" aria-hidden="true">restore</span>
                                                                            </a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="10" class="p-4 text-center">No Listings Found!</td>
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
                                                    @if($listings[$option] != null)
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
        </div>
    </div>
    @include('website.admin-pages.layouts.delete-modal', array('route'=>'properties'))
@endsection

@section('script')
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>

    <script>
        (function ($) {
            $(document).ready(function () {

                // function validate()
                // {
                //     console.log('called');
                //     let value = $('#property_id').val();
                //     var letterNumber = /[0-9 ]+/;
                //     if((value.match(letterNumber)))
                //     {
                //         return true;
                //     }
                //     else
                //     {
                //         alert('Please Enter numeric value in search bar');
                //         return false;
                //     }
                // }
                $('.property-listing').DataTable(
                    {
                        "paging": false,
                        "scrollY": false,
                        // "ordering": false,
                        // "info":     false
                    }
                );

                $('#delete').on('show.bs.modal', function (event) {
                    let record_id = $(event.relatedTarget).data('record-id');
                    $(this).find('.modal-body #record-id').val(record_id);
                });

                //TODO: if page url change then change following accordingly
                $(document).on('click', '#listings-tab a', function () {
                    var tab = $(this).attr('href').split('#');
                    var special_listing = ['basic', 'silver', 'bronze', 'golden', 'platinum'];
                    if (tab[1] != null) {
                        let purpose;
                        if (special_listing.includes(tab[1])) purpose = tab[1].split("-")[1] + '_listing';
                        else purpose = tab[1].split("-")[1];
                        $('.pagination li a').each(function (index) {
                            let url = $(this).attr('href');
                            let url_piece_1 = url.split('purpose/')[0];
                            let url_piece_2 = url.split('purpose/')[1];
                            let url_piece_3 = url_piece_2.split('admin/')[1];
                            let new_url = url_piece_1 + 'purpose/' + purpose + '/admin/' + url_piece_3;
                            $(this).attr('href', new_url)
                        })
                    }
                });
                $('#sign-in-btn').click(function (event) {
                    if (form.valid()) {
                        event.preventDefault();
                        jQuery.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        event.preventDefault();
                        jQuery.ajax({
                            type: 'post',
                            url: window.location.origin  + '/login',
                            data: form.serialize(),
                            dataType: 'json',
                            success: function (data) {
                                // console.log(data);
                                if (data.data) {
                                    // console.log(data.user);
                                    $('.error-tag').hide();
                                    $('#exampleModalCenter').modal('hide');
                                    let user_dropdown = $('.user-dropdown')
                                    user_dropdown.html('');
                                    let user_name = data.user.name + ' (ID: ' + user_id + ')';
                                    let user_id = data.user.id;
                                    let html =
                                        '            <div class="dropdown">' +
                                        '                <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="javascript:void(0);" id="dropdownMenuButton" aria-haspopup="true"' +
                                        '                    aria-expanded="false">' +
                                        '                      <i class="fas fa-user mr-3"></i>';
                                    html += '<span class="mr-1"> Logged in as <span>' + user_name;
                                    html += '</a>' +
                                        '                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                                    html += '<a class="dropdown-item" href=" ' + window.location.origin  + '/dashboard/accounts/users/' + user_id + '/edit"><i class="far fa-user-cog mr-2"></i>Manage Profile</a>' +
                                        '                     <div class="dropdown-divider"></div>' +
                                        // '<a class="dropdown-item" href=" ' + window.location.origin + '/property/dashboard/properties/create"><i class="fa fa-building-o mr-2"></i>Property Managment </a>' +
                                        '<a class="dropdown-item" href=" ' + window.location.origin  + '/dashboard/listings/status/active/purpose/all/user/' + user_id + '/sort/id/order/asc/page/10"><i class="fa fa-building-o mr-2"></i>Property Management </a>' +
                                        '                     <div class="dropdown-divider"></div>' +
                                        '                          <a class="dropdown-item" href="{{route("accounts.logout")}}"><i class="far fa-sign-out mr-2"></i>Logout</a>';
                                    html += '</div>' + '</div>';

                                    user_dropdown.html(html);
                                    // window.location.reload(true);
                                } else if (data.error) {
                                    $('div.help-block small').html(data.error.password);
                                    $('.error-tag').show();
                                }
                            },
                            error: function (xhr, status, error) {
                                event.preventDefault();

                                // console.log(error);
                                // console.log(status);
                                // console.log(xhr);
                            },
                            complete: function (url, options) {
                            }
                        });
                    }
                });

                function changePropertyStatus(status, id) {
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        type: 'post',
                        url: window.location.origin  + '/admin/change-status',
                        data: {'id': id, 'status': status},
                        dataType: 'json',
                        success: function (data) {
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
                    changePropertyStatus('pending', id);
                });
                $('[name=status]').on('change', function (event) {
                    let status_value = $(this).val();
                    if ($.inArray(status_value, ['active', 'reactive', 'sold', 'expired', 'boost']) > -1) {
                        if (status_value === 'reactive') {
                            status_value = 'pending'
                        }
                        let id = $(this).attr('data-id');
                        changePropertyStatus(status_value, id);
                    }
                });


            });
        })(jQuery);
    </script>
@endsection
