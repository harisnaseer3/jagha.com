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
        $('[name=package]').parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});
        $('[name=agency]').parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});

        $("input[name='package_for']").on('change', function () {
            let selected_value = $(this).val();
            if (selected_value !== 'Agency') {
                $('#agency_block').slideUp();
                $('#agency').removeAttr('required').attr('disable', 'true');
            } else {
                $('#agency_block').slideDown();
                $('#agency').attr('required', 'required').attr('disable', 'false');

            }

        });
        if ($("input[name='package_for']:checked").val() !== 'Agency') {
            $('#agency_block').slideUp();
            $('#agency').removeAttr('required').attr('disable', 'true');
        }
        if ($('.req-table').length > 0) {
            $('.req-table').DataTable(
                {
                    "scrollX": true,
                    "ordering": false,
                    // responsive: true
                }
            );
        }
        if ($('.sub-table').length > 0) {
            $('.sub-table').DataTable(
                {
                    "scrollX": true,
                    "ordering": false,
                    // responsive: true
                }
            );
        }

        $('#package-modal').on('show.bs.modal', function (event) {
            let record_id = $(event.relatedTarget).data('record-id');
            console.log(record_id);
            $(this).find('.modal-body #record-id').val(record_id);
        });


        let form = $('.package-form');
        $.validator.addMethod('empty', function (value, element, param) {
            return (value === '');
        });
        form.validate({
            rules: {
                'package': {
                    required: true
                },
                agency: {
                    required: function (element) {
                        return $('input[name=package_for]:checked').val() === 'Agency';
                    },
                },
                'property-count': {
                    required: true,
                    min: 1
                }

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
        // $(".custom-file-input").on("change", function () {
        //     var fileName = $(this).val().split("\\").pop();
        //     $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        // });
    });
})(jQuery);
