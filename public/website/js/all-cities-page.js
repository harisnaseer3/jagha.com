(function ($) {
    $(document).ready(function () {
        function searchWithId(id) {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/searchWithID',
                data: {id: id},
                success: function (data) {
                    if (data.status === 200) {
                        location.assign(data.data);
                    } else $('#property_id-error').text(data.data)
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

        $('.record-limit').on('change', function (e) {
            insertParam('limit', $(this).val());
        });

        if ($('.pagination-box').length > 0) {
            let current_search_params = window.location.search.split('&page')[0];
            $('.page-item').each(function () {
                let link = $(this).find('a');
                if (link.length > 0) {
                    let fetched_link = link.attr('href');
                    let piece1 = fetched_link.split('?')[0];
                    let piece2 = fetched_link.split('?')[1];
                    link.attr('href', piece1 + current_search_params + '&' + piece2);
                }
            });
        }
        setInterval(function () {
            var docHeight = $(window).height();
            var footerHeight = $('#foot-wrap').height();
            var footerTop = $('#foot-wrap').position().top + footerHeight;
            var marginTop = (docHeight - footerTop);

            if (footerTop < docHeight)
                $('#foot-wrap').css('margin-top', marginTop + 'px'); // padding of 30 on footer
            else
                $('#foot-wrap').css('margin-top', '0px');
        }, 250);

        $('#subscribe-form').on('submit', function (e) {
            e.preventDefault();
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/subscribe',
                data: {
                    email: $('#subscribe').val()
                },
                dataType: 'json',
                success: function (data) {
                    if (data.status === 200) {
                        let btn = '';
                        if (data.msg === 'already exists') {
                            btn = '<button class="btn btn-block color-white" style="background-color: #274abb;"><i class="far fa-check-circle"></i> Already Subscribed </button>';
                        } else if (data.msg === 'new subscriber') {
                            btn = '<button class="btn btn-block color-white" style="background-color: #274abb;"><i class="far fa-check-circle"></i> Subscribed </button>';
                        }
                        $("#subscribe-form").slideUp();
                        $('.Subscribe-box').append(btn);
                    }
                },
                error: function (xhr, status, error) {
                    // console.log(error);
                },
                complete: function (url, options) {
                }
            });
        });


        let form = $('#sign-in-card');

        form.validate({
            rules: {
                email: {
                    required: true,
                },
                password: {
                    required: true,
                }
            },
            messages: {},
            errorElement: 'small',
            errorClass: 'help-block text-red',
            submitHandler: function (form) {
                event.preventDefault();
            },
            invalidHandler: function (event, validator) {
                // 'this' refers to the form
                const errors = validator.numberOfInvalids();
                if (errors) {
                    let error_tag = $('div.error.text-red');
                    error_tag.hide();
                    const message = errors === 1
                        ? 'You missed 1 field. It has been highlighted'
                        : 'You missed ' + errors + ' fields. They have been highlighted';
                    $('div.error.text-red span').html(message);
                    error_tag.show();
                } else {
                    $('div.error.text-red').hide();

                }
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
        $(document).on('change', '#alpha-switch', function () {
            event.preventDefault();
            let sort = 'unsort-alpha';
            let type = $('#type').val();
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if ($('#alpha-switch').is(':checked')) {
                sort = 'sort-alpha';
            }
            jQuery.ajax({
                type: 'get',
                url: window.location.origin + '/all_cities/pakistan/' + type,
                data: {'sort': sort},
                success: function (data) {
                    $('#all-cities-count-body').html(data.view);
                }
            })
        });
        $(document).on('change', '#alpha-partners-switch', function () {
            event.preventDefault();
            let sort = 'unsort-alpha';
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if ($('#alpha-partners-switch').is(':checked')) {
                sort = 'sort-alpha';
            }
            jQuery.ajax({
                type: 'get',
                url: window.location.origin + '/partners',
                data: {'sort': sort},
                success: function (data) {
                    $('#all-cities-partners-count-body').html(data.view);
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

                                '                     <div class="dropdown-divider"></div>' +
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
        // $('#search-property-ref').submit(function (event) {
        //     event.preventDefault();
        //     // searchWithId($('#ref-id').val());
        // });

    });
})(jQuery);
