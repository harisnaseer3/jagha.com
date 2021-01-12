@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Portfolio : About Pakistan Properties Software By https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">
    <style>
        .popover {
            background: lightgrey;
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

                                               <span class="pull-right"><a class="btn btn-sm theme-blue text-white mr-2" href="/"><i
                                                           class="fa fa-globe mr-1"></i>Go to property.aboutpakistan.com</a></span>
                                        <span class="pull-right"><a class="btn btn-sm theme-blue text-white mr-2" href="{{route('aboutpakistan.support')}}"><i
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
                                                    Support Mails
                                                </div>
                                                <div class="card-body">
                                                    <table id="support-mails" class="display" style="width: 100%">
                                                        <thead>
                                                        <tr>

                                                            <th>Sr.</th>
                                                            <th>Inquire About</th>
                                                            <th>ID</th>
                                                            <th>Url</th>
                                                            <th>Message</th>
                                                            <th>Time</th>

                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($user_supports as $user_support)
                                                            <tr>
                                                                <td>{{$loop->iteration}}</td>
                                                                <td>{{$user_support->inquire_about}}</td>
                                                                <td>@if($user_support->inquire_about === 'Property') {{$user_support->property_id}}@else  {{$user_support->agency_id}} @endif</td>
                                                                <td>{{$user_support->url}}</td>
                                                                <td>{{\Illuminate\Support\Str::limit(strtolower($user_support->message), 30, $end='.....')}}
                                                                    @if(strlen($user_support->message) > 30 )
                                                                        <span class="hover-color color-blue" data-placement="bottom" data-toggle="popover" data-trigger="hover"
                                                                              data-content="{{$user_support->message}}">Read More </span> @endif</td>
                                                                <td>{{(new \Illuminate\Support\Carbon($user_support->created_at))->isoFormat('MMM Do YYYY, h:mm a')}}</td>

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
                                                    Inquiry Mails
                                                </div>
                                                <div class="card-body">
                                                    <table id="inquiry-mails" class="display" style="width: 100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Sr.</th>
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
                                                                <td>{{$loop->iteration}}</td>
                                                                <td>{{$inbox->name}}</td>
                                                                <td>{{$inbox->email}}</td>
                                                                <td>{{$inbox->cell}}</td>
                                                                <td>{{$inbox->type}}</td>
                                                                <td>{{$inbox->ip_location}}</td>
                                                                <td>{{\Illuminate\Support\Str::limit(strip_tags(strtolower($inbox->message)), 30, $end='.....')}}
                                                                    @if(strlen($inbox->message) > 30 )
                                                                        <span class="hover-color color-blue" data-placement="bottom" data-toggle="popover" data-trigger="hover"
                                                                              data-content="{{strip_tags(strtolower($inbox->message))}}">Read More </span> @endif</td>
                                                                <td>{{(new \Illuminate\Support\Carbon($inbox->created_at))->isoFormat('MMM Do YYYY, h:mm a')}}</td>
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



    <!-- Footer start -->
    @include('website.includes.footer')
@endsection

@section('script')
    <script src="{{asset('website/js/bootstrap.bundle.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/script-message-center.js')}}"></script>
@endsection
