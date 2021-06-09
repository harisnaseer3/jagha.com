(function ($) {

    $(document).ready(function () {
        function check_package_for() {
            $(document).on('change', "input[name='package_for']", function () {
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
        }


        let form1 = $('.package-user-form');
        form1.validate({
            rules: {
                'user_email': {
                    required: true,
                    email: true,
                },

            },
            errorElement: 'span',
            errorClass: 'error help-block text-red',
            ignore: [],
            submitHandler: function (form) {
                // form.submit();
                event.preventDefault();
                sendRequest();
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
                }
            }
        });

        function sendRequest() {
            let user_mail = $('input[name="user_email"]').val();
            $('.package-spinner').toggle();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/packages/get-complementary-package-user',
                data: {'email': user_mail},
                dataType: 'json',
                success: function (data) {
                    $('.package-spinner').toggle();
                    $('#details_tab').slideUp();

                    if (data.status === '200') {
                        $('#details_tab').slideDown();

                        $('#details_tab').html(data.view).show();
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
                        $('[name=status]').parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});
                        check_package_for();
                    } else {
                        alert('User not found');
                    }
                },
            });
        }

        let form = $('#com-package-form');

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
                        if ($('input[name="package_for"]').length > 0)
                            return $('input[name=package_for]:checked').val() === 'Agency';
                        else
                            return false;
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
                status: {
                    required: true,
                },
                'is_complementary': {required: true,}
            },
            errorElement: 'span',
            errorClass: 'error help-block text-red',
            ignore: [],
            submitHandler: function (form) {
                form.submit();
                // console.log();
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

        //to change muted text of amount to show spinner
        // $('input[name=amount]').parent().next('div').html('llflfl');
        let property_count = $('input[name="property_count"]');
        let duration = $('input[name="duration"]');
        let duration_val = duration.val();
        let count_val = property_count.val();

        $(document).on('change', '#package', function () {
            callPropertyCount();
        });

        function callPropertyCount() {
            if ($('input[name="property_count"]').val() > 0 && $('input[name="duration"]').val() > 0) {
                getAmount();
            }
        }

        $(document).on('keyup', property_count, function () {
            callPropertyCount();
        });

        $(document).on('keyup', duration, function () {
            if ($('input[name="duration"]').val() > 0) {
                getAmount()
            }

        });

        function getAmount() {
            let pack_for = $('input[name=package_for]:checked').val();
            let pack_type = $('select[name=package] option:selected').val();
            duration_val = $('input[name="duration"]').val();
            count_val = $('input[name="property_count"]').val();

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
                        // console.log(data);
                        if (data.status === 200) {
                            $('input[name=amount]').parent().next('div').html('Package Amount in Rs.');
                            $('input[name=amount]').val(data.result.price);
                            $('input[name=unit_amount]').val(data.result.unit_price);
                            // $('#submit-block').html('<input class="btn btn-primary btn-md search-submit-btn" id="buy-btn" type="submit" value="Buy">')

                        }
                    },

                    complete: function (url, options) {

                    }
                });
            } else if (pack_type === '-1') {
                alert('Please Select Package Type');
                // property_count.val(0);
            }
        }


        // $(".custom-file-input").on("change", function () {
        //     var fileName = $(this).val().split("\\").pop();
        //     $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        // });


        // var navListItems = $('div.setup-panel div a'),
        //     allWells = $('.setup-content'),
        //     allNextBtn = $('.nextBtn');
        //
        // allWells.hide();
        //
        // navListItems.click(function (e) {
        //     e.preventDefault();
        //     var $target = $($(this).attr('href')),
        //         $item = $(this);
        //
        //     if (!$item.hasClass('disabled')) {
        //         navListItems.removeClass('btn-success').addClass('btn-default btn-disabled').attr('disabled', true);
        //         $item.addClass('btn-success').removeClass('btn-disabled').attr('disabled', false);
        //         allWells.hide();
        //         $target.show();
        //         $target.find('input:eq(0)').focus();
        //     }
        // });
        //
        // allNextBtn.on('click', function (e) {
        //     var curStep = $(this).closest(".setup-content"),
        //         curStepBtn = curStep.attr("id"),
        //         nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
        //         curInputs = curStep.find("input[type='text'],input[type='url']"),
        //         isValid = true;
        //
        //     // $(".form-group").removeClass("has-error");
        //     // for (var i = 0; i < curInputs.length; i++) {
        //     //     if (!curInputs[i].validity.valid) {
        //     //         isValid = false;
        //     //         $(curInputs[i]).closest(".form-group").addClass("has-error");
        //     //     }
        //     // }
        //     // e.preventDefault();
        //     let form = $('.package-form');
        //     $.validator.addMethod('empty', function (value, element, param) {
        //         return (value === '');
        //     });
        //     console.log('hi');
        //     form.validate({
        //         rules: {
        //             'package': {
        //                 required: true
        //             },
        //             agency: {
        //                 required: function (element) {
        //                     return $('input[name=package_for]:checked').val() === 'Agency';
        //                 },
        //             },
        //             'property-count': {
        //                 required: true,
        //                 min: 1
        //             },
        //             'duration': {
        //                 required: true,
        //                 min: 1
        //             },
        //
        //         },
        //         errorElement: 'span',
        //         errorClass: 'error help-block text-red',
        //         ignore: [],
        //         // submitHandler: function (form) {
        //         //     form.submit();
        //         // },
        //         // invalidHandler: function (event, validator) {
        //         //     // 'this' refers to the form
        //         //     const errors = validator.numberOfInvalids();
        //         //     if (errors) {
        //         //         console.log('ll');
        //         //         let error_tag = $('div.error.text-red.invalid-feedback.mt-2');
        //         //         error_tag.hide();
        //         //         const message = errors === 1
        //         //             ? 'You missed 1 field. It has been highlighted'
        //         //             : 'You missed ' + errors + ' fields. They have been highlighted';
        //         //         $('div.error.text-red.invalid-feedback strong').html(message);
        //         //         error_tag.show();
        //         //     } else {
        //         //         // $('#submit-block').show();
        //         //         $('div.error.text-red.invalid-feedback').hide();
        //         //         // if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
        //         //         nextStepWizard.removeAttr('disabled').trigger('click');
        //         //     }
        //         // }
        //     });
        //     if ((!form.valid())) {
        //         return false;
        //     } else {
        //         nextStepWizard.removeAttr('disabled').trigger('click');
        //
        //         $('#paypalbtn').text('Pay Rs. ' + $('input[name=amount]').val() + ' with Paypal');
        //     }
        // });
        //
        // $('div.setup-panel div a.btn-success').trigger('click');
    });
})(jQuery);
