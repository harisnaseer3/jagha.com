(function ($) {
    function searchWithparams() {
        let baseurl = window.location.origin;
        let page_link = '';
        let purpose = '';
        let type = '';
        let city = '';
        let beds = '';
        let min_price = '';
        let max_price = '';
        let min_area = '';
        let max_area = '';
        let area_unit = '';
        let location = '';
        let subtype = '';

        purpose = $('[name = property_purpose]').val();
        type = $('[name = property_type]').val();
        city = $('[name = city]').val();
        min_price = $('[name = min_price]').val();
        max_price = $('[name = max_price]').val();
        min_area = $('[name = min_area]').val();
        max_area = $('[name = max_area]').val();
        area_unit = $('[name = property_area_unit]').val();
        beds = $('[name = bedrooms]').val();
        subtype = $('[name^= property_subtype-' + type + ']').val();
        location = $('#location').val();
        page_link = baseurl + '/'
        if (subtype == null) page_link += type.toLowerCase();
        else page_link += subtype.replace(/ /g, '-').toLowerCase();
        page_link += '_for_';
        if (purpose === 'Buy')
            page_link += 'sale';
        else page_link += purpose.toLowerCase();

        if (min_area < 0 || max_area < 0) {
            min_area = '';
            max_area = '';
        }
        if (min_price < 0 || max_price < 0) {
            min_price = 0;
            max_price = 0;
        }


        page_link += '/' + city.replace(/ /g, '-').toLowerCase() + '?';
        if (location !== '') page_link += 'location=' + location.replace(/-/g, '_').replace(/ /g, '-').toLowerCase();
        if (min_price !== '0' && min_price !== null && min_price !== '') page_link += '&min_price=' + min_price;
        if (max_price !== 'Any' && max_price !== null && max_price !== '') page_link += '&max_price=' + max_price;
        if (min_area !== '0' && min_area !== null && min_area !== '') page_link += '&min_area=' + min_area;
        if (max_area !== 'Any' && max_area !== null && max_area !== '') page_link += '&max_area=' + max_area;
        if (beds !== 'All' && beds !== null) page_link += '&bedrooms=' + beds;
        page_link += '&area_unit=' + area_unit.replace(' ', '-').toLowerCase();
        page_link += '&sort=newest';
        window.location.href = page_link;
    }

    function search2Withparams() {
        let baseurl = window.location.origin;

        let purpose = '',
            type = '',
            city = '',
            beds = '',
            min_price = '',
            max_price = '',
            min_area = '',
            max_area = '',
            area_unit = '',
            location = '',
            subtype = '';

        purpose = $('#search2-property-purpose').val();
        type = $('#search2-property-type').val();
        city = $('#search2-city').val();
        min_price = $('#search2-select-min-price').val();
        max_price = $('#search2-select-max-price').val();
        min_area = $('#search2-select-min-area').val();
        max_area = $('#search2-select-max-area').val();
        area_unit = $('[name = search2-unit]').val();
        beds = $('#search2-beds').val();
        subtype = $('[id^= search2-subtype-' + type + ']').val()
        location = $('#search2-location').val();
        let page_link = baseurl + '/'
        if (subtype == null) page_link += type.toLowerCase();
        else page_link += subtype.replace(/ /g, '-').toLowerCase();
        page_link += '_for_';
        if (purpose === 'Buy')
            page_link += 'sale';
        else page_link += purpose.toLowerCase();
        if (min_area < 0 || max_area < 0) {
            min_area = '';
            max_area = '';
        }
        if (min_price < 0 || max_price < 0) {
            min_price = 0;
            max_price = 0;
        }

        page_link += '/' + city.replace(/ /g, '-').toLowerCase() + '?';
        if (location !== '') page_link += 'location=' + location.replace(/-/g, '_').replace(/ /g, '-').toLowerCase();
        if (min_price !== '0' && min_price !== null && min_price !== '') page_link += '&min_price=' + min_price;
        if (max_price !== 'Any' && max_price !== null && max_price !== '') page_link += '&max_price=' + max_price;
        if (min_area !== '0' && min_area !== null && min_area !== '') page_link += '&min_area=' + min_area;
        if (max_area !== 'Any' && max_area !== null && max_area !== '') page_link += '&max_area=' + max_area;
        if (beds !== 'All' && beds !== null) page_link += '&bedrooms=' + beds;
        page_link += '&area_unit=' + area_unit.replace(' ', '-').toLowerCase();
        page_link += '&sort=newest';
        window.location.href = page_link;
    }

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

            },
            complete: function (url, options) {
            }
        });
    }

    function addFavorite(id, selector, task) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: 'get',
            url: task === 'add' ? window.location.origin + '/dashboard/properties/' + id + '/favorites' : window.location.origin + '/dashboard/properties/' + id + '/favorites/1',
            dataType: 'json',
            success: function (data) {
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
            complete: function (url, options) {
            }
        });
    }

    function getCityLocations(city) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: 'get',
            url: window.location.origin + '/locations',
            data: {city: city},
            dataType: 'json',
            success: function (data) {
                let locations = data.data;
                // if (!jQuery.isEmptyObject({locations})) {

                let datalist = $('.location-datalist');
                let html = '';
                $.each(data.data, function (index, value) {
                    html += '<option value="' + value.name + '">';
                });
                datalist.html(html);
                // }
            },
            error: function (xhr, status, error) {

            },
            complete: function (url, options) {
            }
        });
    }

    function getDetailPropertyFavData(user, property) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: 'post',
            url: window.location.origin + '/propertyFavorite',
            data: {property: property},
            dataType: 'json',
            success: function (data) {
                if (data.status === 200) {
                    let html = '<div class="favorite-property ratings" style="font-size: 20px;">';
                    if (data.data === user) {
                        html += '<a href="javascript:void(0);" style="color: white; display: none" class="detail-favorite" data-id="' + property + '">' +
                            '<i class="fal fa-heart empty-heart"></i>' +
                            '</a>' +
                            '<a href="javascript:void(0);" style="color: black; display :block"  class="detail-remove-favorite" data-id="' + property + '">' +
                            '<i class="fas fa-heart filled-heart" style="color: red;"></i>' +
                            '</a>' +
                            '</div>';
                    } else if (data.data === 'not available') {
                        html += '<a href="javascript:void(0);" style="color: white; display:block"  class="detail-favorite" data-id="' + property + '">' +
                            '<i class="fal fa-heart empty-heart"></i>' +
                            '</a>' +
                            '<a href="javascript:void(0);" style="color: black; display :none" class="detail-remove-favorite" data-id="' + property + '">' +
                            '<i class="fas fa-heart filled-heart" style="color: red;"></i>' +
                            '</a>' +
                            '</div>';
                    }
                    let section = $('.detail-page-fav')
                    section.html('');
                    section.html(html);

                    $('.detail-favorite').on('click', function (e) {
                        let require_btn = $('.detail-favorite');
                        require_btn.hide();
                        addFavorite($(this).data('id'), $(this), 'add');
                        require_btn.next().show();
                    });
                    $('.detail-remove-favorite').on('click', function (e) {
                        let require_btn = $('.detail-remove-favorite');
                        require_btn.hide();
                        addFavorite($(this).data('id'), $(this), 'delete');
                        require_btn.prev().show();
                    });

                }
            },
            error: function (xhr, status, error) {

            },
            complete: function (url, options) {
            }
        });
    }

    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function eraseCookie(name) {
        document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }

    function cookieConsent() {
        if (!getCookie('allowCookies')) {
            $('.toast').show();
        }
    }

    $('#btnDeny').click(function () {
        eraseCookie('allowCookies');
        $('.toast').toast('hide');
    })


    $(document).ready(function () {
        $('#search-property-ref').submit(function (event) {
            event.preventDefault();
            searchWithId($('#ref-id').val());
        });


        $('.index-form').submit(function (event) {
            event.preventDefault();
            searchWithparams();
        });

        $('.index-form-2').submit(function (event) {
            event.preventDefault();
            search2Withparams();
        });

        $('.favorite').on('click', function (e) {
            $(this).hide();
            addFavorite($(this).data('id'), $(this), 'add');
            $(this).next().show();
        });

        $('.remove-favorite').on('click', function (e) {
            $(this).hide();
            addFavorite($(this).data('id'), $(this), 'delete');
            $(this).prev().show();
        });

        $('.detail-favorite').on('click', function (e) {
            let require_btn = $('.detail-favorite');
            require_btn.hide();
            addFavorite($(this).data('id'), $(this), 'add');
            require_btn.next().show();
        });
        $('.detail-remove-favorite').on('click', function (e) {
            let require_btn = $('.detail-remove-favorite');
            require_btn.hide();
            addFavorite($(this).data('id'), $(this), 'delete');
            require_btn.prev().show();
        });

        let property_type = $('.property-type-select2');
        property_type.on('change', function (e) {
            const selectedValue = $(this).val();
            if (selectedValue === 'Plots' || selectedValue === 'Commercial') $('.beds-block').hide();
            else $('.beds-block').show();

            $('[id^=property_subtype-]').hide();
            $('[id^=search2-property_subtype-]').hide();
            $('#property_subtype-' + selectedValue).toggle();
            $('#search2-property_subtype-' + selectedValue).toggle();
        });
        if (property_type.val() === 'Plots') $('.beds-block').hide();

        let selectedValue = '';
        if ($('.detail-page-banner').is(":visible")) {
            selectedValue = property_type.val();
            getCityLocations($('#city option:selected').val());
        } else {
            selectedValue = $('#search2-property-type').val();
            getCityLocations($('#search2-city option:selected').val());
        }
        $('[id^=search2-property_subtype-]').hide();
        $('[id^=-property_subtype-]').hide();
        $('#search2-property_subtype-' + selectedValue).toggle();
        $('#property_subtype-' + selectedValue).toggle();

        $('#city').on('change', function (e) {
            getCityLocations($('#city option:selected').val());
        });

        $('#search2-city').on('change', function (e) {
            getCityLocations($('#search2-city option:selected').val());
        });

        $('.reset-search-option').on('click', function () {
            $('#location').val('');
            $('input[name=area_unit]').val('Marla');
            $('.index-form').trigger('reset');
            $('.index-form-2').trigger('reset');
            $('.custom-select').data('index', '0').trigger('change');

            sessionStorage.clear();

        });

        $('.reset-search-banner2, #reset-search-banner2lg').on('click', function () {

            $.each($('.custom-select'), function (index, value) {
                if (!!~(value.id).indexOf("purpose"))
                    $(this).val('Buy').trigger('change');
                if (!!~(value.id).indexOf("type"))
                    $(this).val('Homes').trigger('change');
                if (!!~(value.id).indexOf("city"))
                    $(this).val('Islamabad').trigger('change');
                if (!!~(value.id).indexOf("beds"))
                    $(this).val('All').trigger('change');
                if (!!~(value.id).indexOf("min-price"))
                    $(this).val('0').trigger('change');
                if (!!~(value.id).indexOf("max-price"))
                    $(this).val('Any').trigger('change');
                if (!!~(value.id).indexOf("min-area"))
                    $(this).val('0').trigger('change');
                if (!!~(value.id).indexOf("max-area"))
                    $(this).val('Any').trigger('change');
                if (!!~(value.id).indexOf("area-unit"))
                    $(this).val('Marla').trigger('change');
            });
            sessionStorage.clear();
            $('.index-form').trigger('reset');
            $('.index-form-2').trigger('reset');

            $('#search2-location').val('');
            $('#location').val('');
        });

        $(document.body).on("change", "[name=max_area]", function () {
            // console.log('here1');
            let data2 = $(this).val();
            sessionStorage.setItem('max_area', data2);
        });
        $(document.body).on("change", "[name=min_area]", function () {
            let data1 = $(this).val();
            sessionStorage.setItem('min_area', data1);
        });

        $(document.body).on("change", "[name=min_price]", function () {
            let data1 = $(this).val();
            sessionStorage.setItem('min_price', data1);
        });
        $(document.body).on("change", "[name=max_price]", function () {
            let data2 = $(this).val();
            sessionStorage.setItem('max_price', data2);
        });

        if (sessionStorage.getItem('max_area') !== null) {
            $('#select-max-area').val(parseInt(sessionStorage.getItem('max_area')));
            $('#search2-select-max-area').val(parseInt(sessionStorage.getItem('max_area')));
        }
        if (sessionStorage.getItem('min_area') !== null) {
            $('#select-min-area').val(parseInt(sessionStorage.getItem('min_area')));
            $('#search2-select-min-area').val(parseInt(sessionStorage.getItem('min_area')));
        }
        if (sessionStorage.getItem('min_price') !== null) {
            $('#select-min-price').val(parseInt(sessionStorage.getItem('min_price')));
            $('#search2-select-min-price').val(parseInt(sessionStorage.getItem('min_price')));
        }
        if (sessionStorage.getItem('max_price') !== null) {
            $('#select-max-price').val(parseInt(sessionStorage.getItem('max_price')));
            $('#search2-select-max-price').val(parseInt(sessionStorage.getItem('max_price')));
        }


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
                const errors = validator.numberOfInvalids();
                if (errors) {
                    let error_tag = $('div.error.text-red');
                    error_tag.hide();
                    const message = errors === 1 ?
                        'You missed 1 field. It has been highlighted' :
                        'You missed ' + errors + ' fields. They have been highlighted';
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
                        if (data.data) {
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
                                '            <div class="dropdown">' +
                                '                <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="javascript:void(0);" id="dropdownMenuButton" aria-haspopup="true"' +
                                '                    aria-expanded="false">' +
                                '                      <i class="fas fa-user mr-2"></i>';
                            html += '<span class="mr-1">' + user_name + ' (ID: ' + user_id + ')' + '<span>';
                            html += '</a>' +
                                '                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                            html += '<a class="dropdown-item" href=" ' + window.location.origin + '/dashboard/accounts/users/' + user_id + '/edit"><i class="far fa-user-cog mr-2"></i>Manage Profile</a>' +
                                '                     <div class="dropdown-divider"></div>' +
                                '<a class="dropdown-item" href=" ' + window.location.origin + '/dashboard/listings/status/active/purpose/all/user/' + user_id + '/sort/id/order/asc/page/10"><i class="fa fa-building-o mr-2"></i>Property Management </a>' +
                                '                     <div class="dropdown-divider"></div>' +
                                '                          <a class="dropdown-item" href="' + window.location.origin + '/dashboard/accounts/logout' + '"><i class="far fa-sign-out mr-2"></i>Logout</a>';
                            html += '</div>' + '</div>';
                            let html_profile_link = '<a class="nav-link theme-dark-blue" href="' + window.location.origin + '/dashboard/accounts/users/' + user_id + '/edit" >Profile Management</a>';
                            let html_property_link = '<a class="nav-link theme-dark-blue" href=" ' + window.location.origin + '/dashboard/listings/status/active/purpose/all/user/' + user_id + '/sort/id/order/asc/page/10"> Property Management </a>';

                            user_dropdown.html(html);
                            nav_property_link.html(html_property_link);
                            nav_profile_link.html(html_profile_link);


                            if ($('.user-name').length > 0) {
                                $('input[name=name]').val(data.user.name);
                                $('input[name=email]').val(data.user.email)
                            }
                            if ($('.fav-section-index').length > 0) {
                                let slider = $('#featured-properties-section');
                                slider.html('');
                                $('#ajax-loader-properties').show();
                                $.get('/get-featured-properties',
                                    function (data, textStatus, jqXHR) {
                                        slider.slick('unslick');
                                        $('#ajax-loader-properties').hide();

                                        slider.html(data.view);
                                        slider.slick({arrows: false, slidesToShow: 3, responsive: [{breakpoint: 1024, settings: {slidesToShow: 2}}, {breakpoint: 768, settings: {slidesToShow: 1}}]}
                                        )

                                        $('[data-toggle="tooltip"]').tooltip();
                                        $('.favorite').on('click', function (e) {
                                            $(this).hide();
                                            addFavorite($(this).data('id'), $(this), 'add');
                                            $(this).next().show();
                                        });

                                        $('.remove-favorite').on('click', function (e) {
                                            $(this).hide();
                                            addFavorite($(this).data('id'), $(this), 'delete');
                                            $(this).prev().show();
                                        });
                                    });
                            }
                            if ($('.fav-section-detail').length > 0) {
                                let similar_properties = $('#similar-properties-section');
                                $('.display-data').hide();
                                similar_properties.html('');
                                $('.ajax-loader').show();
                                $('#ajax-loader-properties').show();
                                $.get('/get-similar-properties', {'property': $('#email-contact-form').find('input[name=property]').val()},
                                    function (data, textStatus, jqXHR) {
                                        let slider = $('.slick-carousel');
                                        $('.display-data').show();
                                        $('#ajax-loader-properties').hide();
                                        slider.slick('unslick');

                                        similar_properties.html('');
                                        similar_properties.html(data.view);

                                        slider.slick({arrows: false, slidesToShow: 3, responsive: [{breakpoint: 1024, settings: {slidesToShow: 2}}, {breakpoint: 768, settings: {slidesToShow: 1}}]}
                                        )

                                    });
                            }
                            if ($('.detail-page-fav').length > 0) {
                                let page = $('.detail-page-fav');
                                let key = page.attr('data-id');
                                page.html('<i class="fa fa-spinner fa-spin"></i>');
                                getDetailPropertyFavData(user_id, key);
                            }
                        } else if (data.error) {
                            $('div.help-block small').html(data.error.password);
                            $('.error-tag').show();
                        }
                    },
                    error: function (xhr, status, error) {
                        event.preventDefault();

                    },
                    complete: function (url, options) {
                    }
                });
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

        $('#btnAccept').click(function () {
            setCookie('allowCookies', '1', 7);
            $('.toast').hide();
        })
        cookieConsent()

    });
})
(jQuery);
