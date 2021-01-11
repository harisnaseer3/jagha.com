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
    $('#sendMessageButton').on('click', function (e) {
        const id = $('#id').val();
        const name = $('#name').val();
        const url = $('#url').val();
        const email = $('#your-email').val();
        const message = $('#message').val();
        if (id.trim === '' || name.trim === '' || email.trim() === '' || message.trim() === '') {
            e.preventDefault();
            id.trim() === '' ? $('#idHelp').slideDown() : $('#idHelp').slideUp();
            name.trim() === '' ? $('#nameHelp').slideDown() : $('#nameHelp').slideUp();
            email.trim() === '' ? $('#emailHelp').slideDown() : $('#emailHelp').slideUp();
            message.trim() === '' ? $('#messageHelp').slideDown() : $('#messageHelp').slideUp();
            return;
        }
        if (IsEmail(email) === false) {
            e.preventDefault();
            $('#emailHelp').html('Incorrect email format').slideDown();

        } else {
            e.preventDefault();
            insertMessage();
        }
    });
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

    function insertMessage() {
        let html = '';
        $('#message-alert').html(html).slideDown();
        $('#sendMessageButton').prop('disabled', true);
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: 'post',
            url: $('#supportform').attr('action'),
            data: $('#supportform').serialize(),
            success: function () {
                $("#supportform").trigger("reset");
                html = ' <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Your message has been sent. </strong></div>'
                $('#message-alert').html(html).slideDown();
            },
            error: function (xhr, status, error) {
                html = ' <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Error sending message,try again. </strong></div>'
                $('#message-alert').html(html).slideDown();
            }, complete: function (url, options) {
                $('#sendMessageButton').prop('disabled', false);
            }
        });

    }
})(jQuery);
