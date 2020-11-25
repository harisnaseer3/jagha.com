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
            $.validator.addMethod("checkcellnum", function (value) {
                return /^\+92-3\d{2}\d{7}$/.test(value);
            });


            $(document).ready(function () {
                $("input[name='cell']").keyup(function () {
                    $(this).val($(this).val().replace(/^(\d{1})(\d+)$/, "+92-$2"));
                });
                let form = $('#registrationForm');
                form.validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        cell: {
                            required: true,
                            checkcellnum: true,
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
                        cell: {
                            checkcellnum: "Please enter a valid value. (03001234567)"
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
