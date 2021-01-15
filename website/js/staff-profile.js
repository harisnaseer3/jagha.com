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

    $.validator.addMethod("checklower", function (value) {
        return /[a-z]/.test(value);
    });
    $.validator.addMethod("checkupper", function (value) {
        return /[A-Z]/.test(value);
    });
    $.validator.addMethod("checkdigit", function (value) {
        return /[0-9]/.test(value);
    });
    $.validator.addMethod("checkspecialchr", function (value) {
        return /[#?!@$%^&*-]/.test(value);
    });

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
        if (selected_country !== 'Pakistan') {
            $('#city-name-div').show();
            $('#city-dropdown-div').hide();
            $('#city-name').val('');
            $("#add_city").val('').trigger('change');
        } else {
            $('#city-name-div').hide();
            $('#city-dropdown-div').show();
            $('#city-name').val('');
            $("#add_city").val('').trigger('change');
        }


    });
    $("input[name=add]").on('change', function () {
        const selected_value = $(this).val();
        if (selected_value === 'Existing User') {
            $('#new-user-details').hide();

        } else {
            $('#new-user-details').show();

        }

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
        $('[name=phone]'), '#phone-error', "FIXED_LINE", 'name=phone_check');

    let form = $('.data-insertion-form');
    $.validator.addMethod('empty', function (value, element, param) {
        return (value === '');
    });
    form.validate({
        rules: {
            'agency_id': {
                required: true
            },
            name: {
                required: function (element) {
                    return $('input[name=add]:checked').val() === 'New User';
                },
            },
            'account_password': {
                required: function (element) {
                    return $('input[name=add]:checked').val() === 'New User';
                },
                minlength: {
                    param: 8,
                    depends: function (element) {
                        return $('input[name=add]:checked').val() === 'New User';
                    }
                },
                maxlength: {
                    param: 20,
                    depends: function (element) {
                        return $('input[name=add]:checked').val() === 'New User';
                    }
                },
                checklower: {
                    param: true,
                    depends: function (element) {
                        return $('input[name=add]:checked').val() === 'New User';
                    }
                },
                checkupper: {
                    param: true,
                    depends: function (element) {
                        return $('input[name=add]:checked').val() === 'New User';
                    }
                },
                checkdigit: {
                    param: true,
                    depends: function (element) {
                        return $('input[name=add]:checked').val() === 'New User';
                    }
                },
                checkspecialchr: {
                    param: true,
                    depends: function (element) {
                        return $('input[name=add]:checked').val() === 'New User';
                    }
                },
            },
            'confirm_password': {
                required: function (element) {
                    return $('input[name=add]:checked').val() === 'New User';
                },
                equalTo: {
                    param: "#account_password",
                    depends: function (element) {
                        return $('input[name=add]:checked').val() === 'New User';
                    }
                },
            },
            'mobile_#': {
                required: function (element) {
                    return $('input[name=add]:checked').val() === 'New User';
                }
            },
            'mobile': {
                required: function (element) {
                    return $('input[name=add]:checked').val() === 'New User';
                }
            },
            'phone_check': {
                empty: function (element) {
                    return $('input[name=add]:checked').val() === 'New User';
                }
            },
        },
        messages: {
            'account_password': {
                pwcheck: "Password is not strong enough",
                checklower: "Need atleast 1 lowercase alphabet",
                checkupper: "Need atleast 1 uppercase alphabet",
                checkdigit: "Need atleast 1 digit",
                checkspecialchr: "Need atleast 1 special character"
            },
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
    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

})(jQuery);
