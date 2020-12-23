@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Property Management By Property.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">

@endsection

@section('content')
    @include('website.includes.dashboard-nav')

    <!-- Submit Property start -->
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content admin-margin" id="ListingsTabContent">
                        <div class="tab-pane fade show active" id="message_center" role="tabpanel" aria-labelledby="message_center-tab">
                            <div class="my-4">
                                <div class="col-12 mb-4">
                                    <div class="card">
                                        <div class="card-header theme-blue text-white">
                                            Inbox
                                        </div>
                                        <div class="card-body">
                                            <table id="user-notification" class="display" style="width: 100%">
                                                <thead>
                                                <tr>
                                                    <th>Sr.</th>
                                                    <th>Dated</th>
                                                    <th>Message</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($notifications as $key=> $notification)
                                                    {{--                                                    {{dd($notification, $key)}}--}}
                                                    <tr>
                                                        <td>{{$key +1}}</td>
                                                        <td>{{ (new \Illuminate\Support\Carbon($notification->created_at))->isoFormat('MMMM Do YYYY, h:mm a') }}</td>
                                                        <td>
                                                        @if(isset($notification->data['type']) && $notification->data['type'] === 'property')

                                                                <div class="{{$notification->read_at === null ? 'alert alert-primary':'alert alert-danger' }}">
                                                                    <span>Status of Property ID = <strong> {{$notification->data['id']}} </strong> having Reference <strong> {{$notification->data['reference']}} </strong>
                                                                        has been changed to <strong>{{ucwords($notification->data['status'])}}</strong>.</span>
                                                                </div>

                                                        @elseif(isset($notification->data['type']) && $notification->data['type'] === 'agency')

                                                                <div class="{{$notification->read_at === null ? 'alert alert-primary':'alert alert-danger' }}">
                                                                    <span>Status of Agency ID = <strong> {{$notification->data['id']}} </strong> named <strong> {{$notification->data['title']}} </strong> has been changed to <strong>{{ucwords($notification->data['status'])}}</strong>.</span>
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

    <!-- Footer start -->
    @include('website.includes.footer')
@endsection

@section('script')
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/script-message-center.js')}}"></script>


@endsection
