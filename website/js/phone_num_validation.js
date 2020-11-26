(function ($) {
    $(document).ready(function () {
        var iti_phone = window.intlTelInput(document.querySelector('#phone'), {
            // any initialisation options go here
            allowDropdown: false,
            numberType: "FIXED_LINE",
            placeholderNumberType: "FIXED_LINE",
            separateDialCode: true,
            onlyCountries: ['pk'],
            // preventInvalidNumbers: true,
            utilsScript: "../../plugins/intl-tel-input/js/utils.js"
        });

        var iti_cell = window.intlTelInput(document.querySelector('#cell'), {
            // any initialisation options go here
            allowDropdown: false,
            onlyCountries: ['pk'],
            // preventInvalidNumbers: true,
            separateDialCode: true,
            numberType: "MOBILE",
            utilsScript: "../../plugins/intl-tel-input/js/utils.js"
        });

        let phone_num = $("#phone");
        let mobile_num = $("#cell");
        if (phone_num.val !== '') {
            let data = $(this).val();
            let value = "+92-" + data;
            $("input[name='phone']").val(value);
        }
        if (mobile_num !== '') {
            let data = $(this).val();
            let value = "+92-" + data;
            $("input[name='mobile']").val(value);
        }
        mobile_num.change(function () {
            let data = iti_cell.getNumber().split('+92');
            let value = "+92-" + data[1];
            $("input[name='mobile']").val(value);
        });
        phone_num.change(function () {
            let data = iti_phone.getNumber().split('+92');
            let value = "+92-" + data[1];
            $("input[name='phone']").val(value);
        });
        $.validator.addMethod("checkcellnum", function (value) {
            return /^3\d{2}\d{7}$/.test(value) || /^03\d{2}\d{7}$/.test(value);
        });
        $.validator.addMethod("checkphonenum", function (value) {
            return /^\d{10}$/.test(value) || /^\d{9}$/.test(value) || /^\d{11}$/.test(value);
        });
        let form = $('.data-insertion-form');
        form.validate({
            rules: {
                'mobile_#': {
                    required: true,
                    checkcellnum: true,
                },
                'phone_#': {
                    checkphonenum: true,
                },
                contact_email: {
                    required: true,
                    email: true
                },
            },
            messages: {
                'mobile_#': {
                    checkcellnum: "Please enter a valid value. (300 1234567)"
                },
                'phone_#': {
                    checkphonenum: "Please enter a valid value. (21 23456789)",
                }
            },
            errorElement: 'small',
            errorClass: 'help-block text-red',
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
})(jQuery);
