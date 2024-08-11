<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function text2image_generator_add_main_menu() {
    global $menu;
    $menu_slug = 'tubm-plugins';

    $menu_exists = false;
    foreach ($menu as $item) {
        if ($item[2] === $menu_slug) {
            $menu_exists = true;
            break;
        }
    }
    
    if (!$menu_exists) {
        add_menu_page(
            'TUBM Plugins',
            'TUBM Plugins',
            'manage_options',
            $menu_slug,
            '',
            'dashicons-admin-plugins',
            30
        );
    }
}
add_action('admin_menu', 'text2image_generator_add_main_menu', 9);

function text2image_generator_add_submenu() {
    add_submenu_page(
        'tubm-plugins',
        'Lazy Blogger\'s AI Image Generator Settings',
        'Lazy Blogger\'s AI Image Generator',
        'manage_options',
        'text2image-generator',
        'text2image_generator_settings_page'
    );
}
add_action('admin_menu', 'text2image_generator_add_submenu');

function text2image_generator_remove_default_submenu() {
    remove_submenu_page('tubm-plugins', 'tubm-plugins');
}
add_action('admin_menu', 'text2image_generator_remove_default_submenu', 999);

function text2image_generator_settings_page() {
    ?>
    <div class="wrap">
        <h1>Lazy Blogger's AI Image Generator Settings Page</h1>
        <div class="plugin-description-small">
            <p style="font-size: 12px;">This plugin works in conjunction with the DALL-E3 API to generate large-sized image files in .png format.<br>
            Therefore, we recommend using <a href="https://shortpixel.com/otp/af/QALRSBX1137437" target="_blank">ShortPixel Image Optimizer</a> (we may receive a commission if you sign up and purchase credit).<br>
            It can automatically convert images to .jpg, .webp, .avif and so on... compress them, reducing file size by up to 90%.<br>
            You get 100 free credits every month!</p>
            <p style="font-size: 12px; font-weight: bold;">Note: This plugin requires an <a href="https://platform.openai.com/account/api-keys" target="_blank">OpenAI API key</a> to function!</p>
        </div>
        <form method="post" action="options.php">
            <?php
            settings_fields('text2image_generator_settings');
            do_settings_sections('text2image_generator_settings');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">API Key</th>
                    <td><input type="text" name="text2image_generator_api_key" value="<?php echo esc_attr(get_option('text2image_generator_api_key')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Size</th>
                    <td>
                        <select name="text2image_generator_size">
                            <option value="1024x1024" <?php selected(get_option('text2image_generator_size'), '1024x1024'); ?>>1024x1024</option>
                            <option value="1024x1792" <?php selected(get_option('text2image_generator_size'), '1024x1792'); ?>>1024x1792</option>
                            <option value="1792x1024" <?php selected(get_option('text2image_generator_size'), '1792x1024'); ?>>1792x1024</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top" class="diable-when-function-calling">
                    <th scope="row">Include Title</th>
                    <td><input type="checkbox" name="text2image_generator_include_title" value="1" <?php checked(1, get_option('text2image_generator_include_title'), true); ?> /></td>
                </tr>
                <tr valign="top" class="diable-when-function-calling">
                    <th scope="row">Include Category</th>
                    <td><input type="checkbox" name="text2image_generator_include_category" value="1" <?php checked(1, get_option('text2image_generator_include_category'), true); ?> /></td>
                </tr>
                <tr valign="top" class="diable-when-function-calling">
                    <th scope="row">Include Tags</th>
                    <td><input type="checkbox" name="text2image_generator_include_tag" value="1" <?php checked(1, get_option('text2image_generator_include_tag'), true); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Create prompt from the post content</th>
                    <td><input type="checkbox" id="text2image_generator_use_post_content" name="text2image_generator_use_post_content" value="1" <?php checked(1, get_option('text2image_generator_use_post_content'), true); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Additional (Style) Prompt</th>
                    <td><textarea name="text2image_generator_style_prompt" maxlength="1000" rows="5" cols="50"><?php echo esc_textarea(get_option('text2image_generator_style_prompt')); ?></textarea></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Enable Logging</th>
                    <td><input type="checkbox" name="text2image_generator_enable_logging" value="1" <?php checked(1, get_option('text2image_generator_enable_logging'), true); ?> /></td>
                </tr>  
            </table>
            <?php submit_button(); ?>
        </form>
    </div>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        function toggleOptionalSettings() {
            var usePostContent = $('#text2image_generator_use_post_content').is(':checked');
            $('.diable-when-function-calling').each(function() {
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

        $('form').submit(function() {
            $('.diable-when-function-calling input:disabled').prop('disabled', false);
        });
    });
    </script>
    <?php
}

function text2image_generator_settings() {
    register_setting('text2image_generator_settings', 'text2image_generator_api_key');
    register_setting('text2image_generator_settings', 'text2image_generator_size');
    register_setting('text2image_generator_settings', 'text2image_generator_style_prompt');
    register_setting('text2image_generator_settings', 'text2image_generator_enable_logging');
    register_setting('text2image_generator_settings', 'text2image_generator_include_title');
    register_setting('text2image_generator_settings', 'text2image_generator_include_category');
    register_setting('text2image_generator_settings', 'text2image_generator_include_tag');
    register_setting('text2image_generator_settings', 'text2image_generator_use_post_content');
}
add_action('admin_init', 'text2image_generator_settings');