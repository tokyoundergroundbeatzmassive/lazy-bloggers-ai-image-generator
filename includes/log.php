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
		$log_message = $timestamp . ' ' . $message;

		$logs   = get_option( 'text2image_generator_logs', array() );
		$logs[] = $log_message;

		$logs = array_slice( $logs, -100 );

		update_option( 'text2image_generator_logs', $logs );
	}
}
