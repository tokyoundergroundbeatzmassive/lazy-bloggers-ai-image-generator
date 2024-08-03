<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Log errors to a file
 *
 * @param string $message The error message to log
 */
function text2image_generator_error_log($message) {
    if (get_option('text2image_generator_enable_logging')) {
        $timestamp = date('[Y-m-d H:i:s]');
        $log_message = $timestamp . ' ' . $message . "\n";
        error_log($log_message, 3, TEXT2IMAGE_GENERATOR_LOG_FILE);
    }
}

/**
 * Sanitize and validate the API key
 *
 * @param string $api_key The API key to validate
 * @return string The sanitized API key
 */
function text2image_generator_sanitize_api_key($api_key) {
    return sanitize_text_field($api_key);
}

/**
 * Check if the API key is valid
 *
 * @param string $api_key The API key to check
 * @return boolean True if the API key is valid, false otherwise
 */
function text2image_generator_is_api_key_valid($api_key) {
    // This is a simple check. You might want to implement a more robust validation
    return !empty($api_key) && strlen($api_key) > 20;
}

/**
 * Get the plugin version
 *
 * @return string The plugin version
 */
function text2image_generator_get_version() {
    $plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
    return $plugin_data['Version'];
}

/**
 * Check if debug mode is enabled
 *
 * @return boolean True if debug mode is enabled, false otherwise
 */
function text2image_generator_is_debug_mode() {
    return defined('WP_DEBUG') && WP_DEBUG;
}

/**
 * Truncate a string to a specified length
 *
 * @param string $string The string to truncate
 * @param int $length The maximum length of the string
 * @param string $append The string to append if truncated (default: '...')
 * @return string The truncated string
 */
function text2image_generator_truncate_string($string, $length, $append = '...') {
    if (strlen($string) > $length) {
        $string = substr($string, 0, $length - strlen($append)) . $append;
    }
    return $string;
}

/**
 * Convert array to comma-separated string
 *
 * @param array $array The array to convert
 * @return string The comma-separated string
 */
function text2image_generator_array_to_string($array) {
    return implode(', ', array_filter($array));
}

/**
 * Check if a string is JSON
 *
 * @param string $string The string to check
 * @return boolean True if the string is valid JSON, false otherwise
 */
function text2image_generator_is_json($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}