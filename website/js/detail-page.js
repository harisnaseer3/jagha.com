(function ($) {
    let map;
    let service;
    var infowindow;
    var get_location;
    let image;
    let _markers = [];
    let container = $('#school');
    var latitude = container.data('lat');
    var longitude = container.data('lng');

    function initMap(value) {
        map = '';
        service = '';
        _markers = [];
        let place;
        if (value === 'school') place = 'school college and university';
        else if (value === 'park') place = 'park';
        else if (value === 'hospital') place = 'hospital, medical center and  Naval Hospital'
        else if (value === 'restaurant') place = 'restaurant and cafe'
        get_location = new google.maps.LatLng(latitude, longitude);
        infowindow = new google.maps.InfoWindow();
        map = new google.maps.Map(
            document.getElementById(value), {center: get_location, zoom: 15});
        var request = {
            location: get_location,
            radius: '500',
            query: place,
        };
        service = new google.maps.places.PlacesService(map);
        service.textSearch(request, callback);

        function callback(results, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                for (let i = 0; i < results.length; i++) {
                    createMarker(results[i], value);
                }
                const markerCluster = new MarkerClusterer(map, _markers,
                    {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
            }
        }
    }

    function createMarker(place, value) {
        var marker = new google.maps.Marker({
            map: map,
            position: place.geometry.location,
            icon: {url: '../website/img/marker/' + value + '.png', scaledSize: new google.maps.Size(45, 45)},
        });
        _markers.push(marker);
        google.maps.event.addListener(marker, 'click', function () {
            infowindow.setContent(place.name);
            infowindow.open(map, this);
        });
    }

    $(document).ready(function () {
        $('.map-canvas').on('click', function () {
            initMap($(this).data('value'));
            mapCall();
        });

        function mapCall() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'get',
                url: window.location.origin + '/mapCall',
                dataType: 'json',
                success: function (data) {
                }
            });
        }


        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover({trigger: "hover"});
        $.fn.stars = function () {
            return $(this).each(function () {
                let rating = $(this).data("rating");
                rating = rating > 5 ? 5 : rating
                const numStars = $(this).data("numStars");
                // const fullStar = '<i class="fas fa-star"></i>'.repeat(Math.floor(rating));
                let fullStar = '';
                for (let i = 1; i <= Math.floor(rating); i++) {
                    fullStar += '<i class="fas fa-star"></i>';
                }
                const halfStar = (rating % 1 !== 0) ? '<i class="fas fa-star-half-alt"></i>' : '';
                let noStar = '';
                for (let j = 1; j <= Math.floor(numStars - rating); j++) {
                    noStar += '<i class="far fa-star"></i>';
                }
                $(this).html(fullStar + halfStar + noStar);
            });
        }
        $('.stars').stars();
        // $('select option:first-child').css('cursor', 'default').prop('disabled', true);
        $('.select2').select2({
            language: '{{app()->getLocale()}}',
            direction: '{{app()->getLocale() === "en" ? "ltr" : "rtl"}}',
        });
        $('.select2bs4').select2({
            language: '{{app()->getLocale()}}',
            direction: '{{app()->getLocale() === "en" ? "ltr" : "rtl"}}',
            theme: 'bootstrap4',
        });
        $('.property-type-select2').on('change', function (e) {
            const selectedValue = $(this).val();
            $('[id^=property_subtype-]').attr('disable', 'true').slideUp();
            $('#property_subtype-' + selectedValue).attr('disable', 'true').slideDown();
        });
        let icons = $('.icon-list');
        if (icons.length === 0) {
            $('.properties-amenities').hide();
        }
        //    description show more and less
        let defaultHeight = 50; // height when "closed"
        let text = $('.description');
        let textHeight = text[0].scrollHeight; // the real height of the element
        let button = $(".button");
        text.css({"max-height": defaultHeight, "overflow": "hidden"});
        button.on("click", function () {
            var newHeight = 0;
            if (text.hasClass("active")) {
                newHeight = defaultHeight;
                button.text('Read More');
                text.removeClass("active");
            } else {
                newHeight = textHeight;
                button.text('Read Less');
                text.addClass("active");
            }
            text.animate({
                "max-height": newHeight
            }, 500);
        });
        let features = $('.features-list');
        let show_feature = $('.show-features');
        if (features.length > 0 && icons.length > 3) {
            show_feature.show();
            let text2 = features;
            let textHeight2 = text2[0].scrollHeight; // the real height of the element
            let button2 = $(".button2");
            text2.css({"max-height": defaultHeight, "overflow": "hidden"});
            button2.on("click", function () {
                let newHeight2 = 0;
                if (text2.hasClass("active")) {
                    newHeight2 = defaultHeight;
                    button2.text('Show More');
                    text2.removeClass("active");
                } else {
                    newHeight2 = textHeight2;
                    button2.text('Show Less');
                    text2.addClass("active");
                }
                text2.animate({
                    "max-height": newHeight2
                }, 500);
            });
        }
    });


    let input = document.querySelector("#cell");
    var errorMsg = document.querySelector("#error-msg");
    var validMsg = document.querySelector("#valid-msg");
    var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
    var ag_iti_cell = window.intlTelInput(input, {
        preferredCountries: ["pk"],
        preventInvalidNumbers: true,
        separateDialCode: true,
        numberType: "MOBILE",
        utilsScript: "/../../plugins/intl-tel-input/js/utils.js?1603274336113"
    });
    var reset = function () {
        input.classList.remove("error");
        input.classList.remove("valid");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
    };
    input.addEventListener('blur', function () {
        reset();
        if (input.value.trim()) {
            if (ag_iti_cell.isValidNumber()) {
                $('[name=phone]').val(ag_iti_cell.getNumber());
                validMsg.classList.remove("hide");
                $('#phone-error').hide();
            } else {
                // input.classList.add("error");

                var errorCode = ag_iti_cell.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("hide");
                $('[name=phone]').val('');
            }
        }
    });

    input.addEventListener('change', reset);
    input.addEventListener('keyup', reset);

    let phone = '';
    let form = $('#email-contact-form');

    form.validate({
        rules: {
            name: {
                required: true,
            },
            'phone_#': {
                required: true,
                // checkcellnum: true,
            },
            'phone': {
                required: true,
                // checkcellnum: true,
            },
            email: {
                required: true,
                email: true
            },
            message: {
                required: true,
            },
        },
        messages: {'phone': ", please enter a valid value."},
        errorElement: 'span',
        errorClass: 'error help-block text-red',
        ignore: [],

        submitHandler: function (form) {
            form.preventDefault();
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
                document.querySelector("input").classList.remove("valid");
            }
        }
    });


    $('.btn-email').click(function (e) {
        let property = $(this).closest('#email-contact-form').find('input[name=property]').val();
        let title = $(this).closest('#email-contact-form').find('input[name=title]').val();
        let agency = $(this).closest('#email-contact-form').find('input[name=agency]').val();
        let reference = $(this).closest('.contact-container').find('input[name=reference]').val();
        let property_link = $(this).closest('.contact-container').find('.property-description').find('a').attr('href');
        let anchor_link = '<a href="' + property_link + '" style="text-decoration:underline; color:blue">' + property_link + ' </a>';
        let link = '<a href="https://www.aboutpakistan.com" style="text-decoration:underline; color:blue">https://www.aboutpakistan.com</a>.';

        let message = 'I would like to inquire about your property\n' + anchor_link + 'Property ID <span style="text-decoration:underline; color:blue">' + property + '</span> displayed at ' + link + '<br><br> Please contact me at your earliest.';

        phone = $(this).closest('.contact-container').find('input[name=phone]').val();
        let editable_div = $('.editable-div');
        // editable_div.html(message);
        $('input[name=message]').val(editable_div.html());
        editable_div.click(function () {
            if (editable_div.html() !== '') {
                $('input[name=message]').val(editable_div.html());
            }
        });
        if (!(property === undefined))
            $('.selected').val(property).attr('name', 'property');
        else if (!(agency === undefined))
            $('.selected').val(agency).attr('name', 'agency');
        call_btn.text('Call');
    });
    let call_btn = $('.agent-call');
    call_btn.on('click', function () {
        call_btn.attr('href', 'tel:' + phone).text(phone);
    });

    $('#send-mail').click(function (event) {
        if (form.valid()) {
            event.preventDefault();
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/contactAgent',
                data: form.serialize(),
                dataType: 'json',
                success: function (data) {
                    if (data.status === 200) {
                        // console.log(data.data);
                        form.trigger("reset");
                        $('#EmailModelCenter').modal('hide');
                        $('#EmailConfirmModel').modal('show');
                    } else {
                        // console.log(data.data);
                    }
                },
                error: function (xhr, status, error) {
                    // console.log(error);
                    // console.log(status);
                    // console.log(xhr);
                },
                complete: function (url, options) {
                }
            });
        }
    });


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

    let property = $('#email-contact-form').find('input[name=property]').val();
    let req_div = $('.detail-page-agency-properties');
    if (req_div.length > 0) {
        $.get('/get-agency-properties', {'agency': req_div.attr('data-val'), 'property': property},  // url
            function (data, textStatus, jqXHR) {  // success callback
                $('.ajax-loader-2').hide();
                if (data !== 'not available') {
                    $('.display-data-2').show();
                    let slider = $('.slick-carousel');
                    let agency_properties = $('#agency-properties-section');
                    slider.slick('unslick');

                    agency_properties.html('');
                    agency_properties.html(data.view);

                    slider.slick({arrows: false, slidesToShow: 3, responsive: [{breakpoint: 1024, settings: {slidesToShow: 2}}, {breakpoint: 768, settings: {slidesToShow: 1}}]}
                    )
                    // $('.detail-tab-style').append('<li class="nav-item li-detail-page text-transform mr-1">' +
                    //     '<a class="nav-link detail-nav-style" id="4-tab" href="#four" role="tab" aria-controls="4" aria-selected="true">More Properties</a></li>');
                    $('[data-toggle="tooltip"]').tooltip();
                    $('.favorite').on('click', function (e) {
                        // console.log('data');
                        $(this).hide();
                        addFavorite($(this).data('id'), $(this), 'add');
                        $(this).next().show();
                    });

                    $('.remove-favorite').on('click', function (e) {
                        // console.log('remove data');
                        $(this).hide();
                        addFavorite($(this).data('id'), $(this), 'delete');
                        $(this).prev().show();
                    });
                }

                $('.search-options-btn').on('click', function () {
                    $('#details-page').toggleClass('properties-page2').toggleClass('properties-page1');

                });

            });
    }

    $.get('/get-similar-properties', {'property': property},  // url
        function (data, textStatus, jqXHR) {  // success callback
            $('.ajax-loader').hide();
            if (data !== 'not available') {
                $('.display-data').show();
                let slider = $('.slick-carousel');
                let similar_properties = $('#similar-properties-section');
                slider.slick('unslick');

                similar_properties.html('');
                similar_properties.html(data.view);

                slider.slick({arrows: false, slidesToShow: 3, responsive: [{breakpoint: 1024, settings: {slidesToShow: 2}}, {breakpoint: 768, settings: {slidesToShow: 1}}]}
                )
                // $('.detail-tab-style').append('<li class="nav-item li-detail-page text-transform mr-1">' +
                //     '<a class="nav-link detail-nav-style" id="4-tab" href="#four" role="tab" aria-controls="4" aria-selected="true">Similar Properties</a></li>');
                $('[data-toggle="tooltip"]').tooltip();
                $('.favorite').on('click', function (e) {
                    // console.log('data');
                    $(this).hide();
                    addFavorite($(this).data('id'), $(this), 'add');
                    $(this).next().show();
                });

                $('.remove-favorite').on('click', function (e) {
                    // console.log('remove data');
                    $(this).hide();
                    addFavorite($(this).data('id'), $(this), 'delete');
                    $(this).prev().show();
                });
            }

            $('.search-options-btn').on('click', function () {
                $('#details-page').toggleClass('properties-page2').toggleClass('properties-page1');

            });

        });


})
(jQuery);
