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
    {{--    <div style="min-height:90px"></div>--}}

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
                                        <h6 class="mt-2"> Registered Users</h6>

                                        <table class="table table-md table-bordered">
                                            <thead class="theme-blue color-white">
                                            <tr>
                                                <th>#</th>
                                                <th>AboutPakistan ID</th>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Email Address</th>
                                                <th>Phone</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(isset($current_agency_users) && count($current_agency_users) > 0)

                                                @foreach($current_agency_users as $agency_user)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$agency_user->id}}</td>
                                                        <td>{{$agency_user->name}}</td>
                                                        @if($agency->user_id === $agency_user->id)
                                                            <td>Agency CEO</td>
                                                        @elseif(count($agency_user->roles) > 0)
                                                            <td>{{$agency_user->roles[0]->name}}</td>
                                                        @else
                                                            <td></td>
                                                        @endif
                                                        <td>{{$agency_user->email}}</td>
                                                        <td>{{$agency_user->phone}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
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
                                                                        <input type="number" min="2" class="form-control form-control-md mr-3 ml-3" id="user-id" name="user-id"/>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <div class="radio">
                                                                    <label class="radio-inline control-label">
                                                                        <input type="radio" name="user_add_by" value="Email" class="mb-2 mr-2"> By Email Address
                                                                        <input type="email" class="form-control form-control-md  ml-3" readonly id="user-mail" name="user-mail"/>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <a href="#" class="btn btn-sm btn-primary" id="add_user">Add User</a>
                                                        <a href="#" class="btn btn-sm btn-warning " id="clear">Clear</a>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-12">
                                                        <div id="error-message" style="display:none; color:red;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    {{ Form::open(['route' => ['admin.agencies.store-agency-users', $agency->id], 'method' => 'post', 'role' => 'form']) }}
                                                    <table class="table table-md table-bordered" id="agency-users-table" style="display:none;">
                                                        <thead class="theme-blue color-white">
                                                        <tr>
                                                            <th>Type</th>
                                                            <th>AboutPakistan ID</th>
                                                            <th>Email Address</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>

                                                    </table>
                                                    {{ Form::submit('Submit', ['class' => 'btn btn-primary btn-md d-none search-submit-btn ml-1 mb-1 user-submit']) }}
                                                    {{ Form::close() }}
                                                </div>
                                            </div>
                                        </div>
                                        @if(isset($users_status) && count($users_status) > 0)
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div><h6> Agency Invitation Status</h6></div>
                                                    <div class="table-responsive">
                                                        <table class="table table-md table-bordered">
                                                            <thead class="theme-blue color-white">
                                                            <tr>
                                                                <th>Sr</th>
                                                                <th>AboutPakistan ID</th>
                                                                <th>Email Address</th>
                                                                <th>Status</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($users_status as $key => $value)
                                                                <tr>
                                                                    <td>{{$key + 1}}</td>
                                                                    <td>{{$value['user_id']}}</td>
                                                                    <td>{{$value['user_email']}}</td>
                                                                    <td style=" @if($value['status'] === 'pending') color:orange; @elseif($value['status'] === 'accepted') color:green; @elseif($value['status'] === 'rejected') color:red; @endif ">{{ucwords($value['status'])}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
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
    <script>
        (function ($) {
            $(document).ready(function () {
                let logged_in_user = 0
                let logged_in_email = '';

                if ({{Auth::guard('admin')->user()->getAuthIdentifier()}}) {
                    logged_in_user = {{Auth::guard('admin')->user()->getAuthIdentifier()}}
                        logged_in_email = '{{Auth::guard('admin')->user()->email}}';
                } else {
                    logged_in_user = {{Auth::user()->getAuthIdentifier()}}
                        logged_in_email = '{{Auth::user()->email}}';
                }


                $('input[type=radio][name=user_add_by]').change(function () {
                    if (this.value === 'Id') {
                        $("#user-id").attr("readonly", false);
                        $("#user-mail").attr("readonly", true);
                        $('#error-message').slideUp();
                        $('#user-mail').val('');
                    } else if (this.value === 'Email') {
                        $("#user-mail").attr("readonly", false);
                        $("#user-id").attr("readonly", true);
                        $('#error-message').slideUp();
                        $('#id').val('');
                    }
                });

                $('#clear').on('click', function (e) {
                    $('#agency-users-table').slideUp();
                    $("#agency-users-table tbody").empty();
                    $(".user-submit").addClass("d-none");

                    id.val('');
                    email.val('');

                });
                $('#agency-users-table tbody').on('click', '.user-delete', function (e) {
                    e.preventDefault();
                    $(this).closest('tr').remove();


                    let rowCount = $('#agency-users-table tbody tr').length;
                    console.log(rowCount);
                    if (rowCount === 1) {

                        $('#agency-users-table').slideUp();
                        $(".user-submit").addClass("d-none");
                    }
                });
                // runs on add payment button click
                $('#add_user').on('click', function (e) {

                    e.preventDefault();
                    const type = $("input[name='user_add_by']:checked");
                    const id = $('#user-id');
                    const email = $('#user-mail');

                    if (type.val() === 'Id' && id.val() === '') {
                        $('#error-message').html('* AboutPakistan ID is required').slideDown();
                        return;
                    }
                    if (id.val() == logged_in_user) {

                        $('#error-message').html('* Specify ID other than your ID').slideDown();
                        id.val('');
                        return;
                    }
                    if (email.val() === logged_in_email) {

                        $('#error-message').html('* Specify email other than your email').slideDown();
                        email.val('');
                        return;
                    }

                    if (type.val() === 'Email' && email.val() === '') {

                        $('#error-message').html('* Email Address is required.').slideDown();
                        return;
                    }
                    if (email.val() !== '' && IsEmail(email.val()) === false) {
                        e.preventDefault();
                        $('#error-message').html('* Incorrect email format').slideDown();
                        return;

                    } else {
                        $('#error-message').slideUp();
                    }


                    const html =
                        '<tr>' +
                        '  <td>' + type.val() + '<input type="hidden" name="type[]" value="' + type.val() + '"/> </td>' +
                        '  <td>' + id.val() + '<input type="hidden" name="id[]" value="' + id.val() + '"/> </td>' +
                        '  <td>' + email.val() + '<input type="hidden" name="email[]" value="' + email.val() + '"/> </td>' +
                        '  <td><button class="btn btn-danger btn-sm user-delete"><i class="fas fa-trash-alt"></i></button> </td>' +
                        '</tr>';

                    $('#agency-users-table').slideDown().find('tbody').append(html);
                    $(".user-submit").removeClass("d-none");

                    //Reset Fields
                    $("input[name=user_add_by][value=Id]").prop('checked', true);
                    id.val('');
                    email.val('');
                    $("#user-mail").attr("readonly", true);
                    $("#user-id").attr("readonly", false);
                });

                function IsEmail(email) {
                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    return regex.test(email);
                }
            });
        })(jQuery);

    </script>

@endsection
