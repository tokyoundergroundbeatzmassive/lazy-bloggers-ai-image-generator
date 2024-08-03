<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Generate an image using the OpenAI API
function text2image_generator_generate_image($post_id) {
    $api_key = get_option('text2image_generator_api_key');
    $size = get_option('text2image_generator_size');
    $style_prompt = get_option('text2image_generator_style_prompt');
    $final_prompt = ""; 

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
    $prompt_parts[] = $style_prompt;

    $final_prompt = implode(', ', $prompt_parts);

    // Log the prompt
    if (get_option('text2image_generator_enable_logging')) {
        text2image_generator_error_log('Text2Image Generator - Post ID: ' . $post_id . ' - Prompt: ' . $final_prompt);
    }

    $headers = array(
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $api_key
    );

    $request_args = array(
        'headers' => $headers,
        'body' => json_encode(array(
            'prompt' => $final_prompt,
            'n' => 1,
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

    // Check if the JSON response has the image URL and return it with the post title
    if ($json && isset($json['data'][0]['url'])) {
        return array($json['data'][0]['url'], $post_title);
    } else {
        return null;
    }
}