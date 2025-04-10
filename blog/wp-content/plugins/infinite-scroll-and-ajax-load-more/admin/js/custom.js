(function( $ ) {
 
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('.color-field').wpColorPicker();
    });
    $('.remove_image_button').click(function() {
        var answer = confirm('Are you sure?');
        if (answer == true) {
            $(this).parents('.bl-img-show').find('.bl-image-preview').attr('src', '');
            $(this).parents('.bl-img-show').find('.bl_image_attachment_id').val('');
            $(this).parents('.image-preview-wrapper').removeClass('bl-img-show');
        }
        return false;
    });

})( jQuery );