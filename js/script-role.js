(function ($) {

    $(document).ready(function () {
        $('.alert').fadeOut(3000);

        $('.data-insertion-form').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
            },
            errorElement: 'small',
            errorClass: 'help-block text-red',
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
                }
            }
        });
    });

})(jQuery);
