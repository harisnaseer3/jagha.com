@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">

    <link rel="stylesheet" href="{{asset('plugins/intl-tel-input/css/intlTelInput.min.css')}}" async defer>

@endsection

@section('content')
    @include('website.includes.dashboard-nav')
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>Agency Staff</h1>
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
                                    @include('website.agency-staff.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.flash-message')
                                    <div class="tab-content" id="listings-tabContent">
                                        <div class="float-right">
                                               <span class="pull-right"><a class="btn btn-sm transition-background color-green mr-2" href="/"><i
                                                           class="fa fa-globe mr-1"></i>Go to property.aboutpakistan.com</a></span>
                                            @php $agencies = Auth::guard('web')->user()->agencies->where('status','verified') @endphp
                                            @if(count($agencies) > 0)
                                                <a class="btn btn-sm transition-background color-green mr-2" href="{{ route('agencies.add-staff') }}"><i class="fa fa-plus-circle mr-1"></i>Add Agency Staff</a>
                                            @endif
                                        </div>

                                        <div class="tab-pane fade active show" id="listings-all" role="tabpanel"
                                             aria-labelledby="listings-all-tab">
                                            <h6>Registered Agencies Staff</h6>
                                            <div class="my-4">
                                                @if(isset($user_agencies) && count($user_agencies) > 0)
                                                    @foreach($user_agencies as $agencies)
                                                        <div class="card my-4">
                                                            <div class="card-header theme-blue text-white">
                                                                <div class="font-14 font-weight-bold text-white">{{$agencies['title']}} Staff Members ({{ucwords($agencies['status'])}})</div>
                                                            </div>
                                                            <div class="card-body">
                                                                <table class="display staff-table" style="width: 100%">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Name</th>
                                                                        <th>Membership</th>
                                                                        <th>Email</th>
                                                                        <th>Phone</th>
                                                                        <th>City</th>
                                                                        <th>Status</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @if(isset($current_agency_users) && count($current_agency_users) > 0)
                                                                        @foreach($current_agency_users as $agency_user)
                                                                            @if($agency_user->agency_id == $agencies['id'])
                                                                                <tr>
                                                                                    <td>{{$loop->iteration}}</td>
                                                                                    <td>{{$agency_user->name}}</td>
                                                                                    <td>{{$agency_user->id == $agencies['user_id'] ? 'Owner':'Member'}}</td>
                                                                                    <td>{{$agency_user->email}}</td>
                                                                                    <td>{{$agency_user->cell}}</td>
                                                                                    <td>{{ucwords($agency_user->city_name)}}</td>
                                                                                    <td>@if($agency_user->is_active === '1') Active @else Inactive @endif</td>
                                                                                    <td>
                                                                                        @if($agency_user->id != Auth::guard('web')->user()->id)

                                                                                            @if($agency_user->is_active === '0')
                                                                                                <div class='btn-group'>
                                                                                                    <a style="color: white" class="btn-sm btn btn-success" data-record-id="{{$agency_user->id}}"
                                                                                                       data-toggle="modal"
                                                                                                       data-target="#status-modal">Activate</a>
                                                                                                </div>
                                                                                            @elseif($agency_user->is_active === '1')
                                                                                                <div class='btn-group'>
                                                                                                    <a style="color: white" class="btn-sm btn btn-danger" data-record-id="{{$agency_user->id}}"
                                                                                                       data-toggle="modal"
                                                                                                       data-target="#status-modal">Deactivate</a>
                                                                                                </div>
                                                                                            @endif
                                                                                        @endif

                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endforeach
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
    @include('website.layouts.change-user-status')

@endsection

@section('script')
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('website/js/agency-users.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>

    <script>
        (function ($) {
            $('#status-modal').on('show.bs.modal', function (event) {
                let record_id = $(event.relatedTarget).data('record-id');
                $(this).find('.modal-body #agency-user-id').val(record_id);
            });

            $('.staff-table').DataTable(
                {
                    "scrollX": true,
                    "ordering": false,
                    // responsive: true
                }
            );
        })(jQuery);
    </script>
@endsection
