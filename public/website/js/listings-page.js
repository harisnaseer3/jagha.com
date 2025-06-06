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
        $('#admin-logout-btn').click(function (event) {
            event.preventDefault();
            jQuery.ajax({
                type: 'get',
                url: window.location.origin + '/admin/admin-logout',
                success: function (data) {
                    if (data.data) {
                        let user_dropdown = $('.user-dropdown');
                        user_dropdown.html('');
                        let html = ' <a class="nav-link" data-toggle="modal" data-target="#exampleModalCenter"\n' +
                            '                                   href="javascript:void(0);" id="navbarDropdownMenuLink5" aria-haspopup="true" aria-expanded="false">\n' +
                            '                                    <i class="fas fa-user mr-3"></i>\n' +
                            '                                </a>'
                        $('#adminLogoutModal').modal('hide');
                        user_dropdown.html(html);
                        $('#exampleModalCenter').modal('show');

                    }
                }
            })
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
                    url: window.location.origin + '/login',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (data) {
                        // console.log(data);
                        if (data.data) {
                            // console.log(data.user);
                            $('.error-tag').hide();
                            $('#exampleModalCenter').modal('hide');
                            let user_dropdown = $('.user-dropdown');
                            let nav_property_link = $('.nav-property-link');
                            let nav_profile_link = $('.nav-profile-link');
                            user_dropdown.html('');
                            nav_property_link.html('');
                            nav_profile_link.html('');
                            let user_name = data.user.name;
                            let user_id = data.user.id;
                            let html =
                                '            <div class="dropdown dropdown-min-width">' +
                                '                <a class="nav-link dropdown-toggle text-right" data-toggle="dropdown" role="button" href="javascript:void(0);" id="dropdownMenuButton" aria-haspopup="true"' +
                                '                    aria-expanded="false">' +
                                '                      <i class="fas fa-user mr-2"></i>';
                            html += '<span class="mr-1">' + user_name + ' (ID: ' + user_id + ')' + '<span>';
                            html += '</a>' +
                                '                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                            html += '<a class="dropdown-item" href=" ' + window.location.origin + '/dashboard/accounts/users/' + user_id + '/edit"><i class="far fa-user-cog mr-2"></i>Manage Profile</a>' +
                                '                     <div class="dropdown-divider"></div>' +
                                '<a class="dropdown-item" href=" ' + window.location.origin + '/dashboard/listings/status/active/purpose/all/user/' + user_id + '/sort/id/order/asc/page/10"><i class="fa fa-building-o mr-2"></i>Property Management </a>' +
                                '                     <div class="dropdown-divider"></div>' +
                                '<a class="dropdown-item" href=" ' + window.location.origin + '/dashboard/accounts/wallet' + '"><i class="far fa-wallet mr-2"></i>My Wallet </a>' +
                                '<div class="dropdown-divider"></div>' +
                                '                          <a class="dropdown-item" href="' + window.location.origin + '/dashboard/accounts/logout' + '"><i class="far fa-sign-out mr-2"></i>Logout</a>';
                            html += '</div>' + '</div>';
                            let html_profile_link = '<a class="nav-link theme-dark-blue" href="' + window.location.origin + '/dashboard/accounts/users/' + user_id + '/edit" >My Account Settings</a>';
                            let html_property_link = '<a class="nav-link theme-dark-blue" href=" ' + window.location.origin + '/dashboard/listings/status/active/purpose/all/user/' + user_id + '/sort/id/order/asc/page/10"> Property Management </a>';
                            if (data.user.verified_at === null) {
                                let snack_html = '<div id="snackbar">Limited Functionality! <a href="' + window.location.origin + '/dashboard/user-dashboard' + '"><u class="color-white">Verify Email Address</u></a></div>'
                                $('#snack-div').html(snack_html);
                            }
                            user_dropdown.html(html);
                            nav_property_link.html(html_property_link);
                            nav_profile_link.html(html_profile_link);
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
                url: window.location.origin + '/dashboard/change-status',
                data: {'id': id, 'status': status},
                dataType: 'json',
                success: function (data) {
                    if (data.status === 200) {
                        window.location.reload(true);
                    } else if (data.status === 201) {
                        let html = '' +
                            '<div class="alert alert-danger alert-block text-white">' +
                            '        <button type="button" class="close" data-dismiss="alert">×</button>' +
                            '        <strong>' + data.message + '</strong>' +
                            '</div>';
                        $('#limit-message').html(html);
                    }
                },
                error: function (xhr, status, error) {
                    // console.log(xhr);
                    // console.log(status);
                    // console.log(error);
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

        $('.mark-as-read').on('click', function () {
            let alert = $(this);
            let notification_id = alert.attr('data-id');

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/dashboard/property-notification',
                data: {'notification_id': notification_id},
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    if (data.status === 200) {
                        // console.log(alert);
                        alert.closest('.alert').remove();
                    }
                },
                error: function (xhr, status, error) {
                    // console.log(xhr);
                    // console.log(status);
                    // console.log(error);
                },
                complete: function (url, options) {

                }
            });
        });

        $(document).on('change', '.sorting', function (e) {
            let agency_users = $(".agency_users option:selected");
            let sort = '';
            if ($(this).val() !== null) {
                sort = $(this).val();
            }

            if (agency_users.val() !== 'all') {
                let user_id = agency_users.data('user');

                let agency_id = agency_users.data("agency");
                let purpose = 'sale';
                let status = 'active';
                let current_url = window.location.pathname.split('/');
                if (current_url.length > 0) {
                    if (current_url[3] === 'status') {
                        status = current_url[4];
                    }
                    if (current_url[5] === 'purpose') {
                        purpose = current_url[6];
                    }
                }
                if (user_id !== null) {
                    getAgentProperties(user_id, agency_id, sort, status, purpose);
                } else getAgentProperties(agency_id, sort, status, purpose);


            } else {
                if ($(this).val() !== null) {
                    if ($(this).val() === 'newest') {
                        sort = 'order/desc/';
                    } else if ($(this).val() === 'oldest') {
                        sort = 'order/asc/';
                    }
                    let link = window.location.href
                    let break_link = link.split('order/');
                    let piece_1 = break_link[0];
                    let piece_2 = break_link[1];
                    let link_2 = piece_2.split('sc/')[1];
                    window.location = piece_1 + sort + link_2;
                }
            }
        });

        $(document).on('change', '.agency_users', function () {
            // let user_id = $(this).val();
            if ($(this).val() === 'all') {
                window.location.reload(true)
            } else {
                let user_id = $('option:selected', this).data("user");
                let agency_id = $('option:selected', this).data("agency");

                let purpose = 'sale';
                let status = 'active';
                let sort = 'oldest';
                let current_url = window.location.pathname.split('/');

                if (current_url.length > 0) {
                    if (current_url[3] === 'status') {
                        status = current_url[4];
                    }
                    if (current_url[5] === 'purpose') {
                        purpose = current_url[6];
                    }
                }

                if (user_id !== null) {
                    getAgentProperties(user_id, agency_id, sort, status, purpose);

                } else if ($('option:selected', this).data("agency") !== null) {
                    getAgentProperties(agency_id, sort, status, purpose);
                }
            }
        });

        function getAgentProperties(user_id = 0, agency_id, sort, status, purpose) {
            let listing_block = $('#listings-tabContent');
            $('tbody').html(
                '<tr><td colspan="12" class="p-4 text-center">' +
                '<i class="fa fa-spinner fa-spin select_contact_person_spinner" style="font-size:20px;"></i>' +
                '</td></tr>'
            );
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                type: 'get',
                url: window.location.origin + '/agent-properties',
                data: {'user_id': user_id, 'agency_id': agency_id, 'sort': sort, 'status': status, 'purpose': purpose},
                dataType: 'json',
                success: function (data) {

                    listing_block.html('');
                    listing_block.html(data.view);

                },
                error: function (xhr, status, error) {
                    // console.log(xhr);
                    // console.log(status);
                    // console.log(error);
                },
                complete: function (url, options) {
                    if (user_id !== 0)
                        $('.agency_users').val(user_id);
                    else {
                        $('.agency_users').val(agency_id);
                    }
                }
            });
        }
    });
})(jQuery);
