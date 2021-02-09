(function ($) {
    let map;
    let service;
    var infowindow;
    var get_location;

    let container = $('#property_map');

    var latitude = container.data('lat');
    var longitude = container.data('lng');

    function initMap(value) {
        map = '';
        service = '';
        _markers = [];
        // let place;
        // if (value === 'school') place = 'school college and university';
        // else if (value === 'park') place = 'park';
        // else if (value === 'hospital') place = 'hospital, medical center and  Naval Hospital'
        // else if (value === 'restaurant') place = 'restaurant and cafe'
        get_location = new google.maps.LatLng(latitude, longitude);
        infowindow = new google.maps.InfoWindow();
        map = new google.maps.Map(
            document.getElementById(value), {center: get_location, zoom: 15});
        var request = {
            location: get_location,
            radius: '500',
            // query: place,
        };
        service = new google.maps.places.PlacesService(map);
        service.textSearch(request, callback);

        function callback(results, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                for (let i = 0; i < results.length; i++) {
                    createMarker(results[i], value);
                }
                // const markerCluster = new MarkerClusterer(map, _markers,
                //     {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
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


    var store_image_name = [];
    var store_image_name_order = [];
    let get_badge_value = 0;


    //this value is only used check the image count
    var imageCountOnError = 0;

    function checkImagesCountLimit(count) {
        if (store_image_name.length + count + imageCountOnError > 60) {
            console.log(store_image_name.length + count + imageCountOnError);
            alert('You can select 60 images only');
            return false;
        } else
            return true;
    }

    function displayImages(name) {
        let image = name.split('.')[0];
        let count = 0;
        // if (get_badge_value !== 0) {
        //     count = store_image_name.length + parseInt(get_badge_value);
        // } else {
        //     get_badge_value = 0;
        //     count = store_image_name.length;
        // }
        // if ($('#sortable li').length > 0 ) {
        count = $('#sortable li').length + parseInt(1);
        // }
        let src = window.location.origin + '/thumbnails/properties/' + image + '-450x350.webp';
        let html =
            '<li class="ui-state-default m-2 upload-image-block ui-sortable-handle" >' +
            '<div style="position: relative; width: 100%; height: 50% ;margin:0 auto;">' +
            '<img src="' + src + '" width="100%" class="img-responsive" alt="image not available" data-num="' + count + '" data-value="' + image + '"/>' +
            '</div>' +
            '<div class="badge badge-primary badge-pill p-2 f-12" style="position: absolute; ; margin-left: 130px;  margin-top: 65px; z-index: 99;">' + count + '</div>' +
            '<a class="btn remove-images" data-toggle-1="tooltip" data-placement="bottom" title="delete"' +
            ' style="position: absolute; margin-left: 146px; margin-top: 56px; z-index: 1">' +
            '<i class="fad fa-trash fa-1x" style="color: red;font-size: 30px"></i> </a>' +
            +'</li>';
        $('#show_image_spinner').hide();
        $('#sortable').append(html).sortable('refresh');
        $('.add-images').show();
    }

    function showImagesCount(images) {
        imageCountOnError !== 0 ? imageCountOnError = imageCountOnError + 1 : imageCountOnError = 0;
        let total = parseInt($('#image-count').attr('data-count')) + 1;
        $('#image-count').show().attr('data-count', total).text(total);
    }

    function showImagesCountOnRemove(images) {
        imageCountOnError !== 0 ? imageCountOnError = imageCountOnError - 1 : imageCountOnError = 0;
        //to get the recent count  rather than length of array length
        let current_val = parseInt($('#image-count').attr('data-count')) - 1;

        // let total = parseInt(images.length) + parseInt(imageCountOnError) +  parseInt($('#image-count').attr('data-count'));
        let total = current_val;
        $('#image-count').attr('data-count', total).show().text(total);
    }

    function displayImagesOnError() {
        let image_data = JSON.parse($('[name=image]').val());
        // showImagesCountOnRemove(image_data);
        $('#image-count').attr('data-count', image_data.length).show().text(image_data.length);
        imageCountOnError = image_data.length;
        get_badge_value = image_data.length;

        $.each(image_data, function (idx, val) {
            // let image = val.split('.')[0];
            let index = parseInt(idx + 1)
            for (n in val) {
                let image = n.split('.')[0].replace('"', '');
                let src = window.location.origin + '/thumbnails/properties/' + image + '-450x350.webp';
                let html = '<li class="ui-state-default m-2 upload-image-block ui-sortable-handle" >' +
                    '<div style="position: relative; width: 100%; height: 50% ;margin:0 auto;">' +
                    '<img src="' + src + '" width="100%" class="img-responsive" alt="image not available" data-num="' + val[n] + '" data-value="' + image + '"/>' +
                    '</div>' +
                    '<div class="badge badge-primary badge-pill p-2 f-12" style="position: absolute; ; margin-left: 130px;  margin-top: 65px; z-index: 99;">' +
                    val[n] + '</div>' +
                    '<a class="btn remove-images" data-toggle-1="tooltip" data-placement="bottom" title="delete"' +
                    ' style="position: absolute; margin-left: 146px; margin-top: 56px; z-index: 1">' +
                    '<i class="fad fa-trash fa-1x" style="color: red;font-size: 30px"></i> </a>' +
                    +'</li>';
                $('#show_image_spinner').hide();
                $('#sortable').append(html).sortable('refresh');
                $('.add-images').show();
            }
        });
    }

    function iti_contact_number(input, errorMsg, validMsg, field, error_div, phone_type, check_field = '') {
        var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
        let ag_iti_cell = '';
        if (phone_type === "MOBILE") {
            ag_iti_cell = window.intlTelInput(input, {
                utilsScript: "../../../../plugins/intl-tel-input/js/utils.js",
                preferredCountries: ["pk"],
                preventInvalidNumbers: true,
                separateDialCode: true,
                numberType: "MOBILE",
            });
        } else if (phone_type === "FIXED_LINE") {
            ag_iti_cell = window.intlTelInput(input, {
                utilsScript: "../../../../plugins/intl-tel-input/js/utils.js",
                preferredCountries: ["pk"],
                preventInvalidNumbers: true,
                separateDialCode: true,
                placeholderNumberType: "FIXED_LINE",
                numberType: "FIXED_LINE",
            });
        }

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
                    field.val(ag_iti_cell.getNumber());
                    validMsg.classList.remove("hide");
                    $(error_div).hide();
                    if (check_field !== '') $('[' + check_field + ']').val('');
                } else {
                    var errorCode = ag_iti_cell.getValidationError();
                    errorMsg.innerHTML = errorMap[errorCode];
                    errorMsg.classList.remove("hide");
                    field.val('');
                    if (check_field !== '') $('[' + check_field + ']').val(errorMap[errorCode]);
                }
            }
        });

        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);
    }

    $(document).ready(function () {
        let sort = $("#sortable");
        sort.sortable({
            helper: "clone",
            placeholder: "ui-state-highlight",
            cursor: "move",
            appendTo: document.body,
            scrollSpeed: 60,
            forceHelperSize: true,
            scrollSensitivity: 10,
            tolerance: "pointer",
            stop: function (ev, ui) {
                var children = $('#sortable').sortable('refreshPositions').children();
                store_image_name_order = [];
                $.each(children, function (idx, val) {
                    let data_name = $(this).find('img').attr('data-value');
                    let data_count = parseInt(idx + 1);
                    $(this).find('.badge').text(data_count);
                    var object = {};
                    object[data_name] = JSON.stringify(data_count);
                    store_image_name_order.push(object);
                });
                $('#store-images').val(JSON.stringify(store_image_name_order));
            }
        });
        sort.disableSelection();

        //in case of an error
        if ($('[name=image]').val() !== undefined && $('[name=image]').val() !== '') {
            displayImagesOnError();
        }
        let count_div = $('#edit-count');
        if (count_div.attr('data-count') > 0) {
            imageCountOnError = parseInt(count_div.attr('data-count'));
            $('#image-count').attr('data-count', count_div.attr('data-count')).show().text(count_div.attr('data-count'));

        }
        $(document).on('click', '.delete-image-btn', function () {
            let image = $(this).attr('data-record-id');
            let selected_div = $(this).parent();
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: window.location.origin + '/admin/images/' + image,
                type: "POST",
                data: {
                    _method: "DELETE"
                },
                success: function (data) {
                    if (data.status === 200) {
                        // $('#delete-image').modal('hide');
                        // let flash_msg = '<div class="alert alert-success alert-block">' +
                        //     '<button type="button" class="close" data-dismiss="alert">×</button>' +
                        //     '<strong>Image Deleted Successfully</strong>' +
                        //     '</div>';
                        // $('#flash-msg').show().html(flash_msg);
                        // $("[data-id='" + image + "']").parent().parent().remove();
                        //
                        // imageCountOnError !== 0 ? imageCountOnError = imageCountOnError - 1 : imageCountOnError = 0;
                        // let count = parseInt($('#image-count').attr('data-count')) - 1;
                        // $('#image-count').attr('data-count', count).show().text(count);

                        selected_div.remove();
                        imageCountOnError !== 0 ? imageCountOnError = imageCountOnError - 1 : imageCountOnError = 0;
                        let count = parseInt($('#image-count').attr('data-count')) - 1;
                        $('#image-count').attr('data-count', count).show().text(count);
                        // $(this).parent('li').remove();
                        var children = $('#sortable').sortable('refreshPositions').children();
                        store_image_name_order = [];
                        $.each(children, function (idx, val) {
                            let data_name = $(this).find('img').attr('data-value');
                            let data_count = parseInt(idx + 1);
                            $(this).find('.badge').text(data_count);
                            var object = {};
                            object[data_name] = JSON.stringify(data_count);
                            store_image_name_order.push(object);
                        });
                        $('#store-images').val(JSON.stringify(store_image_name_order));


                    } else if (data.status === 404) {
                        $('#delete-image').modal('hide');

                        let flash_msg = '<div class="alert alert-danger alert-block">' +
                            '<button type="button" class="close" data-dismiss="alert">×</button>' +
                            '<strong>Image not found.</strong>' +
                            '</div>';

                    }
                },
                error: function (xhr, status, error) {
                },
            });

        });

        $(document).on('click', '.remove-images', function () {
            let selected_value = $(this).next('img').attr('data-value') + ".webp";
            let index_value = jQuery.inArray(selected_value, store_image_name);
            store_image_name.splice(index_value, 1);
            $('#store-images').val(store_image_name);
            $(this).parents('.upload-image-block').remove();
            showImagesCountOnRemove(store_image_name);

            var children = $('#sortable').sortable('refreshPositions').children();
            store_image_name_order = [];
            $.each(children, function (idx, val) {
                let data_name = $(this).find('img').attr('data-value');
                let data_count = parseInt(idx + 1);
                $(this).find('.badge').text(data_count);
                var object = {};
                object[data_name] = JSON.stringify(data_count);
                store_image_name_order.push(object);
            });
            $('#store-images').val(JSON.stringify(store_image_name_order));

        });

        $('#property-image-btn').on('click', function (e) {

            e.preventDefault();
            var allowed_types = ['image/jpg', 'image/png', 'image/jpeg'];
            let images = $('input#image')[0];
            if (checkImagesCountLimit(images.files['length'])) {
                $(".custom-file-input").siblings(".custom-file-label").addClass("selected").html('Choose files');
                $('#property-image-btn').hide();


                $.each(images.files, function (idx, val) {
                    if (!(allowed_types.indexOf(images.files[idx].type) > -1)) {
                        alert('Please select images of type jpg, png or jpeg.');
                        return 0;
                    } else if (images.files[idx].size > 10 * 1000000) //greater than 10 mb
                    {
                        alert('Please select image of size 10 MB or less');
                        return 0;
                    } else {
                        $('#show_image_spinner').show();
                        var fd = new FormData();
                        fd.append('image', images.files[idx]);
                        jQuery.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: window.location.origin + '/property-image-upload',
                            data: fd,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            success: function (data) {
                                $('input#image').val("");
                                if (data.status === 201) {
                                    alert(data.data);
                                } else if (data.status === 200) {
                                    store_image_name.push(data.data);
                                    let val_1 = JSON.stringify(data.data);
                                    var object = {};
                                    object[val_1] = $('#sortable li').length + parseInt(1);
                                    store_image_name_order.push(object);
                                    $('#store-images').val(JSON.stringify(store_image_name_order));
                                    displayImages(data.data);
                                }
                            },
                            error: function (xhr, status, error) {
                            },
                        });
                        // console.log('calling image count from image upload');
                        showImagesCount(images);
                    }
                });

            }

        });

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
                    let locations = data.data
                    // console.log(data.data);
                    if (!jQuery.isEmptyObject({locations})) {
                        let add_select = $("#add_location");
                        add_select.empty();
                        for (let [index, options] of locations.entries()) {
                            add_select.append($('<option>', {value: options.name, text: options.name}));
                        }
                        $('.fa-spinner').hide();
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

        $('select option:first-child').prop('disabled', true);

        function priceInWords() {

            let val = $('[name=all_inclusive_price]').val();
            if (val !== undefined) {
                let helpEl = $('#all_inclusive_price-help');
                let valStr = '';

                if (!val.trim()) {
                    helpEl.html(valStr);
                    return;
                }

                if (val >= 1000) {
                    if (val >= 100000000000) {
                        helpEl.html('Price is too big. Please contact us.');
                        return;
                    } else if (val >= 1000000000) {
                        valStr += parseInt(val / 1000000000) + ' arab';
                        val %= 1000000000;
                    }
                    if (val >= 10000000) {
                        if (valStr) valStr += ', ';
                        valStr += parseInt(val / 10000000) + ' crore';
                        val %= 10000000;
                    }
                    if (val >= 100000) {
                        if (valStr) valStr += ', ';
                        valStr += parseInt(val / 100000) + ' lac';
                        val %= 100000;
                    }
                    if (val >= 1000) {
                        if (valStr) valStr += ', ';
                        valStr += parseInt(val / 1000) + ' thousand';
                        val %= 1000;
                    }
                }
                if (val > 0) {
                    valStr += (valStr ? ', ' : '') + val;
                }
                helpEl.html('PKR ' + valStr);
                // console.log(valStr);
            }

        }

        (function priceInWords() {

            let val = $('[name=all_inclusive_price]').val();
            if (val !== undefined) {
                let helpEl = $('#all_inclusive_price-help');
                let valStr = '';

                if (!val.trim()) {
                    helpEl.html(valStr);
                    return;
                }

                if (val >= 1000) {
                    if (val >= 100000000000) {
                        helpEl.html('Price is too big. Please contact us.');
                        return;
                    } else if (val >= 1000000000) {
                        valStr += parseInt(val / 1000000000) + ' arab';
                        val %= 1000000000;
                    }
                    if (val >= 10000000) {
                        if (valStr) valStr += ', ';
                        valStr += parseInt(val / 10000000) + ' crore';
                        val %= 10000000;
                    }
                    if (val >= 100000) {
                        if (valStr) valStr += ', ';
                        valStr += parseInt(val / 100000) + ' lac';
                        val %= 100000;
                    }
                    if (val >= 1000) {
                        if (valStr) valStr += ', ';
                        valStr += parseInt(val / 1000) + ' thousand';
                        val %= 1000;
                    }
                }
                if (val > 0) {
                    valStr += (valStr ? ', ' : '') + val;
                }
                helpEl.html('PKR ' + valStr);
                // console.log(valStr);
            }

        })();

        // Initialize Select2 Elements
        $('.select2').select2({
            language: '{{app()->getLocale()}}',
            direction: '{{app()->getLocale() === "en" ? "ltr" : "rtl"}}',
        });
        $('.select2bs4').select2({
            language: '{{app()->getLocale()}}',
            direction: '{{app()->getLocale() === "en" ? "ltr" : "rtl"}}',
            theme: 'bootstrap4',
        });

        $('[name=purpose]').on('click', function (e) {
            const selectedValue = $(this).val();
            if (selectedValue === 'Wanted') {
                $('#purpose-Wanted').slideDown().find('input[type=radio]').attr('required', 'true');
                $('[for=wanted_for]').append(' <span class="text-danger">*</span>');
            } else {
                $('#purpose-Wanted').slideUp().find('input[type=radio]').removeAttr('required');
                $('[for=wanted_for] span').remove('span');
            }
        });

        $('[name=property_type]').on('click', function (e) {
            const selectedValue = $(this).val();
            $('[id^=property_subtype-]').prop('checked', false).slideUp().removeAttr('required');
            $('#property_subtype-' + selectedValue).attr('required', 'true').slideDown();
            $('[for=property_subtype]').html('Property Subtype <span class="text-danger">*</span>');
        });

        //if user edit a property then a property type must be selected then subtype must be visible
        if ($('[name=property_type]').is(':checked')) {
            const selectedValue = $('[name=property_type]:checked').val();
            $('[name=property_subtype-' + selectedValue + ']').each(function (index, value) {
                $(value).attr('required', true);
            });
            $('#property_subtype-' + selectedValue).attr('required', true).slideDown();
            $('[for=property_subtype-' + selectedValue + ']').html('Property Subtype <span class="text-danger">*</span>');
        }
        $('[name^=property_subtype-]').on('click', function (e) {
            $('[name^=property_subtype-]').prop('checked', false).attr('disable', 'true');
            $(this).prop('checked', true);
        });

        $('[name=all_inclusive_price]').on('input', function (e) {
            priceInWords();
        });
        //hide or show bedroom, bathroom and features btn
        //form validation

        $('#delete-image').on('show.bs.modal', function (event) {
            let record_id = $(event.relatedTarget).data('record-id');
            $(this).find('.modal-body #image-record-id').val(record_id);
        });
        $('#delete-plan').on('show.bs.modal', function (event) {
            let record_id = $(event.relatedTarget).data('record-id');
            $(this).find('.modal-body #plan-record-id').val(record_id);
        });
        $('#delete-video').on('show.bs.modal', function (event) {
            let record_id = $(event.relatedTarget).data('record-id');
            $(this).find('.modal-body #video-record-id').val(record_id);
        });

        $('.custom-select').parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});
        let radios = $('[name=property_package]')

        radios.prop("disabled", true);

        let rejection_input = $('[name=rejection_reason]');
        let rejection_div = $('#reason-of-rejection');
        if ($("#status option:selected").text() === 'Rejected') {
            rejection_input.attr('required', 'required').attr('disable', 'false');
            rejection_div.slideDown();
        }

        $('#status').on('change', function (e) {

            if ($("#status option:selected").text() === 'Rejected') {
                rejection_input.attr('required', 'required').attr('disable', 'false');
                rejection_div.slideDown();
            } else {
                rejection_input.removeAttr('required').attr('disable', 'true');
                rejection_input.val('');
                rejection_div.slideUp();
            }
        });
        $('#add_city').on('select2:select', function (e) {
            let city = $('#add_city').val();
            $("#add_location").val(null).trigger("change");
            $('.fa-spinner').show();
            getCityLocations(city);
        });


        $('#add_city').on('select2:select', function (e) {
            let city = $('#add_city').val();
            $("#add_location").val(null).trigger("change");
            $('.location-spinner').show();
            getCityLocations(city);
        });
        // if ($('#add_city').val() !== null) {
        //     let city = $('#add_city').val();
        //     $("#add_location").val(null).trigger("change");
        //     $('.location-spinner').show();
        //     getCityLocations(city);
        // }

        // agency.on('select2:select', function (e) {
        //     $('.agency-user-block').hide();
        //     $('.user-details-block').hide();
        //     $('.contact-person-block').hide();
        //     $('.contact_person_spinner').show();
        //     let agency_val = $(this).val();
        //     if (agency_val !== '' && agency_val !== null) {
        //         getAgencyUsers(agency_val);
        //     }
        // });

        // $('#reset-agency').on('click', function (e) {
        //     e.preventDefault();
        //     let agency_data = $('#agency');
        //     agency_data.val(null).trigger("change");
        //     $('.agency-user-block').hide();
        //     $('.user-details-block').show();
        //     $('.contact-person-block').show();
        //     $('.contact_person_spinner').hide();
        //     $('#contact_person').removeAttr('required').attr('disable', 'true');
        //
        //     $('[name=contact_person]').val('');
        //     $('[name=phone]').val('');
        //     $('[name=mobile]').val('');
        //     $('[name=fax]').val('');
        //     $('[name=contact_email]').val('');
        //     $('.agency-block').hide();
        // });

        // $('#contact_person').on('change', function (e) {
        //     $('input[name=contact_person]').val($(this).find(':selected').data('name'));
        //     let user = $(this).val();
        //     if (user !== '' && user !== '-1') {
        //         $('.select_contact_person_spinner').show();
        //         getUserData(user);
        //     } else {
        //         $('[name=phone]').val('');
        //         $('[name=mobile]').val('');
        //         $('[name=fax]').val('');
        //         $('[name=contact_email]').val('');
        //     }
        // });

        let phone_num = $("#phone");
        let mobile_num = $("#cell");
        //on update form
        if (phone_num.val() !== '' && $("input[name='phone']").val() === '') {
            $("input[name='phone']").val(phone_num.val());
        }
        if (mobile_num.val() !== '' && $("input[name='mobile']").val() === '') {
            $("input[name='mobile']").val(mobile_num.val());
        }
        //on error form
        // if ($("input[name='phone']").val() !== '') {
        //     phone_num.val('+92' + $("input[name='phone']").val());
        // }
        // if ($("input[name='mobile']").val() !== '') {
        //     mobile_num.val('+92' + $("input[name='mobile']").val());
        // }
        phone_num.on('change', function () {
            if (phone_num.val() === '') {
                $('input[name=phone_check]').val('');
            }

            $("input[name='phone']").val(phone_num.val());
        });
        mobile_num.on('change', function () {
            $("input[name='mobile']").val(mobile_num.val());
        });
        iti_contact_number(document.querySelector("#cell"),
            document.querySelector("#error-msg-mobile"),
            document.querySelector("#valid-msg-mobile"),
            $('[name=mobile]'), '#mobile-error', "MOBILE");

        iti_contact_number(document.querySelector("#phone"),
            document.querySelector("#error-msg-phone"),
            document.querySelector("#valid-msg-phone"),
            $('[name=phone]'), '#phone-error', "FIXED_LINE", 'name=phone_check');

        $.validator.addMethod('empty', function (value, element, param) {
            return (value === '');
        });

        let form = $('.data-insertion-form');
        form.validate({
            rules: {
                'mobile_#': {
                    required: true,
                },
                'phone_check': {
                    empty: true,
                },
                contact_email: {
                    required: true,
                    email: true
                },
                'mobile': {
                    required: true,
                },

            },
            messages: {
                'mobile': " please enter a valid value.",
                'phone_check': "",
            },
            errorElement: 'span',
            errorClass: 'error help-block text-red',
            ignore: [],
            submitHandler: function (form) {
                form.submit();
            },
            invalidHandler: function (event, validator) {
                // 'this' refers to the form
                const errors = validator.numberOfInvalids();
                if (errors) {
                    let error_tag = $('div.error.text-red.invalid-feedback.mt-2');
                    error_tag.hide();
                    const message = errors === 1
                        ? 'You missed 1 field. It has been highlighted'
                        : 'You missed ' + errors + ' fields. They have been highlighted';
                    $('div.error.text-red.invalid-feedback strong').html(message);
                    error_tag.show();
                } else {
                    $('#submit-block').show();
                    $('div.error.text-red.invalid-feedback').hide();
                }
            }
        });

        let property_type = '';
        if ($('input[name="purpose-error"]').val() !== '') {
            if ($('input[name="purpose-error"]').val() === 'Wanted') {
                $('#purpose-Wanted').slideDown().find('input[type=radio]').attr('required', 'true');
                $("input[name=wanted_for][value=" + $("input[name='wanted_for-error']").val() + "]").prop('checked', true);
                $('[for=wanted_for]').append(' <span class="text-danger">*</span>');
            }
            $("input[name=purpose][value=" + $('input[name="purpose-error"]').val() + "]").prop('checked', true);
        }
        if ($('input[name="property_type-error"]').val() !== '') {
            property_type = $('input[name="property_type-error"]').val();
            $("input[name=property_type][value=" + property_type + "]").prop('checked', true);
        }
        if ($('input[name="property_subtype-error"]').val() !== '') {
            if ($('input[name="property_subtype-error"]').val() === 'Homes') {
                // $('#property_subtype-' + property_type).attr('required', true).slideDown();
                $("input[name=property_subtype-" + property_type + "][value='" + $('input[name="property_subtype-error"]').val() + "']").prop('checked', true);
            } else {
                $('#property_subtype-Homes').attr('required', false).slideUp();
                $('#property_subtype-' + property_type).attr('required', true).slideDown();
                $("input[name=property_subtype-" + property_type + "][value='" + $('input[name="property_subtype-error"]').val() + "']").prop('checked', true);
            }
        }
        if ($('input[name="location-error"]').val() !== '') {
            if ($('#add_city').val() !== null) {
                let city = $('#add_city').val();
                let selected_location = $('input[name="location-error"]').val();
                // $("#add_location").val(null).trigger("change");
                $('.location-spinner').show();
                if ($('input[name=location]').length === 0)
                    getCityLocations(city, selected_location);
            }

        }


        $(document).on('change', $('.feature-tags .badge').length, function () {
            $('input[name="features-error"]').val($('.feature-tags').html());

        });

        property_type = 'Homes';
        $('input[name="purpose"]').on('change', function () {
            $('input[name="purpose-error"]').val($('input[name="purpose"]:checked').val());
        });
        $(document).on('change', $('input[name="wanted_for"]'), function () {
            $('input[name="wanted_for-error"]').val($('input[name="wanted_for"]:checked').val());
        });
        $('input[name="property_type"]').on('change', function () {
            property_type = $('input[name="property_type"]:checked').val();
            $('input[name="property_type-error"]').val($('input[name=property_type]:checked').val());
        });
        $(document).on('change', $('input[name="property_subtype"]'), function () {
            $('input[name="property_subtype-error"]').val($('input[name="property_subtype-' + property_type + '"]:checked').val());
        });
        $('#add_location').on('change.select2', function (e) {
            $('input[name="location-error"]').val($(this).val());
        });

        if ($('input[name="purpose-error"]').val() === '') {
            $('input[name="purpose-error"]').val($('input[name=purpose]:checked').val());
        }
        if ($('input[name="property_type-error"]').val() === '') {
            $('input[name="property_type-error"]').val($('input[name=property_type]:checked').val());
        }
        if ($('input[name="property_subtype-error"]').val() === '') {
            $('input[name="property_subtype-error"]').val($('input[name="property_subtype-' + property_type + '"]:checked').val());
        }
        $(".custom-file-input").on("change", function () {

            let images = $('input#image')[0];
            if (images.files.length > 0) {
                $('.image-upload-btn').show();
            }
            let html = '<span>' + images.files.length + ' files selected</span>'
            $(this).siblings(".custom-file-label").addClass("selected").html(html);
        });
        if ($('input[name=purpose]').val() === 'Wanted')
            $('.property-media-block').hide();
        else
            $('.property-media-block').show();

        let agency = $('#agency');
        $(document).on('change', '[name=advertisement]', function () {
            if ($('input[name="advertisement"]:checked').val() === 'Agency') {
                $('.agency_category').slideDown();
                $('[name=property_agency]').attr('required', true);

                $('[name=agency]').val($('[name=property_agency]').attr('data-id'));

            } else {
                $('.agency_category').slideUp();
                $('[name=property_agency]').removeAttr('required').attr('disable', 'true');
                $('[name=agency]').val('');
            }
        });
        if ($('input[name="advertisement"]:checked').val() == 'Individual') {
            $('.agency_category').slideUp();
            $('[name=property_agency]').removeAttr('required').attr('disable', 'true');


            $('[name=agency]').val('');
        }
        getAgencies($('[name=property_id]').val(), $('[name=agency]').val());
    });
    var checker_flag = false;
    var check_id = 0;

    $(document).on('click', '.select-agency', function (e) {

        e.preventDefault();
        var $row = jQuery(this).closest('tr');
        var $columns = $row.find('td');

        let agency_id = $columns[0].innerHTML;
        let agency_title = $columns[1].innerHTML;
        let agency_city = $columns[2].innerHTML;
        let agency_address = $columns[3].innerHTML;
        let agency_cell = $columns[4].innerHTML;
        let agency_phone = $columns[5].innerHTML;

        $('[name=property_agency]').val(agency_id + ' - ' + agency_title);
        $('[name=agency]').val(agency_id);

        let html = '' +
            '<div class="row">' +
            '<div class="col-sm-4 col-md-3 col-lg-2  col-xl-2">' +
            '   <div class="my-2"> Agency Information</div>' +
            '</div>' +
            '<div class="col-sm-8 col-md-9 col-lg-10 col-xl-10">' +
            '<div class="col-md-6 my-2">' +
            ' <strong>Title: </strong>' + agency_title +
            '</div>' +
            '<div class="col-md-6 my-2">' +
            '<strong>Address: </strong>' + agency_address +
            '</div>' +
            '<div class="col-md-6 my-2">' +
            '<strong>City: </strong>' + agency_city +
            '</div>' +
            '   <div class="col-md-6 my-2">' +
            '      <strong>Phone: </strong>' + agency_phone +
            '</div>' +
            '   <div class="col-md-6 my-2">' +
            '      <strong>Cell: </strong>' + agency_cell +
            '</div>' +
            '</div>';


        $('.agency-block').show().html(html);

        // let checker = $('.fa-check-circle');
        //prevent more than 1 on same page of datatable
        // if (checker.length > 0) {
        //     check_id = checker.attr('id');
        //     checker.closest('td').html('<button class="btn btn-sm btn-primary select-agency">Select Agency</button>');
        // }
        // var column = $('#agencies-table').DataTable().column($row.attr('data-column'));
        // var table = $('#agencies-table').DataTable();

        // table
        //     .column(6)
        //     .data()
        //     .each(function (value, index) {
        //         if (value.indexOf(".fa-check-circle") > 0)
        //             value = '<td><button class="btn btn-sm btn-primary select-agency">Select Agency</button></td>';
        //         console.log(value);
        // console.log('Data in index: ' + index + ' is: ' + value);
        // });

        // if(check_id  != 0){
        //     $('#agencies-table').DataTable().search(check_id ).draw();
        // }
        // $('#myInputTextField').keyup(function(){

        // })

        // console.log(column);


        // jQuery(this).closest('td').html("<i class='fa-3x fas fa-check-circle' id=check-" + agency_id + " style = 'color: green'></i>");
        $('.fa-check-circle').hide();
        $('.fa-check-circle').prev('button').show();
        $(this).next('.fa-check-circle').show();
        $(this).hide();
        $('#agenciesModalCenter').modal('hide');
    });

    function getAgencies(property, id) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: 'get',
            url: window.location.origin + '/get-admin-agencies',
            data: {property: property, id: id},
            dataType: 'json',
            success: function (data) {
                let agency_data = data.agency;
                let default_agency = data.default_agency;
                if (!jQuery.isEmptyObject({agency_data})) {

                    var data_table = [];
                    $.each(agency_data, function (key, value) {
                        if (value.cell !== null)
                            value.cell = value.cell.replace(/-/g, '');
                        if (value.phone !== null)
                            value.phone = value.phone.replace(/-/g, '');
                        if (value.id == data.default_agency)
                            data_table.push([value.id, value.id+" - "+value.title, value.city, value.address, value.cell, value.phone,
                                "<td><button class='btn btn-sm btn-primary select-agency' style='display:none'>Select Agency</button><i class='fa-3x fas fa-check-circle'  style = 'color: green;display:block'></i></td >"]);
                        else
                            data_table.push([value.id, value.id+" - "+value.title, value.city, value.address, value.cell, value.phone, '<td> <button class="btn btn-sm btn-primary select-agency" style="display:block">Select Agency</button><i class="fa-3x fas fa-check-circle"  style = "color: green;display:none"></i></td>']);
                    });
                    $('#agencies-table').DataTable({
                        // dom: 'tp',
                        data: data_table,
                        deferRender: true,
                        "scrollX": true,
                        "ordering": false,
                        responsive: true,
                        // "drawCallback": function (settings) {
                        // var api = this.api();

                        // Output the data for the visible rows to the browser's console
                        // $.each(api.rows({page: 'current'}).data(), function (idx, val) {
                        //     console.log(val[6]);
                        //
                        // });
                        // console.log(api.rows({page: 'current'}).data());
                        // },
                        // "initComplete": function () {
                        //     var api = this.api();
                        //     api.$('td').click( function () {
                        //         console.log(this.innerHTML);
                        //         api.search( this.innerHTML ).draw();
                        //     } );
                        // }
                    });
                }

            },
            error: function (xhr, status, error) {

            },
            complete: function (url, options) {
                $('#agency-loading').hide();
                $('#agency-loaded').show();
            }
        });
    }


//    stop page to scroll on page model oopen
    var $body = $(document.body);
    $(document).on('show.bs.modal', '#agenciesModalCenter', function (e) {

        var oldWidth = $body.innerWidth();
        $body.css("overflow", "hidden");
        $body.width(oldWidth);
    });
    $(document).on('hidden.bs.modal', '#agenciesModalCenter', function (e) {
        $body.css("overflow", "auto");
        $body.width("auto");
    });
})
(jQuery);
