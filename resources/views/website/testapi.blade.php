@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>Jagha - Buy Sell Rent Homes & Properties In Pakistan by https://www.jagha.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" href="{{asset('plugins/intl-tel-input/css/intlTelInput.min.css')}}" async defer>
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <style type="text/css" id="custom-background-css">
        body.custom-background {
            background-color: #eeeeee;
        }

        .card {
            background-color: white;
            margin: 5%;
            padding: 5%;
        }

        .heading-support {
            font-weight: 500;
            font-size: xx-large;
            color: black;
            text-align: center;

        }

        .mid-heading {
            color: black;
            text-align: center;
            font-stretch: expanded;
            font-size: 18px;

        }

        hr.new2 {
            border-top: 2px dashed #999999;
        }

        hr.new1 {
            border-top: 2px solid #999999;
        }

        .padding-left {
            padding-left: 15%;
        }

        .contact-info {
            color: black;
            font-size: 15px;

        }

        .color-white {
            color: black;
        }

        .padding-right {
            padding-right: 15%;;
        }

        .padding-top {
            padding-top: 10%;
        }

        hr {
            clear: both;
            display: block
        }

        .divider {
            display: inline-block;
            border-bottom: #999999 1px solid;
            width: 100%;
        }

        .container-fluid {
            padding: 0% !important;
        }

        .media-hover .fa-2x:hover {
            color: black;
        }

        .div-center {
            display: flex;
            justify-content: center;
        }

        .media-padding {
            padding: 0% !important;
        }

        .fa-2x {
            color: #999;
            font-size: 17px;
        }

        .mt-support {
            margin-top: 40px;
        }

    </style>
@endsection

@section('content')




    <!-- Submit Property start -->
    <div class="submit-property mt-support">
        <div class="mt-5">
                        {{$data}}
{{--            @foreach($data as $d)--}}
{{--                {{$d->city->name}}--}}
{{--                @if(isset($d->agency))--}}
{{--                    {{$d->agency->title}}--}}
{{--                @endif--}}
{{--                @if(isset($d->image))--}}
{{--                    {{$d->image->name}}--}}
{{--                @endif--}}
{{--            @endforeach--}}
        </div>
    </div>


    <!-- Footer start -->
@endsection

@section('script')


@endsection
