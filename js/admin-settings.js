jQuery(document).ready(function ($) {
    function toggleOptionalSettings() {
        var usePostContent = $('#text2image_generator_use_post_content').is(':checked');
        $('.diable-when-function-calling').each(function () {
            var inputs = $(this).find('input');
            if (usePostContent) {
                $(this).css('opacity', '0.5');
                inputs.prop('disabled', true);
            } else {
                $(this).css('opacity', '1');
                inputs.prop('disabled', false);
            }
        });
    }

    $('#text2image_generator_use_post_content').change(toggleOptionalSettings);
    toggleOptionalSettings();

    $('form').submit(function () {
        $('.diable-when-function-calling input:disabled').prop('disabled', false);
    });
});