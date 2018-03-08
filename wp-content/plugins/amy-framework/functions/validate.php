<?php
defined( 'ABSPATH' ) or die;

/**
 *
 * Email validate
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_validate_email' ) ) {
	function amy_validate_email( $value, $field ) {
		if ( ! sanitize_email( $value ) ) {
			return __( 'Please write a valid email address!', 'amy-framework' );
		}
	}

	add_filter( 'amy_validate_email', 'amy_validate_email', 10, 2 );
}

/**
 *
 * Numeric validate
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_validate_numeric' ) ) {
	function amy_validate_numeric( $value, $field ) {
		if ( ! is_numeric( $value ) ) {
			return __( 'Please write a numeric data!', 'amy-framework' );
		}
	}

	add_filter( 'amy_validate_numeric', 'amy_validate_numeric', 10, 2 );
}

/**
 *
 * Required validate
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'amy_validate_required' ) ) {
	function amy_validate_required( $value ) {
		if ( empty( $value ) ) {
			return __( 'Fatal Error! This field is required!', 'amy-framework' );
		}
	}

	add_filter( 'amy_validate_required', 'amy_validate_required' );
}
