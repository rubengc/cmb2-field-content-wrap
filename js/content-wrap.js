(function($){
    $('body').on('click', '.cmb2-content-wrap-field-switch .button', function(e) {
        e.preventDefault();

        var wrap = $(this).closest('.cmb2-content-wrap');

        // Reset all values on change mode
        wrap.find('input').val('');

        if( wrap.hasClass('cmb2-content-wrap-multiple') ) {
            wrap.removeClass('cmb2-content-wrap-multiple').addClass('cmb2-content-wrap-single');

            $(this).find('i').attr('class', 'dashicons dashicons-editor-expand');
        } else {
            wrap.removeClass('cmb2-content-wrap-single').addClass('cmb2-content-wrap-multiple');

            $(this).find('i').attr('class', 'dashicons dashicons-editor-contract');
        }
    });
})(jQuery);