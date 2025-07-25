@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>Jagha - Buy Sell Rent Homes & Properties In Pakistan by https://www.jagha.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">

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
                                                <div class="card-header theme-blue text-white">
                                                    Notifications
                                                </div>
                                                <div class="card-body">
                                                    <table id="user-notification" class="display" style="width: 100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Dated</th>
                                                            <th>Message</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($notifications as $key=> $notification)
                                                            {{--                                                    {{dd($notification, $key)}}--}}
                                                            <tr>
                                                                <td>{{ (new \Illuminate\Support\Carbon($notification->created_at))->isoFormat('DD-MM-YYYY  h:mm a') }}</td>
                                                                <td>
                                                                    @if(isset($notification->data['type']) && $notification->data['type'] === 'property')

                                                                        <div class="{{$notification->read_at === null ? 'alert alert-danger':'alert alert-primary' }}">
                                                                    <span>Status of Property ID = <strong> {{$notification->data['id']}} </strong> having Reference <strong> {{$notification->data['reference']}} </strong>
                                                                        has been changed to <strong>{{ucwords($notification->data['status'])}}</strong>.</span>
                                                                        </div>






                                                                    @elseif(isset($notification->data['type']) && $notification->data['type'] === 'agency')
                                                                        <div class="{{$notification->read_at === null ? 'alert alert-danger':'alert alert-primary' }}">
                                                                            <span>Status of Agency ID = <strong> {{$notification->data['id']}} </strong> named <strong> {{$notification->data['title']}} </strong> has been changed to <strong>{{ucwords($notification->data['status'])}}</strong>.</span>
                                                                        </div>
                                                                    @elseif(isset($notification->data['type']) && $notification->data['type'] === 'package')
                                                                        <div class="{{$notification->read_at === null ? 'alert alert-danger':'alert alert-primary' }}">
                                                                            <span>Status of Package ID = <strong> {{$notification->data['id']}} </strong> type <strong> {{$notification->data['pack_type']}} </strong> has been changed to <strong>{{ucwords($notification->data['status'])}}</strong>.</span>
                                                                        </div>
                                                                    @elseif(isset($notification->data['type']) && $notification->data['type'] === 'package_property')
                                                                        <div class="{{$notification->read_at === null ? 'alert alert-danger':'alert alert-success' }}">
                                                                            <span>Property of ID = <strong> {{$notification->data['property']}} </strong> successfully
                                                                                added in the Package of type<strong> {{$notification->data['pack_type']}}.</strong>
                                                                                </span>
                                                                        </div>

                                                                    @elseif(isset($notification->data['type']) && $notification->data['type'] === 'complementary_pack')
                                                                        <div class="{{$notification->read_at === null ? 'alert alert-danger':'alert alert-primary' }}">
                                                                            <span>A Complementary <strong>{{$notification->data['pack_type']}} </strong> Package Subscribed to your account by <strong>AboutPakistan.com</strong>. Add your properties in package and Enjoy.</span>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($notification->read_at === null)

                                                                        <a class="btn-read btn-sm btn-outline-info  pull-right mr-2 mark-as-read font-weight-bolder" href="javascript:void(0)"
                                                                           data-user="{{\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()}}"
                                                                           data-id={{$notification->id}}>Mark as read</a>

                                                                    @else
                                                                        <a class="btn-read btn-sm btn-outline-info  pull-right mr-2 mark-as-read font-weight-bolder" href="javascript:void(0)"
                                                                           data-user="{{\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()}}"
                                                                           data-id={{$notification->id}}>Mark as unread</a>

                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
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
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/script-message-center.js')}}"></script>
@endsection
