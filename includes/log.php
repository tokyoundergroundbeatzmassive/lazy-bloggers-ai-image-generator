<?php
/**
 * Logging for this plugin.
 *
 * @package Lazy_Bloggers_AI_Image_Generator
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Log an error message
 *
 * @param string $message The message to be logged.
 */
function text2image_generator_error_log( $message ) {
	if ( get_option( 'text2image_generator_enable_logging' ) ) {
		$timestamp   = gmdate( '[Y-m-d H:i:s]' );
		$log_message = $timestamp . ' ' . $message . "\n";

		text2image_generator_handle_log( $log_message );
	}
}

/**
 * Handle the logging action
 *
 * @param string $log_message The message to be logged.
 */
function text2image_generator_handle_log( $log_message ) {
	global $wp_filesystem;

	if ( empty( $wp_filesystem ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
	}

	if ( $wp_filesystem ) {
		$log_file = TEXT2IMAGE_GENERATOR_LOG_FILE;

		if ( ! $wp_filesystem->exists( $log_file ) ) {
			$wp_filesystem->put_contents( $log_file, '', FS_CHMOD_FILE );
		}

		$existing_content = $wp_filesystem->get_contents( $log_file );
		$new_content      = $existing_content . $log_message;
		$wp_filesystem->put_contents( $log_file, $new_content, FS_CHMOD_FILE );
	}
}
