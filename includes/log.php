<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function text2image_generator_error_log($message) {
    if (get_option('text2image_generator_enable_logging')) {
        $timestamp = gmdate('[Y-m-d H:i:s]');
        $log_message = $timestamp . ' ' . $message . "\n";
        error_log($log_message, 3, TEXT2IMAGE_GENERATOR_LOG_FILE);
    }
}