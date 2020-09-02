@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Property Management By https://www.aboutpakistan.com</title>
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
                        <div class="tab-pane fade" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                            <div class="my-4">
                                Dashboard
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="property_management" role="tabpanel" aria-labelledby="property_management-tab">
                            <div class="row my-4">
                                <div class="col-md-3">
                                    @include('website.includes.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.flash-message')

                                    <div class="tab-content" id="listings-tabContent">
                                        <div class="float-right"><a class="btn btn-sm theme-blue text-white" href="{{route('properties.create')}}">Post New Listing</a> </div>
                                        <div class="tab-pane fade show active" id="listings-all" role="tabpanel" aria-labelledby="listings-all-tab">
                                            <h6>All Listings</h6>
                                            <div class="my-4">
                                                <table class="table table-sm table-bordered">
                                                    <thead class="theme-blue text-white">
                                                    <tr>
                                                        <td>ID</td>
                                                        <td>Type</td>
                                                        <td>Location</td>
                                                        <td>Price (PKR)</td>
                                                        <td>Listed Date</td>
                                                        <td>Quota Used</td>
                                                        <td>Image Views</td>
                                                        <td>Controls</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($listings['all'] as $all_listing)
                                                        <tr>
                                                            <td>{{ $all_listing->id }}</td>
                                                            <td>{{ $all_listing->type }}</td>
                                                            <td>{{ $all_listing->location }}</td>
                                                            <td class="text-right pr-3">{{ $all_listing->price}}</td>
                                                            <td>{{ (new \Illuminate\Support\Carbon($all_listing->listed_date))->format('Y-m-d') }}</td>
                                                            <td>{{ $all_listing->quota_used }}</td>
                                                            <td>{{ $all_listing->image_views }}</td>
                                                            <td>
                                                                <a type="button" href="{{route('properties.edit', $all_listing->id)}}" class="btn btn-sm btn-warning" data-toggle-1="tooltip"
                                                                   data-placement="bottom" title="edit">
                                                                    <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                </a>
                                                                <a type="button" class="btn btn-sm btn-danger" data-toggle-1="tooltip" data-placement="bottom" title="delete"
                                                                   data-toggle="modal" data-target="#delete"
                                                                   data-record-id="{{$all_listing->id}}">
                                                                    <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
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
                                        <div class="tab-pane fade" id="listings-sale" role="tabpanel" aria-labelledby="listings-sale-tab">
                                            <h6>For Sale</h6>
                                            <div class="my-4">
                                                <table class="table table-sm table-bordered">
                                                    <thead class="theme-blue text-white">
                                                    <tr>
                                                        <td>ID</td>
                                                        <td>Type</td>
                                                        <td>Location</td>
                                                        <td>Price (PKR)</td>
                                                        <td>Listed Date</td>
                                                        <td>Quota Used</td>
                                                        <td>Image Views</td>
                                                        <td>Controls</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($listings['sale'] as $sale_listing)
                                                        <tr>
                                                            <td>{{ $sale_listing->id }}</td>
                                                            <td>{{ $sale_listing->type }}</td>
                                                            <td>{{ $sale_listing->location }}</td>
                                                            <td class="text-right pr-3">{{ $sale_listing->price }}</td>
                                                            <td>{{ (new \Illuminate\Support\Carbon($sale_listing->listed_date))->format('Y-m-d') }}</td>
                                                            <td>{{ $sale_listing->quota_used }}</td>
                                                            <td>{{ $sale_listing->image_views }}</td>
                                                            <td>
                                                                <a type="button" href="{{route('properties.edit', $sale_listing->id)}}" class="btn btn-sm btn-warning" data-toggle-1="tooltip"
                                                                   data-placement="bottom" title="edit">
                                                                    <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                </a>
                                                                <a type="button" class="btn btn-sm btn-danger" data-toggle-1="tooltip" data-placement="bottom" title="delete"
                                                                   data-toggle="modal" data-target="#delete"
                                                                   data-record-id="{{$sale_listing->id}}">
                                                                    <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
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

                                                {{ $listings['sale']->fragment('listings-sale')->links() }}
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="listings-rent" role="tabpanel" aria-labelledby="listings-rent-tab">
                                            <h6>For Rent</h6>
                                            <div class="my-4">
                                                <table class="table table-sm table-bordered">
                                                    <thead class="theme-blue text-white">
                                                    <tr>
                                                        <td>ID</td>
                                                        <td>Type</td>
                                                        <td>Location</td>
                                                        <td>Price (PKR)</td>
                                                        <td>Listed Date</td>
                                                        <td>Quota Used</td>
                                                        <td>Image Views</td>
                                                        <td>Controls</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($listings['rent'] as $rent_listing)
                                                        <tr>
                                                            <td>{{ $rent_listing->id }}</td>
                                                            <td>{{ $rent_listing->type }}</td>
                                                            <td>{{ $rent_listing->location }}</td>
                                                            <td class="text-right pr-3">{{ $rent_listing->price }}</td>
                                                            <td>{{ (new \Illuminate\Support\Carbon($rent_listing->listed_date))->format('Y-m-d') }}</td>
                                                            <td>{{ $rent_listing->quota_used }}</td>
                                                            <td>{{ $rent_listing->image_views }}</td>
                                                            <td>
                                                                <a type="button" href="{{route('properties.edit', $rent_listing->id)}}" class="btn btn-sm btn-warning" data-toggle-1="tooltip"
                                                                   data-placement="bottom" title="edit">
                                                                    <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                </a>
                                                                <a type="button" class="btn btn-sm btn-danger" data-toggle-1="tooltip" data-placement="bottom" title="delete"
                                                                   data-toggle="modal" data-target="#delete"
                                                                   data-record-id="{{$rent_listing->id}}">
                                                                    <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
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

                                                {{ $listings['rent']->links() }}
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="listings-wanted" role="tabpanel" aria-labelledby="listings-wanted-tab">
                                            <h6>For Wanted</h6>
                                            <div class="my-4">
                                                <table class="table table-sm table-bordered">
                                                    <thead class="theme-blue text-white">
                                                    <tr>
                                                        <td>ID</td>
                                                        <td>Type</td>
                                                        <td>Location</td>
                                                        <td>Price (PKR)</td>
                                                        <td>Listed Date</td>
                                                        <td>Quota Used</td>
                                                        <td>Image Views</td>
                                                        <td>Controls</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($listings['wanted'] as $wanted_listing)
                                                        <tr>
                                                            <td>{{ $wanted_listing->id }}</td>
                                                            <td>{{ $wanted_listing->type }}</td>
                                                            <td>{{ $wanted_listing->location }}</td>
                                                            <td class="text-right pr-3">{{ $wanted_listing->price }}</td>
                                                            <td>{{ (new \Illuminate\Support\Carbon($wanted_listing->listed_date))->format('Y-m-d') }}</td>
                                                            <td>{{ $wanted_listing->quota_used }}</td>
                                                            <td>{{ $wanted_listing->image_views }}</td>
                                                            <td>
                                                                <a type="button" href="{{route('properties.edit', $wanted_listing->id)}}" class="btn btn-sm btn-warning" data-toggle-1="tooltip"
                                                                   data-placement="bottom" title="edit">
                                                                    <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                </a>
                                                                <a type="button" class="btn btn-sm btn-danger" data-toggle-1="tooltip" data-placement="bottom" title="delete"
                                                                   data-toggle="modal" data-target="#delete"
                                                                   data-record-id="{{$wanted_listing->id}}">
                                                                    <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
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

                                                {{ $listings['wanted']->links() }}
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="listings-super_hot" role="tabpanel" aria-labelledby="listings-super_hot-tab">
                                            <h6>Super Hot Listings</h6>
                                            <div class="my-4">
                                                <table class="table table-sm table-bordered">
                                                    <thead class="theme-blue text-white">
                                                    <tr>
                                                        <td>ID</td>
                                                        <td>Type</td>
                                                        <td>Location</td>
                                                        <td>Price (PKR)</td>
                                                        <td>Listed Date</td>
                                                        <td>Quota Used</td>
                                                        <td>Image Views</td>
                                                        <td>Controls</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($listings['super_hot'] as $super_hot_listing)
                                                        <tr>
                                                            <td>{{ $super_hot_listing->id }}</td>
                                                            <td>{{ $super_hot_listing->type }}</td>
                                                            <td>{{ $super_hot_listing->location }}</td>
                                                            <td class="text-right pr-3">{{ $super_hot_listing->price}}</td>
                                                            <td>{{ (new \Illuminate\Support\Carbon($super_hot_listing->listed_date))->format('Y-m-d') }}</td>
                                                            <td>{{ $super_hot_listing->quota_used }}</td>
                                                            <td>{{ $super_hot_listing->image_views }}</td>
                                                            <td>
                                                                <a type="button" href="{{route('properties.edit', $super_hot_listing->id)}}" class="btn btn-sm btn-warning" data-toggle-1="tooltip"
                                                                   data-placement="bottom" title="edit">
                                                                    <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                </a>
                                                                <a type="button" class="btn btn-sm btn-danger" data-toggle-1="tooltip" data-placement="bottom" title="delete"
                                                                   data-toggle="modal" data-target="#delete"
                                                                   data-record-id="{{$super_hot_listing->id}}">
                                                                    <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
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

                                                {{ $listings['super_hot']->links() }}
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="listings-hot" role="tabpanel" aria-labelledby="listings-hot-tab">
                                            <h6>Hot Listings</h6>
                                            <div class="my-4">
                                                <table class="table table-sm table-bordered">
                                                    <thead class="theme-blue text-white">
                                                    <tr>
                                                        <td>ID</td>
                                                        <td>Type</td>
                                                        <td>Location</td>
                                                        <td>Price (PKR)</td>
                                                        <td>Listed Date</td>
                                                        <td>Quota Used</td>
                                                        <td>Image Views</td>
                                                        <td>Controls</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($listings['hot'] as $hot_listing)
                                                        <tr>
                                                            <td>{{ $hot_listing->id }}</td>
                                                            <td>{{ $hot_listing->type }}</td>
                                                            <td>{{ $hot_listing->location }}</td>
                                                            <td class="text-right pr-3">{{ $hot_listing->price }}</td>
                                                            <td>{{ (new \Illuminate\Support\Carbon($hot_listing->listed_date))->format('Y-m-d') }}</td>
                                                            <td>{{ $hot_listing->quota_used }}</td>
                                                            <td>{{ $hot_listing->image_views }}</td>
                                                            <td>
                                                                <a type="button" href="{{route('properties.edit', $hot_listing->id)}}" class="btn btn-sm btn-warning" data-toggle-1="tooltip"
                                                                   data-placement="bottom" title="edit">
                                                                    <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                </a>
                                                                <a type="button" class="btn btn-sm btn-danger" data-toggle-1="tooltip" data-placement="bottom" title="delete"
                                                                   data-toggle="modal" data-target="#delete" data-record-id="{{$hot_listing->id}}">
                                                                    <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
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

                                                {{ $listings['hot']->links() }}
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="listings-magazine" role="tabpanel" aria-labelledby="listings-magazine-tab">
                                            <h6>Magazine Listings</h6>
                                            <div class="my-4">
                                                <table class="table table-sm table-bordered">
                                                    <thead class="theme-blue text-white">
                                                    <tr>
                                                        <td>ID</td>
                                                        <td>Type</td>
                                                        <td>Location</td>
                                                        <td>Price (PKR)</td>
                                                        <td>Listed Date</td>
                                                        <td>Quota Used</td>
                                                        <td>Image Views</td>
                                                        <td>Controls</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($listings['magazine'] as $magazine_listing)
                                                        <tr>
                                                            <td>{{ $magazine_listing->id }}</td>
                                                            <td>{{ $magazine_listing->type }}</td>
                                                            <td>{{ $magazine_listing->location }}</td>
                                                            <td class="text-right pr-3">{{ $magazine_listing->price }}</td>
                                                            <td>{{ (new \Illuminate\Support\Carbon($magazine_listing->listed_date))->format('Y-m-d') }}</td>
                                                            <td>{{ $magazine_listing->quota_used }}</td>
                                                            <td>{{ $magazine_listing->image_views }}</td>
                                                            <td>
                                                                <a type="button" href="{{route('properties.edit', $magazine_listing->id)}}" class="btn btn-sm btn-warning" data-toggle-1="tooltip"
                                                                   data-placement="bottom" title="edit">
                                                                    <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                </a>
                                                                <a type="button" class="btn btn-sm btn-danger" data-toggle-1="tooltip" data-placement="bottom" title="delete"
                                                                   data-toggle="modal" data-target="#delete" data-record-id="{{$magazine_listing->id}}">
                                                                    <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
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

                                                {{ $listings['magazine']->links() }}
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
{{--    @include('website.includes.footer')--}}
    @include('website.layouts.delete-modal', array('route'=>'properties'))
