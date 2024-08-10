<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use TikToken\Encoder;

function text2image_generator_count_tokens($post_content) {
    $encoder = new Encoder();
    $tokens = $encoder->encode($post_content);
    return count($tokens);
}

function text2image_generator_limit_tokens($post_content, $max_tokens = 100000) {
    $encoder = new Encoder();
    $tokens = $encoder->encode($post_content);
    
    if (count($tokens) <= $max_tokens) {
        return $post_content;
    }
    
    $limited_tokens = array_slice($tokens, 0, $max_tokens);
    
    $limited_post_content = $encoder->decode($limited_tokens);
    
    return $limited_post_content;
}