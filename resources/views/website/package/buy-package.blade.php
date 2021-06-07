@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    {{--    <style>--}}
    {{--        .stepwizard-step p {--}}
    {{--            margin-top: 0px;--}}
    {{--            color: #666;--}}
    {{--        }--}}

    {{--        .stepwizard-row {--}}
    {{--            display: table-row;--}}
    {{--        }--}}

    {{--        .stepwizard {--}}
    {{--            display: table;--}}
    {{--            width: 100%;--}}
    {{--            position: relative;--}}
    {{--        }--}}

    {{--        .stepwizard-step button[disabled] {--}}
    {{--            /*opacity: 1 !important;--}}
    {{--            filter: alpha(opacity=100) !important;*/--}}
    {{--        }--}}

    {{--        .stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {--}}
    {{--            opacity: 1 !important;--}}
    {{--            color: #bbb;--}}
    {{--        }--}}

    {{--        .stepwizard-row:before {--}}
    {{--            top: 14px;--}}
    {{--            bottom: 0;--}}
    {{--            position: absolute;--}}
    {{--            content: " ";--}}
    {{--            width: 100%;--}}
    {{--            height: 1px;--}}
    {{--            background-color: #ccc;--}}
    {{--            z-index: 0;--}}
    {{--        }--}}

    {{--        .stepwizard-step {--}}
    {{--            display: table-cell;--}}
    {{--            text-align: center;--}}
    {{--            position: relative;--}}
    {{--        }--}}

    {{--        .btn-circle {--}}
    {{--            border: 1px solid lightgrey !important;--}}
    {{--            /*border-color: #ccc;*/--}}
    {{--            width: 30px;--}}
    {{--            height: 30px;--}}
    {{--            text-align: center;--}}
    {{--            padding: 6px 0;--}}
    {{--            font-size: 12px;--}}
    {{--            line-height: 1.428571429;--}}
    {{--            border-radius: 15px;--}}
    {{--        }--}}
    {{--        .btn-disabled{--}}
    {{--            background-color: white;--}}
    {{--        }--}}


    {{--    </style>--}}
@endsection

@section('content')
    @include('website.includes.dashboard-nav')
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>Packages</h1>
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
                                    @include('website.package.sidebar')
                                </div>
                                <div class="col-md-9 my-3">
                                    @include('website.layouts.flash-message')
                                    <div class="tab-content" id="listings-tabContent">
                                        <div class="tab-pane fade active show" id="listings-all" role="tabpanel" aria-labelledby="listings-all-tab">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="float-right">
                                                        <span class="pull-right"><a class="btn btn-sm theme-blue text-white mr-2" href="/">
                                                            <i class="fa fa-globe mr-1"></i>Go to property.aboutpakistan.com</a></span>
                                                    </div>
                                                    <div class="float-left">
                                                        <h6>Packages</h6>
                                                    </div>
                                                </div>
                                                <div class="col-12">

                                                    <div class="my-4" style="background: white">
                                                        <div class="row">
                                                            <div class="col-xl-4 col-lg-4 col-md-12">
                                                                <div class="pricing-3">
                                                                    <div class="title">Basic Plan</div>
                                                                    <div class="content">
                                                                        <ul>
                                                                            <li>Free Account</li>
                                                                            <li>Add Multiple Properties</li>
                                                                            <li>Manage Multiple Agencies</li>
                                                                            <li></li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="price-for-user">
                                                                        <div class="price" style="font-size: 30px;">
                                                                            {{--                                                                            <sup> Free</sup>--}}
                                                                            {{--                                                                            <span class="dolar">--}}
                                                                            Free
                                                                            {{--                                                                            </span>--}}
                                                                            {{--                                                                            <small class="month">per month</small>--}}
                                                                        </div>
                                                                    </div>
                                                                    {{--                                                                    <div class="button"><a href="#" class="btn btn-outline pricing-btn">Get started</a></div>--}}
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-4 col-md-12">
                                                                <div class="pricing-3">
                                                                    <div class="title">Gold Plan</div>
                                                                    <div class="content">
                                                                        <ul>
                                                                            <li>Free Account</li>
                                                                            <li>Add Multiple Properties</li>
                                                                            <li>Manage Multiple Agencies</li>
                                                                            <li>Display Properties in top Search Results</li>
                                                                            <li></li>
                                                                            <li></li>
                                                                            <li></li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="price-for-user">
                                                                        <div class="price text-color"><sup>Rs.</sup>
                                                                            @if(!$price->isEmpty())
                                                                                @foreach($price as $val)
                                                                                    @if($val->type == 'Gold')
                                                                                        <span class="dolar">{{$val->price_per_unit}}</span>
                                                                                    @endif
                                                                                @endforeach

                                                                            @else
                                                                                <span class="dolar">0</span>
                                                                            @endif

                                                                            <small class="month">per month</small></div>
                                                                    </div>
                                                                    {{--                                                    <div class="button"><a href="#" class="btn btn-outline pricing-btn button-theme">Get started</a></div>--}}
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-4 col-md-12">
                                                                <div class="pricing-3">
                                                                    <div class="title">Platinum Plan</div>
                                                                    <div class="content">
                                                                        <ul>
                                                                            <li>Free Account</li>
                                                                            <li>Details of User Visits</li>
                                                                            <li>Add Multiple Properties</li>
                                                                            <li>Manage Multiple Agencies</li>
                                                                            <li>Agency Featured on Main Page</li>
                                                                            <li>Properties Displayed on Main Page</li>
                                                                            <li>Display Properties in Top Search Results</li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="price-for-user">
                                                                        <div class="price"><sup>Rs.</sup>
                                                                            @if(!$price->isEmpty())
                                                                                @foreach($price as $val)
                                                                                    @if($val->type == 'Platinum')
                                                                                        <span class="dolar">{{$val->price_per_unit}}</span>
                                                                                    @endif
                                                                                @endforeach

                                                                            @else
                                                                                <span class="dolar">0</span>
                                                                            @endif

                                                                            <small class="month">per month</small>
                                                                        </div>
                                                                    </div>
                                                                    {{--                                                    <div class="button"><a href="#" class="btn btn-outline pricing-btn">Get started</a></div>--}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="my-4">
                                                        <div class="card my-4">
                                                            <div class="card-header theme-blue text-white">
                                                                <div class="font-14 font-weight-bold text-white"> Buy Packages</div>
                                                            </div>
                                                            <div class="card-body">
                                                                {{ Form::open(['route' => ['package.store'], 'method' => 'post', 'class'=> 'package-form']) }}
                                                                @if($user_agencies->isNotEmpty())
                                                                    {{ Form::bsRadio('package_for',old('package_for', 'Agency'), ['required' => true, 'list' => ['Agency','Properties'],'display' => 'block','class'=>'mt-3']) }}

                                                                    <div class="form-group row" id="agency_block">
                                                                        <label for="name" class="col-sm-4 col-md-3 col-lg-2 col-xl-2 col-form-label col-form-label-sm">
                                                                            Agency <span class="text-danger">*</span>
                                                                        </label>
                                                                        <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                                                                            <select class="custom-select custom-select-agency select2bs4 select2-hidden-accessible agency-select2"
                                                                                    style="width: 100%;border:0" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false"
                                                                                    name="agency" id="agency">
                                                                                <option selected disabled>Select Agency</option>
                                                                                @foreach($user_agencies as $agency)
                                                                                    <option value={{$agency->id}} {{ (old('agency') == $agency->id) ? ' selected' : '' }}>
                                                                                        {{$agency->id}}-{{$agency->title}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <div class="form-group row">
                                                                    <label for="package" class="col-sm-4 col-md-3 col-lg-2 col-xl-2 col-form-label col-form-label-sm">
                                                                        Package
                                                                    </label>
                                                                    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                                                                        <select class="custom-select custom-select-agency select2bs4 select2-hidden-accessible agency-select2"
                                                                                style="width: 100%;border:0" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false"
                                                                                name="package" id="package">

                                                                            <option selected disabled value="-1">Select package</option>
                                                                            @foreach($types as $type)
                                                                                <option value= {{$type}} {{ (old('package') == $type) ? ' selected' : '' }} >{{$type}}</option>
                                                                            @endforeach
                                                                            {{--                                                                    <option value='Gold' {{ (old('package') == 'Gold') ? ' selected' : '' }} >Gold</option>--}}
                                                                        </select>
                                                                    </div>
                                                                    <div
                                                                        class="offset-xs-4 col-xs-8 offset-sm-4 col-sm-8 offset-md-0 col-md-4 col-lg-4 col-xl-5 text-muted data-default-line-height my-sm-auto">
                                                                        Select a Package
                                                                    </div>
                                                                </div>
                                                                {{ Form::bsNumber('property_count', 0, ['required' => true, 'data-default' => 'Enter the number of Properties for selected package', 'min' => 1, 'step' => 1]) }}
                                                                {{ Form::bsNumber('duration', 1, ['required' => true, 'data-default' => 'Enter Package Duration in Months', 'min' => 1, 'step' => 1]) }}
                                                                {{ Form::bsNumber('amount', 0, ['required' => true, 'disabled'=>true,'data-default' => 'Package Amount in Rs.']) }}
                                                                {{ Form::hidden('unit_amount',null) }}
                                                                <div><span class="text-danger">* </span>The Package will not renew automatically.</div>
                                                            </div>
                                                            <div class="card-footer">
                                                                <div id="submit-block">
                                                                    {{--                                                            {{ Form::submit('Buy', ['class' => 'btn btn-primary btn-md search-submit-btn']) }}--}}
                                                                </div>
                                                                {{ Form::close() }}
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
            </div>
        </div>

    </div>



    <!-- Footer start -->
    @include('website.includes.footer')
@endsection

@section('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('plugins/intl-tel-input/js/intlTelInput.js')}}"></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('website/js/package-form.js')}}"></script>
@endsection
