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
                console.log(error);
                console.log(status);
                console.log(xhr);
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

        $("input[name='phone']").keyup(function () {
            $(this).val($(this).val().replace(/^(\d{1})(\d+)$/, "+92-$2"));
        });
        $("input[name='mobile']").keyup(function () {
            $(this).val($(this).val().replace(/^(\d{1})(\d+)$/, "+92-$2"));
        });
        $("input[name='fax']").keyup(function () {
            $(this).val($(this).val().replace(/^(\d{1})(\d+)$/, "+92-$2"));
        });
        $('.custom-select').parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});

        // $('[name=call_for_price_inquiry]').click(function () {
        //     if ($('[name=call_for_price_inquiry]').is(':checked')) {
        //         $('[name=all_inclusive_price]').removeAttr('required').attr('disable', 'true');
        //         $('[name=all_inclusive_price]').val('');
        //         $('.price-block').slideUp();
        //     } else {
        //         $('[name=all_inclusive_price]').attr('required', 'required').attr('disable', 'false');
        //         $('.price-block').slideDown();
        //     }
        // });
        let agency = $('#agency');
        // if (agency.length > 0) {
        //     if (agency.val() === null) {
        //         $('select.agency-class').select2({
        //             placeholder: 'Select Agency',
        //             allowClear: true
        //         });
        //     }
        //
        //     $('.select2.select2-container.select2-container--default')
        //         .css({'border': '1px solid rgb(206, 212, 218)', 'border-radius': '0.25rem'});
        // }

        $('#add_city').on('select2:select', function (e) {
            let city = $('#add_city').val();
            $("#add_location").val(null).trigger("change");
            $('.location-spinner').show();
            getCityLocations(city);
        });


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

        $('#reset-agency').on('click',function(e){
            e.preventDefault();
            $('.agency-user-block').hide();
            $('.user-details-block').show();
            $('.contact-person-block').show();
            $('.contact_person_spinner').hide();
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
    });
})(jQuery);
