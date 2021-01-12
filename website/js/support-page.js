(function ($) {

    $('.select2').select2({
        language: '{{app()->getLocale()}}',
        direction: '{{app()->getLocale() === "en" ? "ltr" : "rtl"}}',
    });
    $('.select2bs4').select2({
        language: '{{app()->getLocale()}}',
        direction: '{{app()->getLocale() === "en" ? "ltr" : "rtl"}}',
        theme: 'bootstrap4',
    });
    $('.custom-select').parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});
    let input = document.querySelector("#cell");
    var errorMsg = document.querySelector("#error-msg"),
        validMsg = document.querySelector("#valid-msg");
    var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

    var ag_iti_cell = window.intlTelInput(document.querySelector('#cell'), {
        preferredCountries: ["pk"],
        preventInvalidNumbers: true,
        separateDialCode: true,
        numberType: "MOBILE",
        // hiddenInput: "mobile",
        utilsScript: "/../../plugins/intl-tel-input/js/utils.js?1603274336113"
    });
    var reset = function () {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
    };
    input.addEventListener('blur', function () {
        reset();
        if (input.value.trim()) {
            if (ag_iti_cell.isValidNumber()) {
                $('[name=mobile]').val(ag_iti_cell.getNumber());
                validMsg.classList.remove("hide");
                $('#mobile-error').hide();
            } else {
                input.classList.add("error");
                var errorCode = ag_iti_cell.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("hide");
                $('[name=mobile]').val('');
            }
        }
    });

    input.addEventListener('change', reset);
    input.addEventListener('keyup', reset);

    $('#message').on('keyup', function () {
        const message = $('#message').val();
        message.trim() === '' ? $('#messageHelp').slideDown() : $('#messageHelp').slideUp();
    });
    $('#name').on('keyup', function () {
        const name = $('#name').val();
        name.trim() === '' ? $('#nameHelp').slideDown() : $('#nameHelp').slideUp();
    });
    $('#your-email').on('keyup', function () {
        const email = $('#your-email').val();
        email.trim() === '' ? $('#emailHelp').slideDown() : $('#emailHelp').slideUp();
        IsEmail(email);
    });
    $('#id').on('keyup', function () {
        const name = $('#id').val();
        name.trim() === '' ? $('#idHelp').slideDown() : $('#idHelp').slideUp();
    });

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            return false;
        } else {
            return true;
        }
    }

    $('[name=inquire_type]').on('change', function (e) {

        const selectedValue = $(this).val();
        if (selectedValue === 'Property') {
            $('#property-div').slideDown().find('#property-id').attr('required', 'true');
            $('#agency-div').slideUp().find('#agency-id').removeAttr('required');
        } else {
            $('#property-div').slideUp().find('#property-id').removeAttr('required');
            $('#agency-div').slideDown().find('#agency-id').attr('required', 'true');
        }
    });

    let form = $('#supportform');

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
                minlength: 25,
                maxlength: 1024
            },
            'property-id': {
                required: $('[name=inquire_type]').val() === 'Property'
            },
            'agency-id': {
                required: $('[name=inquire_type]').val() === 'Agency'
            },
            'url': {
                url: true
            }
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

    // $('#sendMessageButton').on('click', function (e) {
    //     const url = $('#url').val();
    //     const email = $('#your-email').val();
    //     const message = $('#message').val();
    //     const type = $('[name=inquire_type]').val();
    //     const property_id = $('#property-id').val();
    //     const agency_id = $('#agency-id').val();
    //     if (email.trim() === '' || message.trim() === '') {
    //         e.preventDefault();
    //         email.trim() === '' ? $('#emailHelp').slideDown() : $('#emailHelp').slideUp();
    //         message.trim() === '' ? $('#messageHelp').slideDown() : $('#messageHelp').slideUp();
    //         return;
    //     }
    //
    //     if (IsEmail(email) === false) {
    //         e.preventDefault();
    //         $('#emailHelp').html('Incorrect email format').slideDown();
    //
    //     }
    //     if (type === 'Property' && property_id === null) {
    //         e.preventDefault();
    //         $('#propertyHelp').slideDown();
    //         $('#agencyHelp').slideUp();
    //     } else if (type === 'Agency' && agency_id === null) {
    //         e.preventDefault();
    //         $('#propertyHelp').slideUp();
    //         $('#agencyHelp').slideDown();
    //     }
    //     if (message.length < 25) {
    //         e.preventDefault();
    //         $('#messageHelp').html('Minimum of 25 characters required').slideDown();
    //     }
    //
    // });

})(jQuery);
