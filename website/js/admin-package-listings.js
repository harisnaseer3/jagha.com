(function ($) {

    $(document).ready(function () {
        // Initialize Select2 Elements
        if ($('.select2').length > 0) {
            $('.select2').select2({
                language: '{{app()->getLocale()}}',
                direction: '{{app()->getLocale() === "en" ? "ltr" : "rtl"}}',
            });
            $('.select2bs4').select2({
                language: '{{app()->getLocale()}}',
                direction: '{{app()->getLocale() === "en" ? "ltr" : "rtl"}}',
                theme: 'bootstrap4',
            });
            $('[name=status]').parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});
        }

        // $('[name=agency]').parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});
        //
        // $("input[name='package_for']").on('change', function () {
        //     let selected_value = $(this).val();
        //     if (selected_value !== 'Agency') {
        //         $('#agency_block').slideUp();
        //         $('#agency').val('').removeAttr('required').attr('disable', 'true');
        //     } else {
        //         $('#agency_block').slideDown();
        //         $('#agency').attr('required', 'required').attr('disable', 'false');
        //
        //     }
        //
        // });
        // if ($("input[name='package_for']:checked").val() !== 'Agency') {
        //     $('#agency_block').slideUp();
        //     $('#agency').val('').removeAttr('required').attr('disable', 'true');
        // }
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

        let rejection_input = $('[name=rejection_reason]');
        let rejection_div = $('#reason-of-rejection');
        if ($("#status option:selected").text() === 'Rejected') {
            rejection_input.attr('required', 'required').attr('disable', 'false');
            rejection_div.slideDown();
        }

        $('#status').on('change', function (e) {

            if ($("#status option:selected").text() === 'Rejected') {
                rejection_input.attr('required', 'required').attr('disable', 'false');
                rejection_div.slideDown();
            } else {
                rejection_input.removeAttr('required').attr('disable', 'true');
                rejection_input.val('');
                rejection_div.slideUp();
            }
        });

        $('#package-modal').on('show.bs.modal', function (event) {
            let record_id = $(event.relatedTarget).data('record-id');
            $(this).find('.modal-body #record-id').val(record_id);
        });

        let form = $('.package-form');
        if (form.length > 0) {
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
                    },
                    'duration': {
                        required: true,
                        min: 1
                    }, 'rejection_reason': {
                        required: function (element) {
                            return $('select[name=status]').val() === 'rejected';
                        },
                    }

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
        }


    });
})(jQuery);
