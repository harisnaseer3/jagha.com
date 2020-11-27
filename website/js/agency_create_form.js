(function ($) {

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
        $('#delete-image').on('show.bs.modal', function (event) {
            let record_id = $(event.relatedTarget).data('record-id');
            $(this).find('.modal-body #image-record-id').val(record_id);
        });
        $("input[name='phone']").keyup(function () {
            $(this).val($(this).val().replace(/^(\d{1})(\d+)$/, "+92-$2"));
        });
        $("input[name='cell']").keyup(function () {
            $(this).val($(this).val().replace(/^(\d{1})(\d+)$/, "+92-$2"));
        });
        $("input[name='fax']").keyup(function () {
            $(this).val($(this).val().replace(/^(\d{1})(\d+)$/, "+92-$2"));
        });
        $('.custom-select').parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});
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
        // $('#add_city').on('select2:select', function (e) {
        //     let city = $('#add_city').val();
        //     $('.fa-spinner').show();
        //     getCityLocations(city);
        // });
        var ag_iti_phone = window.intlTelInput(document.querySelector('#phone'), {
            // any initialisation options go here
            allowDropdown: false,
            numberType: "FIXED_LINE",
            placeholderNumberType: "FIXED_LINE",
            separateDialCode: true,
            onlyCountries: ['pk'],
            // preventInvalidNumbers: true,
            utilsScript: "../../../plugins/intl-tel-input/js/utils.js"
        });

        var ag_iti_cell = window.intlTelInput(document.querySelector('#cell'), {
            // any initialisation options go here
            allowDropdown: false,
            onlyCountries: ['pk'],
            // preventInvalidNumbers: true,
            separateDialCode: true,
            numberType: "MOBILE",
            utilsScript: "../../../plugins/intl-tel-input/js/utils.js"
        });

        let phone_num = $("#phone");
        let mobile_num = $("#cell");
        if (phone_num.val() !== '') {
            $("input[name='phone']").val("+92-" + phone_num.val());
        }
        if (mobile_num.val() !== '') {
            $("input[name='mobile']").val("+92-" + mobile_num.val());
        }
        mobile_num.change(function () {
            let data = ag_iti_cell.getNumber().split('+92');
            let value = "+92-" + data[1];
            $("input[name='mobile']").val(value);
        });
        phone_num.change(function () {
            let data = ag_iti_phone.getNumber().split('+92');
            let value = "+92-" + data[1];
            $("input[name='phone']").val(value);
        });
        $.validator.addMethod("checkcellnum", function (value) {
            return /^3\d{2}[\s.-]?\d{7}$/.test(value) || /^03\d{2}[\s.-]?\d{7}$/.test(value);
        });
        $.validator.addMethod("checkphonenum", function (value) {
            return /^0\d{2}[\s.-]?\d{7}$/.test(value) || /^\d{2}[\s.-]?\d{7}$/.test(value) || /^0\d{2}[\s.-]?\d{8}$/.test(value) || /^\d{2}[\s.-]?\d{8}$/.test(value);
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
