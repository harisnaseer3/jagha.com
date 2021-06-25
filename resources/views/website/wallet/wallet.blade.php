@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    {{--    <link rel="stylesheet" type="text/css" href="{{asset('website/css/bootstrap.min.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')
    @include('website.includes.dashboard-nav')
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>My Account Settings</h1>
            </div>
        </div>
    </div>

    <!-- Submit Property start -->
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="account_profile-tab">
                            <div class="row my-4">
                                <div class="col-md-3">
                                    @include('website.wallet.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.flash-message')
                                    <div class="card">
                                        <div class="card-header theme-blue text-white text-capitalize">My Wallet</div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <div class="text-center">
                                                        <span class="mr-5" style=" font-weight: bold;">Available Total Balance: </span>
                                                        <span>Rs. {{number_format($wallet)}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!empty($transaction))
                                        <div class="card my-4">
                                            <div class="card-header theme-blue text-white text-capitalize">Credit History</div>
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <table class="display balance" style="width: 100%">
                                                            <thead>
                                                            <tr>
                                                                <th>Sr.</th>
                                                                <th>Transaction ID</th>
                                                                <th>Credit Amount</th>
                                                                <th>Credit Type</th>
                                                                <th>Dated</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($transaction as $index1=>$value1)
                                                                <tr>
                                                                    <td>{{$index1 + 1 }}</td>
                                                                    <td>{{$value1->TxnRefNo}}</td>
                                                                    <td>{{$value1->amount}}</td>
                                                                    <td>
                                                                        @if($value1->credit_type == 'purchased')
                                                                                <div class="badge badge-success p-2">  {{ucwords($value1->credit_type)}}</div>

                                                                        @else
                                                                            <div class="badge badge-danger p-2">  {{ucwords($value1->credit_type)}}</div>
                                                                        @endif

                                                                    </td>
                                                                    <td>{{ (new \Illuminate\Support\Carbon($value1->created_at))->isoFormat('DD-MM-YYYY  h:mm a')}}</td>

                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="card my-4">
                                        <div class="card-header theme-blue text-white text-capitalize">Utilization History</div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <table class="display balance" style="width: 100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Sr.</th>
                                                            <th>Amount</th>
{{--                                                            <th>Debt</th>--}}
                                                            <th>Dated</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($history as $index=>$value)
                                                            <tr>
                                                                <td>{{$index + 1 }}</td>
                                                                <td>{{$value->credit}}</td>
{{--                                                                <td>{{$value->debit}}</td>--}}
                                                                <td>{{ (new \Illuminate\Support\Carbon($value->created_at))->isoFormat('DD-MM-YYYY  h:mm a')}}</td>

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
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script>
        (function ($) {
            $(document).ready(function () {
                $('.balance').DataTable(
                    {
                        "scrollX": true,
                        "ordering": false,
                        // responsive: true
                    }
                );
            });
        })
        (jQuery);


    </script>
@endsection
