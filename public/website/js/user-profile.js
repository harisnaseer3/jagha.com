(function ($) {
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
        $('[name=country]').parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});
        $('#add_city').parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});
        $('.custom-select-agency').parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});

    });
    $('#add-country').on('change', function () {
        const selected_country = $('#add-country').val();
        if(selected_country !== 'Pakistan'){
            $('#city-name-div').show();
            $('#city-dropdown-div').hide();
            $('#city-name').val('');
            $("#add_city").val('').trigger('change');
        }
        else{
            $('#city-name-div').hide();
            $('#city-dropdown-div').show();
            $('#city-name').val('');
            $("#add_city").val('').trigger('change');
        }


    });
    $("input[name=add]").on('change', function () {
        const selected_value = $(this).val();
        if(selected_value === 'Existing User'){
            $('#new-user-details').hide();
        }
        else{
            $('#new-user-details').show();
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
            url: window.location.origin + '/dashboard/agencies/accept-invitation',
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
            url: window.location.origin + '/dashboard/agencies/reject-invitation',
            data: {'notification_id': notification_id},
            dataType: 'json',
            success: function (data) {
                // console.log(data);
                if (data.status === 200) {
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

    let phone_num = $("#phone");
    let mobile_num = $("#cell");
    if (phone_num.val() !== '') {
        $("input[name='phone']").val(phone_num.val());
    }
    if (mobile_num.val() !== '') {
        $("input[name='mobile']").val(mobile_num.val());
    }
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
        $('[name=phone]'), '#phone-error', "FIXED_LINE",'name=phone_check');

    let form = $('.data-insertion-form');
    $.validator.addMethod('empty', function (value, element, param) {
        return (value === '');
    });
    form.validate({
        rules: {
            'mobile_#': {
                required: true,
            },
            'mobile': {
                required: true,
            },
            'phone_check': {
                empty: true,
            },
            contact_email: {
                required: true,
                email: true
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
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

})(jQuery);
