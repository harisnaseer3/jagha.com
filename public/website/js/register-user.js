(function ($) {
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
    // $.validator.addMethod("checkcellnum", function (value) {
    //     return /^3\d{2}[\s.-]?\d{7}$/.test(value) || /^03\d{2}[\s.-]?\d{7}$/.test(value);
    // });


    $(document).ready(function () {

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

        let form = $('#registrationForm');
        form.validate({
            rules: {
                name: {
                    required: true,
                },
                'mobile_#': {
                    required: true,
                },
                'mobile': {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 20,
                    checklower: true,
                    checkupper: true,
                    checkdigit: true,
                    checkspecialchr: true,
                },
                password_confirmation: {
                    equalTo: "#password"
                }
            },
            messages: {
                password: {
                    pwcheck: "Password is not strong enough",
                    checklower: "Need atleast 1 lowercase alphabet",
                    checkupper: "Need atleast 1 uppercase alphabet",
                    checkdigit: "Need atleast 1 digit",
                    checkspecialchr: "Need atleast 1 special character"
                },
                'mobile': ", please enter a valid value."
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
                    let error_tag = $('div.error.text-red.invalid-feedback');
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
})(jQuery);
