<?php
/**
 * Plugin Name: Text2Image Generator
 * Description: AI Generates an image based on the text provided in the settings and set it as featured image automatically when the post is published
 * Version: 1.3
 * Author Email: Zukamimozu@protonmail.com
 * Author: Anonymous_Producer
 * License: GPLv2 or later
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Constants
define('TEXT2IMAGE_GENERATOR_API_URL', 'https://api.openai.com/v1/images/generations');
define('TEXT2IMAGE_GENERATOR_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TEXT2IMAGE_GENERATOR_LOG_FILE', TEXT2IMAGE_GENERATOR_PLUGIN_DIR . 'text2image_generator.log');

// Include other files
require_once TEXT2IMAGE_GENERATOR_PLUGIN_DIR . 'includes/admin-settings.php';
require_once TEXT2IMAGE_GENERATOR_PLUGIN_DIR . 'includes/image-generation.php';
require_once TEXT2IMAGE_GENERATOR_PLUGIN_DIR . 'includes/utilities.php';
require_once TEXT2IMAGE_GENERATOR_PLUGIN_DIR . 'includes/set_featured_image.php';

// Save the generated image as the featured image when a post is published
function text2image_generator_on_transition_post_status($new_status, $old_status, $post) {
    $post_id = $post->ID;

    // Check if the post is a revision or an autosave
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        return;
    }

    // Check if the post is published
    if ($new_status !== 'publish' || $old_status === 'publish') {
        return;
    }

    wp_schedule_single_event(time() + 1, 'text2image_generator_delayed_image_generation', array($post_id));
}
add_action('transition_post_status', 'text2image_generator_on_transition_post_status', 10, 3);

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