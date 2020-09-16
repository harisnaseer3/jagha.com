@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Property Management By Property.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')
    @include('website.includes.dashboard-nav')
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>Agency Users</h1>
            </div>
        </div>
    </div>
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
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
                                        Agency Users

                                    </div>
                                    <div class="card-body">
                                        <h6> Agency Information</h6>
                                        <div class="row mb-3 mt-3">
                                            <div class="col-md-12">
                                                <strong>ID:</strong> {{$agency->id}}
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
                                        <div class="card">
                                            <div class="card-header bg-secondary color-white">
                                                Add User
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <form class="form-inline" role="form">
                                                            <div class="form-group mb-2">
                                                                <div class="radio">
                                                                    <label class="radio-inline control-label">
                                                                        <input type="radio" name="user_add_by" value="Id" class="mb-2 mr-2" checked="checked"> By AboutPakistan ID
                                                                        <input type="text" class="form-control form-control-md mr-3 ml-3" id="user-id" name="user-id"/>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <div class="radio">
                                                                    <label class="radio-inline control-label">
                                                                        <input type="radio" name="user_add_by" value="Email" class="mb-2 mr-2"> By Email Address
                                                                        <input type="email" class="form-control form-control-md  ml-3" id="user-mail" name="user-mail"/>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-5">
                                                        <a href="#" class="btn btn-sm btn-primary" id="add_user">Add User</a>
                                                        <a href="#" class="btn btn-sm btn-warning " id="clear">Clear</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    {{ Form::open(['route' => ['agencies.store-agency-users', $agency->id], 'method' => 'post', 'role' => 'form']) }}
                                                    <table class="table table-md table-bordered" id="agency-users-table">
                                                        <thead class="theme-blue color-white">
                                                        <tr>
                                                            <th>Type</th>
                                                            <th>AboutPakistan ID</th>
                                                            <th>Email Address</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        {{--                                                        </tbody>--}}
                                                    </table>
                                                    {{ Form::submit('Submit', ['class' => 'btn btn-primary btn-md search-submit-btn ml-1 mb-1 user-submit']) }}
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


    @include('website.includes.footer')
@endsection

@section('script')
    <script>
        (function ($) {
            $(document).ready(function () {

                $('#clear').on('click', function (e) {
                    $("#agency-users-table tbody").empty();
                    id.val('');
                    email.val('');
                });
                $('#agency-users-table tbody').on('click', '.user-delete', function (e) {
                    e.preventDefault();
                    $(this).closest('tr').remove();
                });
                // runs on add payment button click
                $('#add_user').on('click', function (e) {

                    e.preventDefault();
                    const type = $("input[name='user_add_by']:checked");
                    const id = $('#user-id');
                    const email = $('#user-mail');

                    if (type.val() === 'Id' && id.val() === '') {
                        alert('AboutPakistan Id is required');
                        return;
                    }
                    if (type.val() === 'Email' && email.val() === '') {
                        alert('Email Address is required.');
                        return;
                    }

                    const html =
                        '<tr>' +
                        '  <td>' + type.val() + '<input type="hidden" name="type[]" value="' + type.val() + '"/> </td>' +
                        '  <td>' + id.val() + '<input type="hidden" name="id[]" value="' + id.val() + '"/> </td>' +
                        '  <td>' + email.val() + '<input type="hidden" name="email[]" value="' + email.val() + '"/> </td>' +
                        '  <td><button class="btn btn-danger btn-sm user-delete"><i class="fas fa-trash-alt"></i></button> </td>' +
                        '</tr>';

                    $('#agency-users-table').find('tbody').append(html);

                    //Reset Fields
                    $("input[name=user_add_by][value=Id]").prop('checked', true);
                    id.val('');
                    email.val('');
                });
            });
        })(jQuery);

    </script>

@endsection
