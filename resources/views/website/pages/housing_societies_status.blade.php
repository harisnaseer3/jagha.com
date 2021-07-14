@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection


@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}" async defer>
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/housing.css')}}" async defer>
    <style>

    </style>
@endsection

@section('content')

    @include('website.includes.nav')

    <!-- Properties section body start -->
    <div class="properties-section content-area pt-3">
        <div class="container">
            <div class="row cities-margin">
                <div class="col-lg-12 col-md-12 pb-3">
                    <!-- Listing -->
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="all-cities-header">Housing Societies Status</h1>
                                </div>
                            </div>


                        </div>
                        <div class="card-body housing-card">
                            <div id="listings-div">
                                <div class="page-list-layout">
                                    <div class="option-bar housing-bar">
                                        <div class="cod-pad">
                                            <div class="sorting-options text-center" role="button" aria-label="filter">
                                                {{ Form::open(['route' => ['property.user.search.id'], 'method' => 'post', 'role' => 'form', 'id'=>'societies-search-form']) }}
                                                <div class="row mb-md-2">
                                                    <div class="col-md-4 col-sm-12 mb-sm-2">
                                                        <select class=" sorting form-control form-control-sm" id="status-filter" name="status">

                                                            <option selected value="-1">All</option>
                                                            @foreach($status as $val)
                                                                <option value="{{$val->id}}">{{$val->title}}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>
                                                    <div class="col-md-4 col-sm-12 mb-sm-2">
                                                        <select class="sorting area-filter form-control form-control-sm" id="authorities-filter" name="authority">

                                                            <option selected value="-1">All</option>
                                                            @foreach($authority as $val)
                                                                <option value="{{$val->id}}">{{$val->title}}</option>
                                                            @endforeach

                                                        </select>


                                                    </div>
                                                    <div class="col-md-4 col-sm-12">
                                                        <select class="sorting form-control form-control-sm" id="division-filter" name="division">

                                                            <option selected value="-1">All</option>
                                                            @foreach($division as $val)
                                                                <option value="{{$val->id}}">{{$val->title}}</option>
                                                            @endforeach
                                                        </select>


                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-12">
                                                        <select class="sorting form-control form-control-sm" id="district-filter" name="district">

                                                            <option selected value="-1">All</option>
                                                            @foreach($district as $val)
                                                                <option value="{{$val->id}}">{{$val->title}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>


                                                        <div class="col-md-4 col-sm-12">
                                                            <button class="btn btn-sm btn-primary float-left btn-search-style p-2" id="societies-search" type="submit">
                                                                <i class="fa fa-search mx-1"></i>Search
                                                            </button>
                                                        </div>


                                                </div>




                                                {{ Form::close() }}


                                            </div>
                                        </div>
                                    </div>

                                    <!-- Property box 2 start -->
                                </div>
                            </div>
                            <div class="row">
                                <div id="admin" class="col s12">
                                    <div class="card material-table">
                                        <div class="table-header">
                                            <span class="table-title">All Results</span>
                                            <div class="actions">
                                                <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="fa fa-search"></i></a>
                                            </div>
                                        </div>

                                        {{--                                        <div style="display: none" id="property-logs-block">--}}
                                        <table class="table-responsive-sm display" id="societies-table" style="width: 100%">
                                            <thead>
                                            <tr>
                                                <th class="color-white">#</th>
                                                <th class="color-white">Society Name</th>
                                                <th class="color-white">Status</th>
                                                <th class="color-white">City</th>
                                                <th class="color-white">Approving Authority</th>
                                                <th class="color-white">Total Land Area</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tbody-property-logs"></tbody>
                                        </table>
                                        {{--                                        </div>--}}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                {{--                <div class="col-lg-3 col-md-12">--}}
                {{--                    <div class="sidebar-right mt-0">--}}
                {{--                        @include('website.includes.subscribe-content')--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>
    <!-- Footer start -->
    @include('website.includes.footer')
    <div class="fly-to-top back-to-top">
        <i class="fa fa-angle-up fa-3"></i>
        <span class="to-top-text">To Top</span>
    </div><!--fly-to-top-->
    <div class="fly-fade">
    </div><!--fly-fade-->
@endsection

@section('script')
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/housing-societies.js')}}"></script>
    <script>
        (function ($) {
            $(document).ready(function () {
                let authority =   {!! $authority !!};
                let division = {!! $division !!};
                let district = {!! $district !!};


                $('#authorities-filter').on('change', function () {
                    let a_id = $('#authorities-filter option:selected').val();
                    let new_division = '<option selected value="-1">All</option>';
                    let new_dis = '<option selected value="-1">All</option>';
                    let selected_division_id = 0;
                    let new_division_2 = '';
                    let new_dis_2 = '';
                    $.each(division, function (index, value) {
                        if (value['authority_id'] == a_id) {
                            selected_division_id = value['id'];
                            new_division += '<option value="' + value['id'] + '">' + value['title'] + '</option>'
                        }
                        new_division_2 += '<option value="' + value['id'] + '">' + value['title'] + '</option>';
                    });

                    $.each(district, function (index, value) {
                        if (value['division_id'] == selected_division_id && value['isDevelopmentAuthority'] == 1) {
                            // division_check = 1;
                            new_dis += '<option value="' + value['id'] + '">' + value['title'] + '</option>'
                        }
                        new_dis_2 += '<option value="' + value['id'] + '">' + value['title'] + '</option>';
                    });
                    if (selected_division_id != 0) {
                        $("#division-filter").empty().append(new_division);
                        $("#district-filter").empty().append(new_dis);
                    } else if (selected_division_id == 0) {
                        $("#division-filter").empty().append(new_division).append(new_division_2);
                        $("#district-filter").empty().append(new_dis).append(new_dis_2);
                    }

                });
                $('#division-filter').on('change', function () {
                    let div_id = $('#division-filter option:selected').val();
                    let new_dis = '<option selected value="-1">All</option>';
                    let new_dis_2 = '';
                    $.each(district, function (index, value) {
                        let check_authority = $('#authorities-filter option:selected').val();
                        if (check_authority == 4) {
                            if (value['division_id'] == div_id && value['isDevelopmentAuthority'] == 0) {
                                new_dis += '<option value="' + value['id'] + '">' + value['title'] + '</option>'
                            }
                            new_dis_2 += '<option value="' + value['id'] + '">' + value['title'] + '</option>';
                        } else if (check_authority == -1 || check_authority == 6) {
                            if (value['division_id'] == div_id) {
                                new_dis += '<option value="' + value['id'] + '">' + value['title'] + '</option>'
                            }
                            new_dis_2 += '<option value="' + value['id'] + '">' + value['title'] + '</option>';
                        } else {
                            if (value['division_id'] == div_id && value['isDevelopmentAuthority'] == 1) {
                                new_dis += '<option value="' + value['id'] + '">' + value['title'] + '</option>'
                            }
                            new_dis_2 += '<option value="' + value['id'] + '">' + value['title'] + '</option>';
                        }

                    });

                    $("#district-filter").empty().append(new_dis);

                });
            })
        })
        (jQuery);
    </script>


@endsection
