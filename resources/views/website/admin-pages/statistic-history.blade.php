@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>Jagha - Buy Sell Rent Homes & Properties In Pakistan by https://www.jagha.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/jquery-ui.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">
    <style>
        .wps-referring-widget-ip {
            display: block;
            padding: 0 15px;
            font-size: 10px;
            color: #a2a2a2;
            margin-left: 6px;
        }

        .wps-btn-group .btn-group, .wps-btn-group .btn-group-vertical {
            position: relative;
            display: inline-block;
            vertical-align: middle;
        }


        .wps-btn-group {
            text-align: center;
            margin: 25px auto;
        }

        div[data-chart-date-picker] {
            text-align: center;
            margin-bottom: 20px;
            transition: 1s all;
        }

        div[data-chart-date-picker] input {
            margin: 0px 8px;
            border-radius: 5px;
            box-shadow: none;
            padding: 5px;
        }

        input[type=date], input[type=datetime-local], input[type=datetime], input[type=email], input[type=month], input[type=number], input[type=password], input[type=search], input[type=tel], input[type=text], input[type=time], input[type=url], input[type=week] {
            padding: 0 8px;
            line-height: 2;
            min-height: 30px;
        }

        input[type=color], input[type=date], input[type=datetime-local], input[type=datetime], input[type=email], input[type=month], input[type=number], input[type=password], input[type=search], input[type=tel], input[type=text], input[type=time], input[type=url], input[type=week], select, textarea {
            box-shadow: 0 0 0 transparent;
            border-radius: 4px;
            border: 1px solid #7e8993;
            background-color: #fff;
            color: #32373c;
        }

        input, select {
            margin: 0 1px;
        }

        input, textarea {
            font-size: 14px;
        }

        button, input, select, textarea {
            box-sizing: border-box;
            font-family: inherit;
            font-size: inherit;
            font-weight: inherit;
        }

    </style>

@endsection

@section('content')
    <div id="site" class="left relative">
        <div id="site-wrap" class="left relative">
        @include('website.admin-pages.includes.admin-nav')

        <!-- Submit Property start -->
            <div class="row admin-margin">
                <div class="col-md-12">
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header theme-blue text-white">
                                Visitors History
                            </div>
                            <div class="card-body">
                                <table id="history" class="display" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>IP</th>
                                        <th>Date</th>
                                        <th>Agent</th>
                                        <th>URI</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($result as $index=>$page)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>{{$page->ip}}</td>
                                            <td>{{$page->last_counter}}</td>
                                            <td>{{$page->agent}}</td>
                                            <td><a class="breadcrumb-link" href=" {{url('/').$page->uri}}" target="_blank">{{$page->uri}}</a></td>
{{--                                            <td>--}}
{{--                                                {{$page['version']}}--}}
{{--                                            </td>--}}

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


@endsection

@section('script')
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/jquery-ui.min.js')}}"></script>
{{--    <script type="text/javascript" charset="utf8" src="{{asset('website/js/chart.js')}}"></script>--}}
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/admin-statistics-history-page.js')}}"></script>

@endsection


