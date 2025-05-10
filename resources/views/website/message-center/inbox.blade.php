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
                                               <span class="pull-right"><a class="btn btn-sm  transition-background color-green mr-2" href="/"><i
                                                           class="fa fa-globe mr-1"></i>Go to property.aboutpakistan.com</a></span>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    @include('website.message-center.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.flash-message')

                                    <div class="row">
                                        <div class="col-12">


                                            <div class="card">
                                                <div class="card-header transition-background color-green">
                                                    Customer Inquiries
                                                </div>
                                                <div class="card-body">
                                                    <table id="customer-mails" class="display" style="width: 100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Mobile #</th>
                                                            <th>Type</th>
                                                            <th>Location</th>
                                                            <th>Message</th>
                                                            <th>Time</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(count($agent_inboxes) > 0)
                                                            @foreach($agent_inboxes as $inbox)
                                                                <tr class="{{ $inbox->read_at == null? 'unread':''}}">
                                                                    <td>{{$inbox->name}}</td>
                                                                    <td>{{$inbox->email}}</td>
                                                                    <td>{{str_replace('-','',$inbox->cell)}}</td>
                                                                    <td>{{$inbox->type}}</td>
                                                                    <td>{{$inbox->ip_location}}</td>
                                                                    <td>{{\Illuminate\Support\Str::limit(strip_tags(strtolower($inbox->message)), 30, $end='.....')}}
                                                                        {{--                                                                        @if(strlen($inbox->message) > 30 )--}}
                                                                        <a class="color-blue" data-placement="bottom" title="Read More" data-toggle="modal" id="inbox-detail-modal"
                                                                           data-id="{{$inbox->id}}" data-user="{{\Illuminate\Support\Facades\Auth::user()->id}}"
                                                                           data-target="#inbox-detail" data-name="{{$inbox->name}}" data-email="{{$inbox->email}}"
                                                                           data-cell="{{$inbox->cell}}" data-type="{{$inbox->type}}" data-location="{{$inbox->ip_location}}"
                                                                           data-message="{{strip_tags($inbox->message)}}"
                                                                           data-time="{{(new \Illuminate\Support\Carbon($inbox->created_at))->isoFormat('DD-MM-YYYY  h:mm a')}}"
                                                                           data-record-id="{{$inbox->id}}"><span class="color-blue">Read More</span>
                                                                        </a>
                                                                        {{--                                                                        @endif--}}
                                                                    </td>
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
    <!-- Footer start -->
    @include('website.includes.footer')
@endsection

@section('script')
    <script src="{{asset('website/js/bootstrap.bundle.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/script-message-center.js')}}"></script>
@endsection
