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
        $('[name=property-count]').parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});
        $('[name=duration]').parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});

        $("input[name='package_for']").on('change', function () {
            callPropertyCount();
            let selected_value = $(this).val();
            if (selected_value !== 'Agency') {
                $('#agency_block').slideUp();
                $('#agency').val('').removeAttr('required').attr('disable', 'true');
            } else {
                $('#agency_block').slideDown();
                $('#agency').attr('required', 'required').attr('disable', 'false');

            }

        });
        if ($("input[name='package_for']:checked").val() !== 'Agency') {
            $('#agency_block').slideUp();
            $('#agency').val('').removeAttr('required').attr('disable', 'true');
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
            $(this).find('.modal-body #record-id').val(record_id);
        });


        let form = $('.package-form');
        $(document).on('click', '#buy-btn', function () {
            form.submit();
        });

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
                },

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


        let property_count = $('select[name="property-count"]');
        let duration = $('select[name="duration"]');
        let duration_val = duration.val();
        let count_val = property_count.val();

        $('#package').on('change', function () {
            callPropertyCount();
        });

        function callPropertyCount() {
            count_val = $('select[name="property-count"] option:selected').val();
            duration = $('select[name="duration"] option:selected').val();
            if (count_val > 0 && duration > 0) {
                getAmount();
            }
        }

        $('#property-count').on('change', function () {

            count_val = $(this).val();
            duration = $('select[name="duration"] option:selected').val();
            callPropertyCount();
        });
        $('#duration').on('change', function () {
            duration_val = $(this).val();
            count_val = $('select[name="property-count"] option:selected').val();
            if (duration_val > 0) {
                getAmount()
            }
        });


        function getAmount() {
            let pack_for = $('input[name=package_for]:checked').val();
            let pack_type = $('select[name=package] option:selected').val();
            if (pack_type !== '-1') {
                $('input[name=amount]').parent().next('div').html('<div>....</div>');
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    type: 'post',
                    url: window.location.origin + '/get-package-amount',
                    data: {'duration': duration_val, 'count': count_val, 'type': pack_type, 'for': pack_for},
                    dataType: 'json',
                    success: function (data) {
                        if (data.status === 200) {
                            $('input[name=amount]').parent().next('div').html('Package Amount in Rs.');
                            // $('input[name=amount]').val(data.result);
                            $('input[name=amount]').val(data.result.price);
                            $('input[name=unit_amount]').val(data.result.unit_price);
                            $('#submit-block').html('<input class="btn btn-primary btn-md search-submit-btn" id="buy-btn" type="submit" value="Buy">')

                        }
                    },

                });
            } else if (pack_type === '-1') {
                alert('Please Select Package Type');
            }
        }
    });
})(jQuery);
