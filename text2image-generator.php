<?php
/**
 * Plugin Name: Text2Image Generator
 * Description: AI Generates an image based on the text provided in the settings and set it as featured image automatically when the post is published
 * Version: 1.0
 * Author Email: Zukamimozu@protonmail.com
 * Author: Anonymous_Producer
 * License: MIT
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Constants
define('TEXT2IMAGE_GENERATOR_API_URL', 'https://api.openai.com/v1/images/generations');
define('TEXT2IMAGE_GENERATOR_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TEXT2IMAGE_GENERATOR_LOG_FILE', TEXT2IMAGE_GENERATOR_PLUGIN_DIR . 'text2image_generator.log');

// Add the settings page to the admin menu
function text2image_generator_menu() {
    add_options_page(
        'Text2Image Generator Settings',
        'Text2Image Generator',
        'manage_options',
        'text2image-generator',
        'text2image_generator_settings_page'
    );
}
add_action('admin_menu', 'text2image_generator_menu');

// Display the settings page
function text2image_generator_settings_page() {
    ?>
    <div class="wrap">
        <h1>Text2Image Generator Settings</h1>
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
                            <option value="256x256" <?php selected(get_option('text2image_generator_size'), '256x256'); ?>>256x256</option>
                            <option value="512x512" <?php selected(get_option('text2image_generator_size'), '512x512'); ?>>512x512</option>
                            <option value="1024x1024" <?php selected(get_option('text2image_generator_size'), '1024x1024'); ?>>1024x1024</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Include Title</th>
                    <td><input type="checkbox" name="text2image_generator_include_title" value="1" <?php checked(1, get_option('text2image_generator_include_title'), true); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Include Category</th>
                    <td><input type="checkbox" name="text2image_generator_include_category" value="1" <?php checked(1, get_option('text2image_generator_include_category'), true); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Include Tag</th>
                    <td><input type="checkbox" name="text2image_generator_include_tag" value="1" <?php checked(1, get_option('text2image_generator_include_tag'), true); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Enable Translation</th>
                    <td><input type="checkbox" name="text2image_generator_enable_translation" value="1" <?php checked(1, get_option('text2image_generator_enable_translation'), true); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Prompt</th>
                    <td><textarea name="text2image_generator_prompt" maxlength="1000" rows="5" cols="50"><?php echo esc_textarea(get_option('text2image_generator_prompt')); ?></textarea></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Enable Logging</th>
                    <td><input type="checkbox" name="text2image_generator_enable_logging" value="1" <?php checked(1, get_option('text2image_generator_enable_logging'), true); ?> /></td>
                </tr>  
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register the settings
function text2image_generator_settings() {
    register_setting('text2image_generator_settings', 'text2image_generator_api_key');
    register_setting('text2image_generator_settings', 'text2image_generator_size');
    register_setting('text2image_generator_settings', 'text2image_generator_prompt');
    register_setting('text2image_generator_settings', 'text2image_generator_enable_logging');
    register_setting('text2image_generator_settings', 'text2image_generator_include_title');
    register_setting('text2image_generator_settings', 'text2image_generator_include_category');
    register_setting('text2image_generator_settings', 'text2image_generator_include_tag');
    register_setting('text2image_generator_settings', 'text2image_generator_enable_translation');
}
add_action('admin_init', 'text2image_generator_settings');

// Save the generated image as the featured image when a post is saved
function text2image_generator_on_insert_post_data($data, $postarr) {
    $post_id = $postarr['ID'];

    // Check if the post is a revision or an autosave
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        return $data;
    }

    // Check if the post is published
    if ($data['post_status'] !== 'publish') {
        return $data;
    }

    wp_schedule_single_event(time() + 1, 'text2image_generator_delayed_image_generation', array($post_id));

    return $data;
}
add_filter('wp_insert_post_data', 'text2image_generator_on_insert_post_data', 10, 2);

function text2image_generator_delayed_image_generation($post_id) {
    $image_url = text2image_generator_generate_image($post_id);
    if ($image_url) {
        text2image_generator_set_featured_image_from_url($post_id, $image_url);
    }

    if (get_option('text2image_generator_enable_logging')) {
        $post_categories = get_the_category($post_id);
        $category_names = array();
        if ($post_categories) {
            foreach ($post_categories as $category) {
                if ($category->name != 'Uncategorized') {
                    $category_names[] = $category->name;
                }
            }
        } else {
            text2image_generator_error_log('Text2Image Generator - Post ID: ' . $post_id . ' - No categories found');
        }
        
        $post_tags = get_the_terms($post_id, 'post_tag');
        $tag_names = array();
        if ($post_tags) {
            foreach ($post_tags as $tag) {
                $tag_names[] = $tag->name;
            }
        } else {
            text2image_generator_error_log('Text2Image Generator - Post ID: ' . $post_id . ' - No tags found');
        }
    }
}
add_action('text2image_generator_delayed_image_generation', 'text2image_generator_delayed_image_generation', 10, 1);

// Translate text to English using ChatGPT
function text2image_generator_translate_text_to_english($text, $api_key) {
    $original_prompt = $text;
    $headers = array(
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $api_key
    );
    $request_args = array(
        'headers' => $headers,
        'body' => json_encode(array(
            'model' => 'text-davinci-003',
            'prompt' => 'Translate the following Japanese text to Engllish: "' . $text . '"',
            'temperature' => 0.3,
            'max_tokens' => 100,
            'top_p' => 1.0,
            'frequency_penalty' => 0.0,
            'presence_penalty' => 0.0
        )),
        'timeout' => 30,
        'method' => 'POST',
    );
    $response = wp_remote_post('https://api.openai.com/v1/completions', $request_args);
    $json = json_decode(wp_remote_retrieve_body($response), true);
    if ($json && isset($json['choices'][0]['text'])) {
        $translation = trim($json['choices'][0]['text']);
        return $translation;
    } else {
        return null;
    }
}

// Generate an image using the OpenAI API
function text2image_generator_generate_image($post_id) {
    $api_key = get_option('text2image_generator_api_key');
    $size = get_option('text2image_generator_size');
    $prompt = get_option('text2image_generator_prompt');
    $final_prompt = ""; 

    // 翻訳が有効な場合のみ、翻訳APIを呼び出します
    if (get_option('text2image_generator_enable_translation')) {
        $translated_prompt = text2image_generator_translate_text_to_english($final_prompt, $api_key);
        if ($translated_prompt !== null) {
            $final_prompt = $translated_prompt;
        }
    }

    // Get post details
    $post = get_post($post_id);
    $post_title = wp_strip_all_tags($post->post_title);

    $post_categories = get_the_terms($post_id, 'category');
    $category_names = array();
    if ($post_categories && !is_wp_error($post_categories)) {
        foreach ($post_categories as $category) {
            if ($category->name != 'Uncategorized') {
                $category_names[] = wp_strip_all_tags($category->name);
            }
        }
    }

    $post_tags = get_the_terms($post_id, 'post_tag');
    $tag_names = array();
    if ($post_tags && !is_wp_error($post_tags)) {
        foreach ($post_tags as $tag) {
            $tag_names[] = wp_strip_all_tags($tag->name);
        }
    }

    // Include the post title, categories, and tags in the prompt if the corresponding options are enabled
    $prompt_parts = [];
    if (get_option('text2image_generator_include_title')) {
        $prompt_parts[] = $post_title;
    }
    if (get_option('text2image_generator_include_category') && !empty($category_names)) {
        $prompt_parts[] = implode(', ', $category_names);
    }
    if (get_option('text2image_generator_include_tag') && !empty($tag_names)) {
        $prompt_parts[] = implode(', ', $tag_names);
    }
    $prompt_parts[] = $prompt;

    $final_prompt = implode(', ', $prompt_parts);
    $original_prompt = $final_prompt;

    // 翻訳が有効な場合のみ、翻訳APIを呼び出します
    if (get_option('text2image_generator_enable_translation')) {
        $translated_prompt = text2image_generator_translate_text_to_english($final_prompt, $api_key);
    if ($translated_prompt !== null) {
        $final_prompt = $translated_prompt;
    }
}

    // Log the original prompt
    if (get_option('text2image_generator_enable_logging')) {
        text2image_generator_error_log('Text2Image Generator - Post ID: ' . $post_id . ' - Original Prompt: ' . $original_prompt);
    }

    // Log the translated prompt
    if (get_option('text2image_generator_enable_logging')) {
        text2image_generator_error_log('Text2Image Generator - Post ID: ' . $post_id . ' - Translated Prompt: ' . $final_prompt);
    }

    $headers = array(
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $api_key
    );

    $request_args = array(
        'headers' => $headers,
        'body' => json_encode(array(
            'model' => 'image-alpha-001',
            'prompt' => $final_prompt,
            'num_images' => 1,
            'size' => $size,
            'response_format' => 'url'
        )),
        'timeout' => 30,
        'method' => 'POST',
    );

    // Send the API request
    $response = wp_remote_post(TEXT2IMAGE_GENERATOR_API_URL, $request_args);
    $json = json_decode(wp_remote_retrieve_body($response), true);

    // Log the API response
    if (get_option('text2image_generator_enable_logging')) {
        text2image_generator_error_log('Text2Image Generator - Post ID: ' . $post_id . ' - API Response: ' . wp_remote_retrieve_body($response));
    }
    
    // Check if logging is enabled
    if (get_option('text2image_generator_enable_logging')) {
        $log_message = 'Text2Image Generator - Post ID: ' . $post_id . ' - ';
        if ($json && isset($json['data'][0]['url'])) {
            $log_message .= 'Image generation succeeded';
        } else {
            $log_message .= 'Image generation failed';
        }
        text2image_generator_error_log($log_message);
    }

    // Check if the JSON response has the image URL and return it
    if ($json && isset($json['data'][0]['url'])) {
        return $json['data'][0]['url'];
    } else {
        return null;
    }
}

// Set the featured image for a post from a given URL
function text2image_generator_set_featured_image_from_url($post_id, $image_url) {
    $post = get_post($post_id);
    $post_title = $post->post_title;

    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    $media = media_sideload_image($image_url, $post_id, $post_title, 'src');
    if (!is_wp_error($media)) {
        $args = array(
            'post_type' => 'attachment',
            'posts_per_page' => 1,
            'post_status' => 'any',
            'post_parent' => $post_id,
        );
        $attachments = get_posts($args);
        if ($attachments) {
            $attachment = $attachments[0];
            if (set_post_thumbnail($post_id, $attachment->ID)) {
                text2image_generator_error_log('Featured Image Set - Post ID: ' . $post_id);
            } else {
                text2image_generator_error_log('Mission Failed - Post ID: ' . $post_id . ' - Failed to set featured image');
            }
        } else {
            text2image_generator_error_log('Mission Failed - Post ID: ' . $post_id . ' - No attachment found');
        }
    } else {
        text2image_generator_error_log('Mission Failed - Post ID: ' . $post_id . ' - Error in media_sideload_image');
    }
}

// Error Log のパスを設定する
function text2image_generator_error_log($message) {
    if (!get_option('text2image_generator_enable_logging')) {
        return;
    }

    $plugin_directory = plugin_dir_path(__FILE__);
    $log_file = $plugin_directory . 'log.log';

    $date = date('Y-m-d H:i:s');
    $clean_message = wp_strip_all_tags($message);
    $log_message = $date . ' - ' . $clean_message . "\n";

    file_put_contents($log_file, $log_message, FILE_APPEND);
}