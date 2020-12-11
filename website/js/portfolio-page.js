(function ($) {
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

    function getAgencyUsers(agency) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: 'get',
            url: window.location.origin + '/agency-users',
            data: {agency: agency},
            dataType: 'json',
            success: function (data) {
                // console.log(data);
                let user_data = data.data
                // console.log(user_data);
                if (!jQuery.isEmptyObject({user_data})) {
                    $('.agency-user-block').show();

                    let add_select = $("#contact_person");
                    add_select.empty();

                    add_select.append($('<option>', {value: -1, text: "Select contact person", style: "color: #999"}));

                    $.each(user_data, function (key, value) {
                        add_select.append($('<option>', {value: key, text: value, 'data-name': value}));
                    });

                    $('#contact_person_input').removeAttr('required').attr('disable', 'true');
                    $('.contact_person_spinner').hide();
                    $('.contact-person-block').hide();
                    $('#contact_person').attr('required', 'required').attr('disable', 'false');
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

    function getUserData(user) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: 'get',
            url: window.location.origin + '/user-info',
            data: {user: user},
            dataType: 'json',
            success: function (data) {
                let result = data.data
                if (!jQuery.isEmptyObject({result})) {
                    $('.select_contact_person_spinner').hide();
                    $('.user-details-block').show();
                    if (result.phone !== null) $('[name=phone]').val(result.phone);
                    if (result.cell !== null) $('[name=mobile]').val(result.cell);
                    if (result.fax !== null) $('[name=fax]').val(result.fax);
                    if (result.email !== null) $('[name=contact_email]').val(result.email);
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

    function displayImages(name) {
        let image = name.split('.')[0];
        let src = window.location.origin + '/thumbnails/properties/' + image + '-450x350.webp';
        let html = '<div class="col-md-4 col-sm-6 my-2 upload-image-block">' +
            '<div style="position: relative; width: 70%; height: 50% ;margin:0 auto;">' +
            '<a class="btn remove-images" data-toggle-1="tooltip" data-placement="bottom" title="delete"' +
            '' +
            ' style="position: absolute; top: 0; right: 0; z-index: 1">' +
            '<i class="fad fa-times-circle fa-2x" style="color: red"></i></a>' +
            '<img src="' + src + '" width="100%" class="img-responsive" alt="image not available" data-value="' + image + '"/>' +
            '</div>' +
            '</div>';
        $('#show_image_spinner').hide();
        $('.add-images').append(html).show();

    }

    function displayImagesOnError() {
        $.each($('[name=image]').val().split(','), function (idx, val) {
            let image = val.split('.')[0];
            let src = window.location.origin + '/thumbnails/properties/' + image + '-450x350.webp';
            let html = '<div class="col-md-4 col-sm-6 my-2 upload-image-block">' +
                '<div style="position: relative; width: 70%; height: 50% ;margin:0 auto;">' +
                '<a class="btn remove-images" data-toggle-1="tooltip" data-placement="bottom" title="delete"' +
                '' +
                ' style="position: absolute; top: 0; right: 0; z-index: 1">' +
                '<i class="fad fa-times-circle fa-2x" style="color: red"></i></a>' +
                '<img src="' + src + '" width="100%" class="img-responsive" alt="image not available" data-value="' + image + '"/>' +
                '</div>' +
                '</div>';
            $('.add-images').append(html).show();
        });
    }

    function iti_contact_number(input, errorMsg, validMsg, field, error_div, phone_type) {
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
                } else {
                    var errorCode = ag_iti_cell.getValidationError();
                    errorMsg.innerHTML = errorMap[errorCode];
                    errorMsg.classList.remove("hide");
                    field.val('');
                }
            }
        });

        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);
    }


    $(document).ready(function () {
        $('select option:first-child').prop('disabled', true);

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
        // added custom search in location select2
        $("#add_location").select2({
            matcher: function (params, data) {
                if ($.trim(params.term) === '') {
                    return data;
                }
                keywords=(params.term).split(" ");
                for (var i = 0; i < keywords.length; i++) {

                    if (((data.text).toUpperCase()).indexOf((keywords[i]).toUpperCase()) == -1)
                        return null;

                }
                return data;
            }

        });
        $("#add_location").parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});



        let agency = $('#agency');

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

        agency.on('select2:select', function (e) {
            $('.agency-user-block').hide();
            $('.user-details-block').hide();
            $('.contact-person-block').hide();
            $('.contact_person_spinner').show();
            let agency_val = $(this).val();
            if (agency_val !== '' && agency_val !== null) {
                getAgencyUsers(agency_val);
            }
        });

        $('#reset-agency').on('click', function (e) {
            e.preventDefault();
            let agency_data = $('#agency');
            agency_data.val(null).trigger("change");
            $('.agency-user-block').hide();
            $('.user-details-block').show();
            $('.contact-person-block').show();
            $('.contact_person_spinner').hide();
            $('#contact_person').removeAttr('required').attr('disable', 'true');

            $('[name=contact_person]').val('');
            $('[name=phone]').val('');
            $('[name=mobile]').val('');
            $('[name=fax]').val('');
            $('[name=contact_email]').val('');
        });

        $('#contact_person').on('change', function (e) {
            $('input[name=contact_person]').val($(this).find(':selected').data('name'));
            let user = $(this).val();
            if (user !== '' && user !== '-1') {
                $('.select_contact_person_spinner').show();
                getUserData(user);
            } else {
                $('[name=phone]').val('');
                $('[name=mobile]').val('');
                $('[name=fax]').val('');
                $('[name=contact_email]').val('');
            }
        });
        let store_image_name = [];
        // $('#store-images').val(store_image_name);
        $('#property-image-btn').on('click', function (e) {
            e.preventDefault();
            var allowed_types = ['image/jpg', 'image/png', 'image/jpeg'];
            let images = $('input#image')[0];
            // console.log(images.files);

            if (images.files['length'] > 60) {
                alert('You can select 60 images only');
                return 0;
            }
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
                            // console.log(data.data);

                            if (data.status === 201) {
                                alert(data.data);
                            } else if (data.status === 200) {
                                // alert(data.data);
                                store_image_name.push(data.data);
                                // console.log(data.data)
                                $('#store-images').val(store_image_name);
                                displayImages(data.data);
                            }
                        },
                        error: function (xhr, status, error) {
                            // console.log(error);
                            // console.log(status);
                            // console.log(xhr);
                        },
                    });
                }
            });


        });
        $(document).on('click', '.remove-images', function () {
            let selected_value = $(this).next('img').attr('data-value') + ".webp";

            let index_value = jQuery.inArray(selected_value, store_image_name);
            store_image_name.splice(index_value, 1);
            $('#store-images').val(store_image_name);
            $(this).parents('.upload-image-block').hide();

        });
        //in case of an error
        if ($('[name=image]').val() !== undefined && $('[name=image]').val() !== '') {
            displayImagesOnError();
        }


        let phone_num = $("#phone");
        let mobile_num = $("#cell");
        if (phone_num.val() !== '') {
            $("input[name='phone']").val(phone_num.val());
        }
        if (mobile_num.val() !== '') {
            $("input[name='mobile']").val(mobile_num.val());
        }

        iti_contact_number(document.querySelector("#cell"),
            document.querySelector("#error-msg-mobile"),
            document.querySelector("#valid-msg-mobile"),
            $('[name=mobile]'), '#mobile-error', "MOBILE");

        iti_contact_number(document.querySelector("#phone"),
            document.querySelector("#error-msg-phone"),
            document.querySelector("#valid-msg-phone"),
            $('[name=phone]'), '#phone-error', "FIXED_LINE");

        let form = $('.data-insertion-form');
        form.validate({
            rules: {
                'mobile_#': {
                    required: true,
                    // checkcellnum: true,
                },
                'phone_#': {
                    required: true,
                    // checkphonenum: true,
                },
                contact_email: {
                    required: true,
                    email: true
                },
                'mobile': {
                    required: true,
                },
                'phone': {
                    required: true,
                },
            },
            messages: {
                'mobile': " please enter a valid value.",
                'phone': "please enter a valid value.",
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
    });
})
(jQuery);
