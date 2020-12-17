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
    setTimeout(function () {
        //     $("#subscribeModalCenter").modal('show')
        // }, 3000);
        $('#load-more').on('click', function (e) {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'get',
                url: window.location.origin + '/load-more-data',
                data: {
                    id: $('#blog-list').data('index')
                },
                dataType: 'json',
                beforeSend: function () {
                    $("#load-more").html('Loading...');
                },
                success: function (data) {
                    if (data.status === 200) {
                        $('.more-blogs').append(data.data.html);
                        $('#blog-list').attr('data-index', data.data.last_id)

                    } else {
                        $('.more-blogs').append(data.data);
                        $('#load-more').hide();
                        // console.log(data.data);
                    }
                },
                error: function (xhr, status, error) {
                    // console.log(xhr);
                    // console.log(status);
                    // console.log(error);
                },
                complete: function (url, options) {
                    $("#load-more").html('Load More');
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
                            let user_dropdown = $('.user-dropdown')
                            user_dropdown.html('');
                            let user_name = data.user.name;
                            let user_id = data.user.id;
                            let html =
                                '            <div class="dropdown">' +
                                '                <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="javascript:void(0);" id="dropdownMenuButton" aria-haspopup="true"' +
                                '                    aria-expanded="false">' +
                                '                      <i class="fas fa-user mr-2"></i>';
                            html += '<span class="mr-1">'+ user_name + ' (ID: ' + user_id + ')'+'<span>' ;
                            html += '</a>' +
                                '                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                            html += '<a class="dropdown-item" href=" ' + window.location.origin + '/dashboard/accounts/users/' + user_id + '/edit"><i class="far fa-user-cog mr-2"></i>Manage Profile</a>' +
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
        $('#search-property-ref').submit(function (event) {
            event.preventDefault();
            searchWithId($('#ref-id').val());
        });

    })
});