@endsection

@section('script')
    <script>
        (function ($) {
            $(document).ready(function () {
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
                            url: window.location.origin + '/property' + '/login',
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
                                    let user_name = data.user.name;
                                    let user_id = data.user.id;
                                    let html =
                                        '            <div class="dropdown">' +
                                        '                <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="javascript:void(0);" id="dropdownMenuButton" aria-haspopup="true"' +
                                        '                    aria-expanded="false">' +
                                        '                      <i class="fas fa-user mr-3"></i>';
                                    html += '<span class="mr-1"> Logged in as <span>'+ user_name ;
                                    html += '</a>' +
                                        '                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                                    html += '<a class="dropdown-item" href=" ' + window.location.origin + '/property' + '/dashboard/accounts/users/' + user_id + '/edit"><i class="far fa-user-cog mr-2"></i>Manage Profile</a>' +
                                        '                     <div class="dropdown-divider"></div>' +
                                        // '<a class="dropdown-item" href=" ' + window.location.origin + '/property/dashboard/properties/create"><i class="fa fa-building-o mr-2"></i>Property Managment </a>' +
                                        '<a class="dropdown-item" href=" ' + window.location.origin + '/dashboard/listings/status/active/purpose/all/user/'+user_id +'/sort/id/order/asc/page/10"><i class="fa fa-building-o mr-2"></i>Property Management </a>' +
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
            });
        })(jQuery);
    </script>
@endsection
