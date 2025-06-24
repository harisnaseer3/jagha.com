@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>Jagha - Buy Sell Rent Homes & Properties In Pakistan by https://www.jagha.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">
    <style>
        .popover {
            background: lightgrey;
        }

        .unread {
            color: #721c24;
            background-color: #f8d7da !important;
            border-color: black;
        }

    </style>

@endsection

@section('content')
    @include('website.includes.dashboard-nav')
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>Message Center</h1>
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
                                <div class="col-12 mb-2">
                                    <div class="float-right">

                                               <span class="pull-right"><a class="btn btn-sm transition-background color-green mr-2" href="/"><i
                                                           class="fa fa-globe mr-1"></i>Go to jagha.com</a></span>
                                        <span class="pull-right"><a class="btn btn-sm transition-background color-green mr-2" href="{{route('aboutpakistan.support')}}"><i
                                                    class="fa fa-plus-circle mr-1"></i>Send New Message</a></span>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    @include('website.message-center.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.flash-message')

                                    <div class="row">
                                        <div class="col-12 mb-3">


                                            <div class="card">
                                                <div class="card-header theme-blue text-white">
                                                    Support Requests
                                                </div>
                                                <div class="card-body">
                                                    <table id="support-mails" class="display" style="width: 100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Ticket ID</th>
                                                            <th>Support Topic</th>
                                                            <th>Property/Agency ID</th>
                                                            <th class="support-width">Message</th>
                                                            <th>Time</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($user_supports as $user_support)
                                                            <tr>
                                                                <td>{{$user_support->ticket_id}}</td>
                                                                <td>@if($user_support->inquire_about === 'Other') {{$user_support->topic}} @else {{$user_support->inquire_about}} @endif</td>
                                                                <td>@if($user_support->inquire_about === 'Property') {{$user_support->property_id}}@else  {{$user_support->agency_id}} @endif</td>
                                                                <td class="support-width">{{\Illuminate\Support\Str::limit(strtolower($user_support->message), 110, $end='.....')}}
                                                                    @if(strlen($user_support->message) > 110 )
                                                                        <a class="color-blue" data-placement="bottom" title="Read More" data-toggle="modal" id="support-detail-modal"
                                                                           data-target="#support-detail" data-inquire-about="{{$user_support->inquire_about}}"
                                                                           data-inquire-id="@if($user_support->inquire_about === 'Property') {{$user_support->property_id}}@else  {{$user_support->agency_id}} @endif"
                                                                           data-url="{{$user_support->url}}"
                                                                           data-message="{{strip_tags($user_support->message)}}"
                                                                           data-time="{{(new \Illuminate\Support\Carbon($user_support->created_at))->isoFormat('DD-MM-YYYY  h:mm a')}}"
                                                                        ><span class="color-blue">Read More</span>
                                                                        </a>
                                                                    @endif</td>
                                                                <td>{{(new \Illuminate\Support\Carbon($user_support->created_at))->isoFormat('DD-MM-YYYY  h:mm a')}}</td>

                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-12">


                                            <div class="card">
                                                <div class="card-header theme-blue text-white">
                                                    My Inquiries
                                                </div>
                                                <div class="card-body">
                                                    <table id="inquiry-mails" class="display" style="width: 100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Inquiry Topic</th>
                                                            <th>Property/Agency ID</th>
                                                            <th>Email</th>
                                                            <th>Mobile #</th>
                                                            <th>Message</th>
                                                            <th>Time</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(count($agent_inboxes) > 0)
                                                            @foreach($agent_inboxes as $inbox)
                                                                <tr>
                                                                    <td>{{$inbox->name}}</td>
                                                                    <td>{{$inbox->email}}</td>
                                                                    <td>{{str_replace('-','',$inbox->cell)}}</td>
                                                                    <td>{{$inbox->type}}</td>
                                                                    <td>{{\Illuminate\Support\Str::limit(strip_tags(strtolower($inbox->message)), 30, $end='.....')}}
                                                                        @if(strlen($inbox->message) > 30 )
                                                                            <a class="color-blue" data-placement="bottom" title="Read More" data-toggle="modal" id="detail-modal"
                                                                               data-target="#inbox-detail" data-name="{{$inbox->name}}" data-email="{{$inbox->email}}"
                                                                               data-cell="{{$inbox->cell}}" data-type="{{$inbox->type}}" data-location="{{$inbox->ip_location}}"
                                                                               data-message="{{strip_tags($inbox->message)}}"
                                                                               data-time="{{(new \Illuminate\Support\Carbon($inbox->created_at))->isoFormat('DD-MM-YYYY  h:mm a')}}"
                                                                               data-record-id="{{$inbox->id}}"><span class="color-blue">Read More</span>
                                                                            </a>
                                                                        @endif</td>
                                                                    <td>{{(new \Illuminate\Support\Carbon($inbox->created_at))->isoFormat('DD-MM-YYYY  h:mm a')}}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        </tbody>
                                                    </table>
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

    @include('website.layouts.inbox-detail-modal')
    @include('website.layouts.support-detail-modal')

    <!-- Footer start -->
    @include('website.includes.footer')
@endsection

@section('script')
    <script src="{{asset('website/js/bootstrap.bundle.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/script-message-center.js')}}"></script>
@endsection
