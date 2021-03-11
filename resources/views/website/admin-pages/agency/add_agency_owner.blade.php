@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')
    @include('website.admin-pages.includes.admin-nav')
    <!-- Top header start -->
    {{--    <div style="min-height:90px"></div>--}}

    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row admin-margin">
                <div class="col-md-12">
                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="property_management-tab">
                        <div class="row my-4">
                            <div class="col-md-3">
                                @include('website.agency.sidebar')
                            </div>
                            <div class="col-md-9">
                                @include('website.layouts.flash-message')
                                <div class="card card-gray ">
                                    <div class="card-header theme-blue color-white">
                                        Add Agency Owner
                                    </div>
                                    <div class="card-body">
                                        <h6> Agency Information</h6>
                                        <div class="row mb-3 mt-3">
                                            <div class="col-md-12">
                                                <strong>Agency ID:</strong> {{$agency->id}}
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <strong>Title:</strong> {{$agency->title}}
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <strong>Address:</strong> {{$agency->address}}
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <strong>City:</strong> {{$agency->address}}
                                            </div>
                                        </div>
                                        <div class="row mb-3">

                                            <div class="col-md-4">
                                                <strong>Phone:</strong> {{$agency->phone}}
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <strong>Website:</strong>{{$agency->website}}
                                            </div>
                                        </div>
                                        <div>
                                            {{ Form::open(['route' => ['admin-agencies-owner-update',$agency], 'method' => 'put','role' => 'form','class'=>'data-insertion-form',]) }}
                                            {{ Form::bsEmail('email',null, ['required' => true]) }}
                                            {{ Form::submit('Submit', ['class' => 'btn btn-primary btn-md search-submit-btn']) }}
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
@endsection

{{--@section('script')--}}
{{--    <script>--}}
{{--        (function ($) {--}}
{{--            $(document).ready(function () {--}}
{{--                let logged_in_user = 0--}}
{{--                let logged_in_email = '';--}}

{{--                if ({{Auth::guard('admin')->user()->getAuthIdentifier()}}) {--}}
{{--                    logged_in_user = {{Auth::guard('admin')->user()->getAuthIdentifier()}}--}}
{{--                        logged_in_email = '{{Auth::guard('admin')->user()->email}}';--}}
{{--                } else {--}}
{{--                    logged_in_user = {{Auth::user()->getAuthIdentifier()}}--}}
{{--                        logged_in_email = '{{Auth::user()->email}}';--}}
{{--                }--}}


{{--                $('input[type=radio][name=user_add_by]').change(function () {--}}
{{--                    if (this.value === 'Id') {--}}
{{--                        $("#user-id").attr("readonly", false);--}}
{{--                        $("#user-mail").attr("readonly", true);--}}
{{--                        $('#error-message').slideUp();--}}
{{--                        $('#user-mail').val('');--}}
{{--                    } else if (this.value === 'Email') {--}}
{{--                        $("#user-mail").attr("readonly", false);--}}
{{--                        $("#user-id").attr("readonly", true);--}}
{{--                        $('#error-message').slideUp();--}}
{{--                        $('#id').val('');--}}
{{--                    }--}}
{{--                });--}}

{{--                $('#clear').on('click', function (e) {--}}
{{--                    $('#agency-users-table').slideUp();--}}
{{--                    $("#agency-users-table tbody").empty();--}}
{{--                    $(".user-submit").addClass("d-none");--}}

{{--                    id.val('');--}}
{{--                    email.val('');--}}

{{--                });--}}
{{--                $('#agency-users-table tbody').on('click', '.user-delete', function (e) {--}}
{{--                    e.preventDefault();--}}
{{--                    $(this).closest('tr').remove();--}}


{{--                    let rowCount = $('#agency-users-table tbody tr').length;--}}
{{--                    console.log(rowCount);--}}
{{--                    if (rowCount === 1) {--}}

{{--                        $('#agency-users-table').slideUp();--}}
{{--                        $(".user-submit").addClass("d-none");--}}
{{--                    }--}}
{{--                });--}}
{{--                // runs on add payment button click--}}
{{--                $('#add_user').on('click', function (e) {--}}

{{--                    e.preventDefault();--}}
{{--                    const type = $("input[name='user_add_by']:checked");--}}
{{--                    const id = $('#user-id');--}}
{{--                    const email = $('#user-mail');--}}

{{--                    if (type.val() === 'Id' && id.val() === '') {--}}
{{--                        $('#error-message').html('* AboutPakistan ID is required').slideDown();--}}
{{--                        return;--}}
{{--                    }--}}
{{--                    if (id.val() == logged_in_user) {--}}

{{--                        $('#error-message').html('* Specify ID other than your ID').slideDown();--}}
{{--                        id.val('');--}}
{{--                        return;--}}
{{--                    }--}}
{{--                    if (email.val() === logged_in_email) {--}}

{{--                        $('#error-message').html('* Specify email other than your email').slideDown();--}}
{{--                        email.val('');--}}
{{--                        return;--}}
{{--                    }--}}

{{--                    if (type.val() === 'Email' && email.val() === '') {--}}

{{--                        $('#error-message').html('* Email Address is required.').slideDown();--}}
{{--                        return;--}}
{{--                    }--}}
{{--                    if (email.val() !== '' && IsEmail(email.val()) === false) {--}}
{{--                        e.preventDefault();--}}
{{--                        $('#error-message').html('* Incorrect email format').slideDown();--}}
{{--                        return;--}}

{{--                    } else {--}}
{{--                        $('#error-message').slideUp();--}}
{{--                    }--}}


{{--                    const html =--}}
{{--                        '<tr>' +--}}
{{--                        '  <td>' + type.val() + '<input type="hidden" name="type[]" value="' + type.val() + '"/> </td>' +--}}
{{--                        '  <td>' + id.val() + '<input type="hidden" name="id[]" value="' + id.val() + '"/> </td>' +--}}
{{--                        '  <td>' + email.val() + '<input type="hidden" name="email[]" value="' + email.val() + '"/> </td>' +--}}
{{--                        '  <td><button class="btn btn-danger btn-sm user-delete"><i class="fas fa-trash-alt"></i></button> </td>' +--}}
{{--                        '</tr>';--}}

{{--                    $('#agency-users-table').slideDown().find('tbody').append(html);--}}
{{--                    $(".user-submit").removeClass("d-none");--}}

{{--                    //Reset Fields--}}
{{--                    $("input[name=user_add_by][value=Id]").prop('checked', true);--}}
{{--                    id.val('');--}}
{{--                    email.val('');--}}
{{--                    $("#user-mail").attr("readonly", true);--}}
{{--                    $("#user-id").attr("readonly", false);--}}
{{--                });--}}

{{--                function IsEmail(email) {--}}
{{--                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;--}}
{{--                    return regex.test(email);--}}
{{--                }--}}
{{--            });--}}
{{--        })(jQuery);--}}

{{--    </script>--}}

{{--@endsection--}}
