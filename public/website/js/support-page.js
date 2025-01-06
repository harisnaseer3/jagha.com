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
        message === '' ? $('#messageHelp').slideDown() : $('#messageHelp').slideUp();
    });
    $('#name').on('keyup', function () {
        const name = $('#name').val();
        name === '' ? $('#nameHelp').slideDown() : $('#nameHelp').slideUp();
    });
    $('#your-email').on('keyup', function () {
        const email = $('#your-email').val();
        email.trim() === '' ? $('#emailHelp').slideDown() : $('#emailHelp').slideUp();
        IsEmail(email);
    });
    $('#id').on('keyup', function () {
        const name = $('#id').val();
        name=== '' ? $('#idHelp').slideDown() : $('#idHelp').slideUp();
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
            $('#property-div').slideDown();
            $('#agency-div').slideUp();
            $('#other-div').slideUp();
        } else if (selectedValue === 'Agency') {
            $('#property-div').slideUp();
            $('#agency-div').slideDown();
            $('#other-div').slideUp();
        } else if (selectedValue === 'Other') {
            $('#property-div').slideUp();
            $('#agency-div').slideUp();
            $('#other-div').slideDown();
        }
    });
    let on_error = $('[name=inquire_type]:checked').val();
    if (on_error === 'Property') {
        $('#property-div').slideDown();
        $('#agency-div').slideUp();
        $('#other-div').slideUp();
    } else if (on_error === 'Agency') {
        $('#property-div').slideUp();
        $('#agency-div').slideDown();
        $('#other-div').slideUp();
    } else if (on_error === 'Other') {
        $('#property-div').slideUp();
        $('#agency-div').slideUp();
        $('#other-div').slideDown();
    }


    let form = $('#supportform');

    $('#supportform').validate({
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
            'topic': {
                required: function (element) {
                    return $('[name=inquire_type]:checked').val() == 'Other';
                }
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



})(jQuery);
