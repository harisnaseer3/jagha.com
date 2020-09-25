@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Property Management By https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')
    @include('website.includes.dashboard-nav')

@endsection

@section('script')
    <script>
        (function ($) {
            $(document).ready(function () {
                $('#delete').on('show.bs.modal', function (event) {
                    let record_id = $(event.relatedTarget).data('record-id');
                    $(this).find('.modal-body #record-id').val(record_id);
                });
                //TODO: if page url change then change following accordingly
                $(document).on('click', '#listings-tab a', function () {
                    var tab = $(this).attr('href').split('#');
                    var special_listing = ['listings-super_hot', 'listings-magazine', 'listings-hot'];
                    if (tab[1] != null) {
                        let purpose;
                        if (special_listing.includes(tab[1])) purpose = tab[1].split("-")[1] + '_listing';
                        else purpose = tab[1].split("-")[1];
                        $('.pagination li a').each(function (index) {
                            let url = $(this).attr('href');
                            let url_piece_1 = url.split('purpose/')[0];
                            let url_piece_2 = url.split('purpose/')[1];
                            let url_piece_3 = url_piece_2.split('user/')[1];
                            let new_url = url_piece_1 + 'purpose/' + purpose + '/user/' + url_piece_3;
                            $(this).attr('href', new_url)
                        })
                    }
                });
                $('#sign-in-btn').click(function (event) {
                    if (form.valid()) {
                        event.preventDefault();
                        jQuery.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        event.preventDefault();
                        jQuery.ajax({
                            type: 'post',
                            url: window.location.origin + '/property' + '/login',
                            data: form.serialize(),
                            dataType: 'json',
                            success: function (data) {
                                // console.log(data);
                                if (data.data) {
                                    // console.log(data.user);
                                    $('.error-tag').hide();
                                    $('#exampleModalCenter').modal('hide');
                                    let user_dropdown = $('.user-dropdown')
                                    user_dropdown.html('');
                                    let user_name = data.user.name + ' (ID: ' + user_id + ')';
                                    let user_id = data.user.id;
                                    let html =
                                        '            <div class="dropdown">' +
                                        '                <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="javascript:void(0);" id="dropdownMenuButton" aria-haspopup="true"' +
                                        '                    aria-expanded="false">' +
                                        '                      <i class="fas fa-user mr-3"></i>';
                                    html += '<span class="mr-1"> Logged in as <span>' + user_name;
                                    html += '</a>' +
                                        '                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                                    html += '<a class="dropdown-item" href=" ' + window.location.origin + '/property' + '/dashboard/accounts/users/' + user_id + '/edit"><i class="far fa-user-cog mr-2"></i>Manage Profile</a>' +
                                        '                     <div class="dropdown-divider"></div>' +
                                        // '<a class="dropdown-item" href=" ' + window.location.origin + '/property/dashboard/properties/create"><i class="fa fa-building-o mr-2"></i>Property Managment </a>' +
                                        '<a class="dropdown-item" href=" ' + window.location.origin + '/property' + '/dashboard/listings/status/active/purpose/all/user/' + user_id + '/sort/id/order/asc/page/10"><i class="fa fa-building-o mr-2"></i>Property Management </a>' +
                                        '                     <div class="dropdown-divider"></div>' +
                                        '                          <a class="dropdown-item" href="{{route("accounts.logout")}}"><i class="far fa-sign-out mr-2"></i>Logout</a>';
                                    html += '</div>' + '</div>';

                                    user_dropdown.html(html);
                                    // window.location.reload(true);
                                } else if (data.error) {
                                    $('div.help-block small').html(data.error.password);
                                    $('.error-tag').show();
                                }
                            },
                            error: function (xhr, status, error) {
                                event.preventDefault();

                                // console.log(error);
                                // console.log(status);
                                // console.log(xhr);
                            },
                            complete: function (url, options) {
                            }
                        });
                    }
                });

                function changePropertyStatus(status, id) {
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        type: 'post',
                        url: window.location.origin + '/property' + '/dashboard/change-status',
                        data: {'id': id, 'status': status},
                        dataType: 'json',
                        success: function (data) {
                            if (data.status === 200) {
                                window.location.reload(true);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                        },
                        complete: function (url, options) {
                        }
                    });
                }

                $('.restore-btn').on('click', function () {
                    let id = $(this).attr('data-record-id');
                    changePropertyStatus('pending', id);
                });
                $('[name=status]').on('change', function (event) {
                    let status_value = $(this).val();
                    if ($.inArray(status_value, ['active', 'reactive', 'sold', 'expired', 'boost']) > -1) {
                        if (status_value === 'reactive') {
                            status_value = 'pending'
                        }
                        let id = $(this).attr('data-id');
                        changePropertyStatus(status_value, id);
                    }
                });
                $('.btn-accept').on('click', function () {
                    let alert = $(this);
                    let agency_id = alert.attr('data-agency');
                    let user_id = alert.attr('data-user');
                    let notification_id = alert.attr('data-id');

                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        type: 'post',
                        url: window.location.origin + '/property' + '/dashboard/agencies/accept-invitation',
                        data: {'agency_id': agency_id, 'user_id': user_id, 'notification_id': notification_id},
                        dataType: 'json',
                        success: function (data) {
                            // console.log(data);
                            if (data.status === 200) {
                                alert.closest('.alert').remove();
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                        },
                        complete: function (url, options) {

                        }
                    });
                });
                $('.btn-reject').on('click', function () {
                    let alert = $(this);
                    let notification_id = alert.attr('data-id');

                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        type: 'post',
                        url: window.location.origin + '/property' + '/dashboard/agencies/reject-invitation',
                        data: {'notification_id': notification_id},
                        dataType: 'json',
                        success: function (data) {
                            // console.log(data);
                            if (data.status === 200) {
                                alert.closest('.alert').remove();
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                        },
                        complete: function (url, options) {

                        }
                    });
                });

            });
        })(jQuery);
    </script>
@endsection
