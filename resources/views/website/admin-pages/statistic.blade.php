@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
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
                    <div class="tab-content" id="ListingsTabContent">
                        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                            <div class="m-4">
                                <div class="row">
                                    <div class="col-lg-12 col-md-10 col-sm-6">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 col-sm-6 my-2">
                                                <div class="col-12 mb-4">
                                                    <div class="card">
                                                        <div class="card-header theme-blue text-white">
                                                            Summary
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table w-100">
                                                                <thead>
                                                                <tr>
                                                                    <th scope="col" style="width: 40%"></th>
                                                                    <th scope="col">Visitors</th>
                                                                    <th scope="col">Visits</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach(['today','yesterday','week','year','total'] as $val)
                                                                    <tr>
                                                                        <td>{{ucwords($val)}}</td>
                                                                        <td style="font-size: 16px">{{number_format($visitor[$val])}}</td>
                                                                        <td style="font-size: 16px">{{number_format($visit[$val])}}</td>
                                                                    </tr>
                                                                @endforeach

                                                                </tbody>
                                                            </table>
                                                            <hr>
                                                            <div style="display:none">
                                                                <div class="m-2 p-1 text-center font-16">Search Engine Referrals</div>
                                                                <table class="table table-responsive">
                                                                    <tbody>
                                                                    <tr>
                                                                        <th style="width: 40%"></th>
                                                                        <th>Today</th>
                                                                        <th>Yesterday</th>
                                                                    </tr>
                                                                    @foreach(['today','yesterday','week','year','total'] as $val)
                                                                        <tr>
                                                                            <td>{{ucwords($val)}}</td>
                                                                            <td style="font-size: 16px">{{number_format($visitor[$val])}}</td>
                                                                            <td style="font-size: 16px">{{number_format($visit[$val])}}</td>
                                                                        </tr>@endforeach

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- /.box-body -->
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <div class="card">
                                                        <div class="card-header theme-blue text-white">
                                                            Top Browsers
                                                        </div>
                                                        <div class="card-body" style="display:none">

                                                            <div class="wps-btn-group">
                                                                <div class="btn-group" role="group">
                                                                    <button type="button" class="btn btn-default" data-chart-time="hits" data-time="7" id="week-browser-hit">Week</button>
                                                                    <button type="button" class="btn btn-default" data-chart-time="hits" data-time="30" id="month-browser-hit">Month</button>
                                                                    <button type="button" class="btn btn-default" data-chart-time="hits" data-time="365" id="year-browser-hit">Year</button>
                                                                    <button type="button" class="btn btn-default" data-custom-date-picker="hits" id="custom-browser-hit">Custom</button>
                                                                </div>
                                                            </div>
                                                            <div data-chart-date-picker="hits" id="custom-browser-date" style="display:none;">
                                                                <input type="date" size="18" name="date-from" data-wps-date-picker="from" value="" autocomplete="off" id="browser-dp1">
                                                                to
                                                                <input type="date" size="18" name="date-to" data-wps-date-picker="to" value="" autocomplete="off" id="browser-dp2">
                                                                <input type="submit" id="browser-submit" value="Go" data-between-chart-show="hits" class="btn btn-sm btn-primary p-2 m-0">
                                                            </div>

                                                            <div id="browser-chart-block">
                                                                <canvas id="browserChart" class="w-100" height="300px"></canvas>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <div class="card">
                                                        <div class="card-header theme-blue text-white">
                                                            Top 10 PlatForms <span class="spinner-border" role="status" aria-hidden="true" id="loader-platform"></span>
                                                        </div>
                                                        <div class="card-body" id="platform-block" style="display:none">

                                                            <div class="wps-btn-group">
                                                                <div class="btn-group" role="group">
                                                                    <button type="button" class="btn btn-default" data-chart-time="hits" data-time="7" id="week-platform-hit">Week</button>
                                                                    <button type="button" class="btn btn-default" data-chart-time="hits" data-time="30" id="month-platform-hit">Month</button>
                                                                    <button type="button" class="btn btn-default" data-chart-time="hits" data-time="365" id="year-platform-hit">Year</button>
                                                                    <button type="button" class="btn btn-default" data-custom-date-picker="hits" id="custom-platform-hit">Custom</button>
                                                                </div>
                                                            </div>
                                                            <div data-chart-date-picker="hits" id="custom-platform-date" style="display:none;">
                                                                <input type="date" size="18" name="date-from" data-wps-date-picker="from" value="" autocomplete="off" id="platform-dp1">
                                                                to
                                                                <input type="date" size="18" name="date-to" data-wps-date-picker="to" value="" autocomplete="off" id="platform-dp2">
                                                                <input type="submit" id="platform-submit" value="Go" data-between-chart-show="hits" class="btn btn-sm btn-primary p-2 m-0">
                                                            </div>

                                                            <div id="platform-chart-block">
                                                                <canvas id="platformChart" class="w-100" height="300px"></canvas>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                @include('website.admin-pages.includes.top-countries')
                                                @include('website.admin-pages.includes.top-referring-site')

                                            </div>
                                            <div class="col-lg-9 col-md-6 col-sm-6 my-2">
                                                <div class="col-12 mb-4">
                                                    <div class="card">
                                                        <div class="card-header theme-blue text-white">
                                                            Hit Statistics <span class="spinner-border" role="status" aria-hidden="true" id="loader-stats"></span>
                                                        </div>
                                                        <div class="card-body" id="stats-block" style="display: none">
                                                            <div class="wps-btn-group">
                                                                <div class="btn-group" role="group">
                                                                    <button type="button" class="btn btn-default" data-chart-time="hits" data-time="7" id="week-hit">Week</button>
                                                                    <button type="button" class="btn btn-default" data-chart-time="hits" data-time="30" id="month-hit">Month</button>
                                                                    <button type="button" class="btn btn-default" data-chart-time="hits" data-time="365" id="year-hit">Year</button>
                                                                    <button type="button" class="btn btn-default" data-custom-date-picker="hits" id="custom-hit">Custom</button>
                                                                </div>
                                                            </div>
                                                            <div data-chart-date-picker="hits" id="custom-date" style="display:none;">
                                                                <input type="date" size="18" name="date-from" data-wps-date-picker="from" value="" autocomplete="off" id="dp1">
                                                                to
                                                                <input type="date" size="18" name="date-to" data-wps-date-picker="to" value="" autocomplete="off" id="dp2">
                                                                <input type="submit" id="submit" value="Go" data-between-chart-show="hits" class="btn btn-sm btn-primary p-2 m-0">
                                                            </div>

                                                            {{--                                                                </div>--}}
                                                            {{--                                                            </div>--}}
                                                            <div id="chart-block">
                                                                <canvas id="myChart" class="w-100" height="300px"></canvas>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                @include('website.admin-pages.includes.top-pages')
                                                @include('website.admin-pages.includes.top-visitors')
                                                @include('website.admin-pages.includes.recent-visitors')
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


@endsection

@section('script')
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/chart.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/admin-statistics-page.js')}}"></script>

@endsection


